<?php

    namespace App\Repositories\Contracts;

    use App\Services\Core\Resource\ResourceService;
    use Exception;
    use Hans\Alicia\Models\Resource;
    use Illuminate\Contracts\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Gate;
    use Throwable;

    abstract class Repository {
        abstract protected function getQueryBuilder(): Builder;

        protected function getModelClassName() {
            return get_class( $this->getQueryBuilder()->getModel() );
        }

        public function all(): Builder {
            Gate::authorize( $this->policy( 'viewAny' ), $this->getModelClassName() );

            return $this->getQueryBuilder();
        }

        public function find( Model|int $model ): Model {
            $model = $this->resolveModel( $model );
            Gate::authorize( $this->policy( 'view' ), $model );

            return $model;
        }

        public function delete( Model|int $model ): bool {
            $model = $this->resolveModel( $model );
            Gate::authorize( $this->policy(), $model );

            return $model->delete();
        }

        public function create( array $data ): Model {
            Gate::authorize( $this->policy(), $this->getModelClassName() );

            return $this->getQueryBuilder()->create( $data );
        }

        public function update( Model|int $model, array $data ): bool {
            $model = $this->resolveModel( $model );
            Gate::authorize( $this->policy(), $model );

            return $model->update( $data );
        }

        protected function policy( string $ability = null ): string {
            return $ability ? : debug_backtrace()[ 1 ][ 'function' ];
        }

        protected function resolveModel( Model|int $model ): Model {
            return $model instanceof Model ? $model : $this->getQueryBuilder()->findOrFail( $model );
        }

        public function viewResource( Model $model ): Resource|null {
            Gate::authorize( $this->policy( 'view' ), $model );

            return $model->uploads()->limit( 1 )->first();
        }

        public function updateResource( Model $model, Resource|int $related ): bool {
            $related = is_int( $related ) ? Resource::findOrFail( $related ) : $related;
            Gate::authorize( $this->policy( 'update' ), $model );

            $resource = $this->viewResource( $model );
            DB::beginTransaction();
            try {
                if ( $resource ) {
                    if ( $resource->is( $related ) ) {
                        throw new Exception;
                    }
                    $model->uploads()->detach( $resource->id );
                    app( ResourceService::class )->delete( $resource->id );
                }
                $model->uploads()->sync( [ $related->id ] );
            } catch ( Throwable $e ) {
                DB::rollBack();

                return false;
            }
            DB::commit();

            return true;
        }
    }
