<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ThingTypesSeeder::class,
            MaintenanceEventTypesSeeder::class,
            ThingsSeeder::class,
            POISeeder::class,
        ]);
    }
}
