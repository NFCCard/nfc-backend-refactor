<?php

    namespace App\Http\Controllers\V1\Core\User;

    use App\Exceptions\BaseException;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\V1\Core\User\UserStoreRequest;
    use App\Http\Requests\V1\Core\User\UserUpdateRequest;
    use App\Http\Resources\V1\Core\User\UserCollection;
    use App\Http\Resources\V1\Core\User\UserResource;
    use App\Models\Core\User;
    use App\Services\Core\User\UserCrudService;

    class UserCrudController extends Controller {
        private UserCrudService $service;

        public function __construct() {
            $this->service = app( UserCrudService::class );
        }

        /**
         * Display a listing of the resource.
         *
         * @return UserCollection
         */
        public function index(): UserCollection {
            return UserCollection::make( $this->service->all() );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param UserStoreRequest $request
         *
         * @return UserResource
         * @throws BaseException
         */
        public function store( UserStoreRequest $request ): UserResource {
            return UserResource::make( $this->service->create( $request->validated() ) );
        }

        /**
         * Display the specified resource.
         *
         * @param int $user
         *
         * @return UserResource
         */
        public function show( int $user ): UserResource {
            return UserResource::make( $this->service->find( $user ) );
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UserUpdateRequest $request
         * @param User              $user
         *
         * @return UserResource
         * @throws BaseException
         */
        public function update( UserUpdateRequest $request, User $user ): UserResource {
            return UserResource::make( $this->service->update( $user, $request->validated() ) );
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param User $user
         *
         * @return UserResource
         * @throws BaseException
         */
        public function destroy( User $user ) {
            return UserResource::make( $this->service->delete( $user ) );
        }
    }
