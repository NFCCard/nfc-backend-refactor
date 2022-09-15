<?php

    namespace App\Repositories\Core;

    use App\Models\Core\Profile;
    use App\Repositories\Contracts\Core\IProfileRepository;
    use Illuminate\Contracts\Database\Eloquent\Builder;

    class ProfileRepository extends IProfileRepository {

	    protected function getQueryBuilder(): Builder {
            return Profile::query();
	    }
    }
