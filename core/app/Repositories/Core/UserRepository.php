<?php

    namespace App\Repositories\Core;

    use App\Models\Core\User;
    use App\Repositories\Contracts\Core\IUserRepository;
    use Illuminate\Contracts\Database\Eloquent\Builder;

    class UserRepository extends IUserRepository {

        protected function getQueryBuilder(): Builder {
            return User::query();
        }
    }
