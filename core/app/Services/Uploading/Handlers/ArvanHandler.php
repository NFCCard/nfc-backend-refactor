<?php

    namespace App\Services\Uploading\Handlers;

    use App\Helpers\Enums\BucketEnum;
    use App\Services\Contracts\Handler\Handler;
    use AWS;
    use Aws\S3\S3Client;
    use Hans\Alicia\Contracts\AliciaContract;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;
    use Throwable;

    class ArvanHandler extends Handler {
        private S3Client $s3;

        public function __construct( BucketEnum $bucket = BucketEnum::DEFAULT ) {
            parent::__construct( $bucket );
            $this->s3 = AWS::createClient( 's3',
                [
                    'endpoint'    => "https://s3.ir-thr-at1.arvanstorage.com",
                    'credentials' => [
                        'key'    => env( 'ARVAN_AWS_ACCESS_KEY_ID', '' ),
                        'secret' => env( 'ARVAN_AWS_SECRET_ACCESS_KEY', '' ),
                    ],
                ] );
        }

        public function putObject( Resource $resource ): ?bool {
            $retries = 1;
            do {
                try {
                    $result = $this->s3->putObject( [
                        'Bucket'     => $this->getBucket(),
                        'ACL'        => 'public-read',
                        'Key'        => $resource->file,
                        'SourceFile' => $resource->storagePath,
                    ] );
                } catch ( Throwable $e ) {
                    logg( static::class . '@putObject', $e );
                    $retries ++;
                    sleep( self::getWaitingDelay() );
                }

                if ( isset( $result ) and $result->get( '@metadata' )[ 'statusCode' ] ) {
                    logg( static::class, new \Exception, [ 'url' => $result->get( 'ObjectURL' ) ] );
                    if ( ! $resource->isExternal() ) {
                        $external_link = $result->get( 'ObjectURL' );
                        $resource->setOptions( [ 'bucket' => $this->getBucket() ] );
                        app( AliciaContract::class )->makeExternal( $resource, $external_link );
                    }
                    break;
                }
            } while ( self::getMaxRetries() >= $retries );

            return $this->next( $resource );
        }

        public function deleteObject( Resource $resource ): ?bool {
            $retries = 1;
            $resource->with( 'children' );
            $objects = collect( [ $resource->toArray() ] )->mapWithKeys( fn( array $data ) => [ [ 'Key' => $data[ 'file' ] ] ] );
            if ( $resource->children ) {
                $exports = $resource->children->mapWithKeys( fn( Resource $item, int $index ) => [ $index => [ 'Key' => $item->file ] ] );
                $objects = $objects->merge( $exports );
            }

            do {
                try {
                    $result = $this->s3->deleteObjects( [
                        'Bucket' => Arr::get( $resource->getOptions(), 'bucket', BucketEnum::DEFAULT->value ),
                        'Delete' => [
                            'Objects' => $objects->toArray()
                        ],
                    ] );
                } catch ( Throwable $e ) {
                    logg( static::class . '@deleteObject()', $e );
                    $retries ++;
                    sleep( self::getWaitingDelay() );
                }

                if ( isset( $result ) and $result->get( '@metadata' )[ 'statusCode' ] ) {
                    break;
                }
            } while ( self::getMaxRetries() >= $retries );

            return $this->next( $resource );
        }

        public function url( Resource $resource ): string {
            $baseUrl = "https://%.s3.ir-thr-at1.arvanstorage.com/%";
            $bucket  = Arr::get( $resource->getOptions(), 'bucket', BucketEnum::DEFAULT->value );

            return Str::replaceArray( "%", [ $bucket, $resource->file ], $baseUrl );
        }
    }
