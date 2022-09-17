<?php

    namespace App\Providers;

    use App\Models\Core\Profile;
    use App\Models\Core\User;
    use App\Policies\Core\ProfilePolicy;
    use App\Policies\Core\UserPolicy;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

    class AuthServiceProvider extends ServiceProvider {
        /**
         * The policy mappings for the application.
         *
         * @var array<class-string, class-string>
         */
        protected $policies = [
            // Core
            User::class    => UserPolicy::class,
            Profile::class => ProfilePolicy::class,
        ];

        /**
         * Register any authentication / authorization services.
         *
         * @return void
         */
        public function boot() {
            $this->registerPolicies();

            //
        }
    }
