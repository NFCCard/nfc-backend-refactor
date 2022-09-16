<?php

    namespace App\Services\Core\Profile;

    use App\Exceptions\Core\Profile\ProfileException;
    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IProfileRepository;

    class ProfileRelationsService {
        private IProfileRepository $repository;

        public function __construct() {
            $this->repository = app( IProfileRepository::class );
        }

        public function viewUser( Profile $model ): User {
            if ( $related = $this->repository->viewUser( $model ) ) {
                return $related;
            }

            throw ProfileException::doesntHaveUser();
        }

    }
