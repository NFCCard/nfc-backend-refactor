<?php

    namespace App\Services\Contracts\Handler;

    use App\Helpers\Enums\BucketEnum;
    use Hans\Alicia\Contracts\AliciaContract;
    use Hans\Alicia\Models\Resource;

    abstract class Handler {
        private Handler $nextHandler;
        private BucketEnum $bucket;

        public function __construct( BucketEnum $bucket = BucketEnum::DEFAULT ) {
            $this->bucket = $bucket;
        }

        public function setNext( Handler $handler ): Handler {
            $this->nextHandler = $handler;

            return $handler;
        }

        public function next( Resource $resource ): ?bool {
            $method = debug_backtrace()[ 1 ][ 'function' ];
            if ( isset( $this->nextHandler ) ) {
                return $this->nextHandler->{$method}( $resource );
            }

            if ( $resource->isExternal() and app( AliciaContract::class )->deleteFile( $resource->address ) ) {
                $resource->update( [
                    'path' => null,
                ] );
            }

            return null;
        }

        public function setBucket( BucketEnum $bucket ): static {
            $this->bucket = $bucket;

            return $this;
        }

        public function getBucket(): string {
            if ( env( 'APP_ENV', 'local' ) != 'production' ) {
                return 'dev-' . $this->bucket->value;
            }

            return $this->bucket->value;
        }

        protected static function getMaxRetries(): int {
            return 5;
        }

        protected static function getWaitingDelay(): int {
            return 10;
        }

        abstract public function putObject( Resource $resource ): ?bool;

        abstract public function deleteObject( Resource $resource ): ?bool;

        abstract public function url( Resource $resource ): string;
    }
