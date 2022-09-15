<?php

    namespace App\Providers;

    use App\Repositories\Contracts\Core\IUserRepository;
    use App\Repositories\Core\UserRepository;
    use Illuminate\Support\ServiceProvider;

    class RepositoryServiceProvider extends ServiceProvider {
        /**
         * Register services.
         *
         * @return void
         */
        public function register() {
            // Core
            $this->app->singleton( IUserRepository::class, UserRepository::class );
        }

        /**
         * Bootstrap services.
         *
         * @return void
         */
        public function boot() {
            //
        }
    }
