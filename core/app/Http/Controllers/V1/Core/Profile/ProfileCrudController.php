<?php

    namespace App\Http\Controllers\V1\Core\Profile;

    use App\Exceptions\BaseException;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\V1\Core\Profile\ProfileUpdateRequest;
    use App\Http\Resources\V1\Core\Profile\ProfileCollection;
    use App\Http\Resources\V1\Core\Profile\ProfileResource;
    use App\Models\Core\Profile;
    use App\Services\Core\Profile\ProfileCrudService;

    class ProfileCrudController extends Controller {
        private ProfileCrudService $service;

        public function __construct() {
            $this->service = app( ProfileCrudService::class );
        }

        /**
         * Display a listing of the resource.
         *
         * @return ProfileCollection
         */
        public function index(): ProfileCollection {
            return ProfileCollection::make( $this->service->all() );
        }

        /**
         * Display the specified resource.
         *
         * @param int $profile
         *
         * @return ProfileResource
         */
        public function show( int $profile ): ProfileResource {
            return ProfileResource::make( $this->service->find( $profile ) );
        }

        /**
         * Update the specified resource in storage.
         *
         * @param ProfileUpdateRequest $request
         * @param Profile              $profile
         *
         * @return ProfileResource
         * @throws BaseException
         */
        public function update( ProfileUpdateRequest $request, Profile $profile ): ProfileResource {
            return ProfileResource::make( $this->service->update( $profile, $request->validated() ) );
        }

    }
