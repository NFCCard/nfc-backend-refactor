<?php

    namespace App\Services\Core\Profile;

    use App\Exceptions\Core\Profile\ProfileException;
    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IProfileRepository;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Support\Facades\DB;
    use Throwable;

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

        public function viewResource( Profile $model ): Resource {
            if ( $related = $this->repository->viewResource( $model ) ) {
                return $related;
            }

            throw ProfileException::doesntHaveResource();
        }

        public function updateResource( Profile $model, Resource $related ): Resource {
            $resource = $this->repository->viewResource( $model );
            DB::beginTransaction();
            try {
                if ( $resource and $resource->is( $related ) ) {
                    throw ProfileException::failedToUpdateResource();
                }

                throw_unless( $this->repository->updateResource( $model, $related ),
                    ProfileException::failedToUpdateResource() );
            } catch ( Throwable $e ) {
                DB::rollBack();
                throw $e;
            }
            DB::commit();

            return $related;
        }

    }
