<?php

    namespace App\Repositories\Core;

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IUserRepository;
    use Illuminate\Contracts\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\Gate;

    class UserRepository extends IUserRepository {

        protected function getQueryBuilder(): Builder {
            return User::query();
        }

        public function viewProfile( User $model ): Profile {
            Gate::authorize( $this->policy(), $model );

            return $model->profile;
        }
    }
