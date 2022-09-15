<?php

    namespace App\Services\Core\Profile;

    use App\Exceptions\Core\Profile\ProfileException;
    use App\Models\Core\Profile;
    use App\Repositories\Contracts\Core\IProfileRepository;
    use Illuminate\Contracts\Pagination\Paginator;

    class ProfileCrudService {
        private IProfileRepository $repository;

        public function __construct() {
            $this->repository = app( IProfileRepository::class );
        }

        public function all(): Paginator {
            return $this->repository->all()->applyFilters()->paginate();
        }

        public function find( int $model ): Profile {
            return $this->repository->find( $model );
        }

        public function update( Profile $model, array $data ): Profile {
            if ( $this->repository->update( $model, $data ) ) {
                return $model;
            }

            throw ProfileException::failedToUpdate();
        }

    }
