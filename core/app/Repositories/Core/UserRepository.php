<?php

    namespace App\Repositories\Core;

    use App\Models\Core\User;
    use App\Repositories\Contracts\Repository;
    use Illuminate\Contracts\Database\Eloquent\Builder;

    class UserRepository extends Repository {

        protected function getQueryBuilder(): Builder {
            return User::query();
        }
    }
