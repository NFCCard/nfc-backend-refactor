<?php

    namespace App\Policies\Core;

    use App\Models\Core\User;
    use App\Policies\Traits\PolicyHelper;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class UserPolicy {
        use HandlesAuthorization, PolicyHelper;


        private function getModel(): string {
            return User::class;
        }

        /**
         * Determine whether the user can view any models.
         *
         * @param User|null $user
         *
         * @return mixed
         */
        public function viewAny( ?User $user ): bool {
            return true;
        }

        /**
         * Determine whether the user can view the model.
         *
         * @param User|null $user
         * @param User      $model
         *
         * @return mixed
         */
        public function view( ?User $user, User $model ): bool {
            return true;
        }

        /**
         * Determine whether the user can create models.
         *
         * @param User $user
         *
         * @return mixed
         */
        public function create( User $user ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can update the model.
         *
         * @param User $user
         * @param User $model
         *
         * @return mixed
         */
        public function update( User $user, User $model ): bool {
            return $user->can( $this->makeAbility() ) or $user->is( $model );
        }

        /**
         * Determine whether the user can delete the model.
         *
         * @param User $user
         * @param User $model
         *
         * @return mixed
         */
        public function delete( User $user, User $model ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can restore the model.
         *
         * @param User $user
         * @param User $model
         *
         * @return mixed
         */
        public function restore( User $user, User $model ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can permanently delete the model.
         *
         * @param User $user
         * @param User $model
         *
         * @return mixed
         */
        public function forceDelete( User $user, User $model ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * @param User $user
         * @param User $model
         *
         * @return bool
         */
        public function viewProfile( User $user, User $model ): bool {
            return $user->can( $this->makeAbility() );
        }

    }
