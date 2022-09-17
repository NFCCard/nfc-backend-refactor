<?php

    namespace Database\Seeders\Core;

    use App\Models\Core\User;
    use Illuminate\Database\Seeder;
    use RolesEnum;

    class UserSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {
            $user = User::factory()->create( [
                'username' => 'mammadkamalipour'
            ] );
            $user->assignRole( RolesEnum::DEFAULT_ADMINS, true );

            if ( env( 'FAKE_DATA_FOR_DATABASE', false ) ) {
                User::factory()
                    ->count( rand( 10, 25 ) )
                    ->create()
                    ->each( fn( User $user ) => $user->assignRole( RolesEnum::DEFAULT_USERS, true ) );
            }
        }
    }
