<?php

    namespace App\Repositories\Contracts\Core;

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Repositories\Contracts\Repository;

    abstract class IProfileRepository extends Repository {
        abstract public function viewUser( Profile $model ): User;
    }
