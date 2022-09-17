<?php

    namespace App\Http\Resources\V1\Core\Resource;

    use App\Exceptions\BaseException;
    use App\Services\Uploading\UploadingService;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;

    class ResourcesResource extends JsonResource {
        private Collection $exports;

        /**
         * Transform the resource into an array.
         *
         * @param Request $request
         *
         * @return array
         * @throws BaseException
         */
        public function toArray( $request ) {
            $resource = [
                'id'           => $this->id,
                'title'        => $this->title,
                'extension'    => $this->extension,
                'url'          => $this->isExternal() ? app( UploadingService::class )->generateUrl( $this->resource ) : $this->url,
                'options'      => [
                    'size'     => $this->options[ 'size' ],
                    'mimeType' => $this->options[ 'mimeType' ],
                    'width'    => $this->options[ 'width' ],
                    'height'   => $this->options[ 'height' ],
                ],
                'published_at' => $this->published_at,
            ];
            if ( isset( $this->exports ) ) {
                foreach ( $this->exports as $export ) {
                    $resource[ 'exports' ][] = self::make( $export );
                }
            } else {
                $this->resource->loadMissing( 'children' );
                foreach ( $this->resource->children as $child ) {
                    $resource[ 'exports' ][] = self::make( $child );
                }
            }

            return $resource;
        }

        public function setExports( Collection $exports ): self {
            $this->exports = $exports;

            return $this;
        }
    }
