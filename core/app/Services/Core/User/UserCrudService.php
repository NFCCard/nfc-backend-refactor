<?php

    namespace App\Services\Core\User;

    use App\Exceptions\Core\User\UserException;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IUserRepository;
    use Illuminate\Contracts\Pagination\Paginator;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use RolesEnum;

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
            if ( isset( $data[ 'password' ] ) ) {
                $data[ 'password' ] = Hash::make( $data[ 'password' ] );
            }
            DB::beginTransaction();
            try {
                throw_unless( $model = $this->repository->create( $data ), UserException::failedToCreate() );
                $model->assignRole( $data[ 'role_id' ] ?? RolesEnum::DEFAULT_USERS, true );
            } catch ( \Throwable $e ) {
                DB::rollBack();
                throw $e;
            }
            DB::commit();

            return $model;
        }

        public function update( User $model, array $data ): User {
            if ( isset( $data[ 'password' ] ) ) {
                $data[ 'password' ] = Hash::make( $data[ 'password' ] );
            }
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
