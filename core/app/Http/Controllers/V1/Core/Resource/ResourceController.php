<?php

    namespace App\Http\Controllers\V1\Core\Resource;

    use App\Exceptions\BaseException;
    use App\Http\Controllers\Controller;
    use App\Http\Resources\V1\Core\Resource\ResourcesResource;
    use App\Services\Core\Resource\ResourceService;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Support\Collection;
    use Throwable;

    class ResourceController extends Controller {
        private ResourceService $service;

        public function __construct() {
            $this->service = app( ResourceService::class );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @return ResourcesResource
         * @throws Throwable
         */
        public function store( ): ResourcesResource {
            $data = $this->service->upload( 'resource' );
            if ( $data instanceof Collection ) {
                $model = $data->first()->first();
            } else {
                $model = $data;
            }

            return ResourcesResource::make( $model );
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Resource $resource
         *
         * @return ResourcesResource
         * @throws BaseException
         */
        public function destroy( Resource $resource ): ResourcesResource {
            return ResourcesResource::make( $this->service->delete( $resource ) );
        }
    }
