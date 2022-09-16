<?php

    namespace App\Services\Core\Resource;

    use App\Exceptions\Core\Resource\ResourceException;
    use App\Services\Uploading\UploadingService;
    use Hans\Alicia\Contracts\AliciaContract;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Support\Collection;
    use Throwable;

    class ResourceService {
        private AliciaContract $alicia;
        private UploadingService $uploading;

        public function __construct() {
            $this->alicia = app( AliciaContract::class );
        }

        public function upload( string $key ): Collection|Resource {
            try {
                $data = $this->alicia->upload( $key, [
                    'image',
                    'mimes:jpg,jpeg,png',
                    'max:' . (string) 2 * 1024
                ] )->getData();
            } catch ( Throwable $e ) {
                logg( static::class . '@upload', $e );
                throw $e;
            }

            return $data;
        }

        public function delete( int|Resource $resource ): Resource {
            $resource = $resource instanceof Resource ? $resource : Resource::findOrFail( $resource );
            if ( app( AliciaContract::class )->delete( $resource ) ) {
                return $resource;
            }

            throw ResourceException::failedToDelete();
        }

        public function batchDelete( Collection|array $ids ): bool {
            $ids = $ids instanceof Collection ? $ids->toArray() : $ids;
            foreach ( $ids as $id ) {
                $this->delete( $id );
            }

            return false;
        }

    }
