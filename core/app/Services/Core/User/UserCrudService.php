<?php

    namespace App\Services\Core\User;

    use App\Exceptions\Core\User\UserException;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IUserRepository;
    use Illuminate\Contracts\Pagination\Paginator;

    class UserCrudService {
        private IUserRepository $repository;

        public function __construct() {
            $this->repository = app( IUserRepository::class );
        }

        public function all(): Paginator {
            return $this->repository->all()->applyFilters()->paginate();
        }

        public function find( int $model ): User {
            return $this->repository->find( $model );
        }

        public function create( array $data ): User {
            if ( $model = $this->repository->create( $data ) ) {
                return $model;
            }

            throw UserException::failedToCreate();
        }

        public function update( User $model, array $data ): User {
            if ( $this->repository->update( $model, $data ) ) {
                return $model;
            }

            throw UserException::failedToUpdate();
        }

        public function delete( User $model ): User {
            if ( $this->repository->delete( $model ) ) {
                return $model;
            }

            throw UserException::failedToDelete();
        }
    }
