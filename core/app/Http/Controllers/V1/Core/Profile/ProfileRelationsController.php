<?php

    namespace App\Http\Controllers\V1\Core\Profile;

    use App\Exceptions\BaseException;
    use App\Http\Controllers\Controller;
    use App\Http\Resources\V1\Core\Resource\ResourcesResource;
    use App\Http\Resources\V1\Core\User\UserResource;
    use App\Models\Core\Profile;
    use App\Services\Core\Profile\ProfileRelationsService;
    use Hans\Alicia\Models\Resource;

    class ProfileRelationsController extends Controller {
        private ProfileRelationsService $service;

        public function __construct() {
            $this->service = app( ProfileRelationsService::class );
        }

        /**
         * View User relation of given model
         *
         * @throws BaseException
         */
        public function viewUser( Profile $model ): UserResource {
            return UserResource::make( $this->service->viewUser( $model ) );
        }

        /**
         * View Resource relation of given model
         *
         * @throws BaseException
         */
        public function viewResource( Profile $model ): ResourcesResource {
            return ResourcesResource::make( $this->service->viewResource( $model ) );
        }

        /**
         * Update Resource relation of given model
         *
         * @throws \Throwable
         */
        public function updateResource( Profile $model, Resource $related ): ResourcesResource {
            return ResourcesResource::make( $this->service->updateResource( $model, $related ) );
        }


    }
