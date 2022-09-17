<?php

    namespace App\Services\Core\User;

    use App\Exceptions\Core\User\UserException;
    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IUserRepository;

    class UserRelationsService {
        private IUserRepository $repository;

        public function __construct() {
            $this->repository = app( IUserRepository::class );
        }

        public function viewProfile( User $model ): Profile {
            if ( $related = $this->repository->viewProfile( $model ) ) {
                return $related;
            }

            throw UserException::doesntHaveProfile();
        }
    }
