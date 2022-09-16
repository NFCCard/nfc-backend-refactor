<?php

    namespace App\Http\Controllers\V1\Core\User;

    use App\Exceptions\BaseException;
    use App\Http\Controllers\Controller;
    use App\Http\Resources\V1\Core\Profile\ProfileResource;
    use App\Models\Core\User;
    use App\Services\Core\User\UserRelationsService;

    class UserRelationsController extends Controller {
        private UserRelationsService $service;

        public function __construct() {
            $this->service = app( UserRelationsService::class );
        }

        /**
         * View Profile relation of given model
         *
         * @throws BaseException
         */
        public function viewProfile( User $model ): ProfileResource {
            return ProfileResource::make( $this->service->viewProfile( $model ) );
        }
    }
