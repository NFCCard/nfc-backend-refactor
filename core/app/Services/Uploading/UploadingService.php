<?php

    namespace App\Services\Uploading;

    use App\Exceptions\BaseException;
    use App\Helpers\Enums\BucketEnum;
    use App\Jobs\Services\UploadingService\DeleteObjectJob;
    use App\Jobs\Services\UploadingService\PutObjectJob;
    use App\Services\Contracts\Handler\Handler;
    use App\Services\Uploading\Handlers\ArvanHandler;
    use App\Services\Uploading\Handlers\PoshtibanHandler;
    use Hans\Alicia\Models\Resource;
    use Throwable;

    class UploadingService {
        private array $handlers = [
            ArvanHandler::class,
            PoshtibanHandler::class,
        ];

        private BucketEnum $bucket;


        private Handler|null $handler;

        public function __construct( BucketEnum $bucket = BucketEnum::DEFAULT ) {
            $this->bucket = $bucket;
            $this->chaining();
        }

        public function upload( Resource $resource ): bool {
            try {
                PutObjectJob::dispatch( $resource, $this->getBucket() );
            } catch ( Throwable $e ) {
                logg( static::class . '@upload()', $e );

                return false;
            }

            return true;
        }

        public function delete( Resource $resource ): bool {
            try {
                DeleteObjectJob::dispatch( $resource );
            } catch ( Throwable $e ) {
                logg( static::class . '@delete()', $e );

                return false;
            }

            return true;
        }

        public function chaining( array $handlers = null ): self {
            $this->handler = null;
            $last          = null;
            foreach ( $handlers ?? $this->handlers as $handler ) {
                if ( ! class_exists( $handler ) ) {
                    continue;
                }
                if ( ! isset( $this->handler ) or is_null( $this->handler ) ) {
                    $this->handler = $last = new $handler( $this->getBucket() );
                } else {
                    $last = $last->setNext( new $handler( $this->getBucket() ) );
                }
            }

            return $this;
        }

        public function generateUrl( Resource $resource ): string {
            if ( ! isset( $this->handler ) ) {
                throw BaseException::make( "Cant make url!" );
            }

            return $this->handler->url( $resource );
        }

        public function setBucket( BucketEnum $bucket ): self {
            $this->bucket = $bucket;
            $this->chaining();

            return $this;
        }

        public function getBucket(): BucketEnum {
            return $this->bucket;
        }


        public function getHandler(): ?Handler {
            return $this->handler;
        }
    }
