<?php

    namespace Database\Seeders\Core;

    use App\Models\Core\User;
    use AreasEnum;
    use Hans\Horus\Models\Role;
    use Horus;
    use Illuminate\Database\Seeder;
    use RolesEnum;
    use Throwable;

    class RoleAndPermissionSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         * @throws Throwable
         */
        public function run() {
            Horus::createRoles( [
                RolesEnum::DEFAULT_ADMINS
            ], AreasEnum::ADMIN
            );
            Horus::createRoles( [
                RolesEnum::DEFAULT_USERS
            ], AreasEnum::USER );


            Horus::createSuperPermissions( [
                User::class => '*',
            ], AreasEnum::ADMIN );

            Horus::assignSuperPermissionsToRole( Role::findByName( RolesEnum::DEFAULT_ADMINS, AreasEnum::ADMIN ), [
                User::class,
            ] );

        }
    }
