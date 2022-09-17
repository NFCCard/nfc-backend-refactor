<?php

    namespace App\Repositories\Core;

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IProfileRepository;
    use Illuminate\Contracts\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\Gate;

    class ProfileRepository extends IProfileRepository {

        protected function getQueryBuilder(): Builder {
            return Profile::query();
        }

        public function viewUser( Profile $model ): User {
            Gate::authorize( $this->policy(), $model );

            return $model->user;
        }

    }
