<?php

    namespace App\Policies\Core;

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Policies\Traits\PolicyHelper;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class ProfilePolicy {
        use HandlesAuthorization, PolicyHelper;


        private function getModel(): string {
            return Profile::class;
        }

        /**
         * Determine whether the user can view any models.
         *
         * @param User $user
         *
         * @return mixed
         */
        public function viewAny( User $user ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can view the model.
         *
         * @param User    $user
         * @param Profile $profile
         *
         * @return mixed
         */
        public function view( User $user, Profile $profile ): bool {
            return $user->can( $this->makeAbility() );
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
         * @param User    $user
         * @param Profile $profile
         *
         * @return mixed
         */
        public function update( User $user, Profile $profile ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can delete the model.
         *
         * @param User    $user
         * @param Profile $profile
         *
         * @return mixed
         */
        public function delete( User $user, Profile $profile ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can restore the model.
         *
         * @param User    $user
         * @param Profile $profile
         *
         * @return mixed
         */
        public function restore( User $user, Profile $profile ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * Determine whether the user can permanently delete the model.
         *
         * @param User    $user
         * @param Profile $profile
         *
         * @return mixed
         */
        public function forceDelete( User $user, Profile $profile ): bool {
            return $user->can( $this->makeAbility() );
        }

        /**
         * @param User  $user
         * @param Profile $model
         *
         * @return bool
         */
        public function viewUser( User $user,Profile $model ): bool {
            return $user->can( $this->makeAbility() );
        }

    }
