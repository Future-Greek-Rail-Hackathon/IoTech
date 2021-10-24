<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'sensor_access',
            ],
            [
                'id'    => 18,
                'title' => 'sensor_type_create',
            ],
            [
                'id'    => 19,
                'title' => 'sensor_type_edit',
            ],
            [
                'id'    => 20,
                'title' => 'sensor_type_show',
            ],
            [
                'id'    => 21,
                'title' => 'sensor_type_delete',
            ],
            [
                'id'    => 22,
                'title' => 'sensor_type_access',
            ],
            [
                'id'    => 23,
                'title' => 'thing_create',
            ],
            [
                'id'    => 24,
                'title' => 'thing_edit',
            ],
            [
                'id'    => 25,
                'title' => 'thing_show',
            ],
            [
                'id'    => 26,
                'title' => 'thing_delete',
            ],
            [
                'id'    => 27,
                'title' => 'thing_access',
            ],
            [
                'id'    => 28,
                'title' => 'point_create',
            ],
            [
                'id'    => 29,
                'title' => 'point_edit',
            ],
            [
                'id'    => 30,
                'title' => 'point_show',
            ],
            [
                'id'    => 31,
                'title' => 'point_delete',
            ],
            [
                'id'    => 32,
                'title' => 'point_access',
            ],
            [
                'id'    => 33,
                'title' => 'region_create',
            ],
            [
                'id'    => 34,
                'title' => 'region_edit',
            ],
            [
                'id'    => 35,
                'title' => 'region_show',
            ],
            [
                'id'    => 36,
                'title' => 'region_delete',
            ],
            [
                'id'    => 37,
                'title' => 'region_access',
            ],
            [
                'id'    => 38,
                'title' => 'maintenance_event_type_create',
            ],
            [
                'id'    => 39,
                'title' => 'maintenance_event_type_edit',
            ],
            [
                'id'    => 40,
                'title' => 'maintenance_event_type_show',
            ],
            [
                'id'    => 41,
                'title' => 'maintenance_event_type_delete',
            ],
            [
                'id'    => 42,
                'title' => 'maintenance_event_type_access',
            ],
            [
                'id'    => 43,
                'title' => 'maintenance_event_create',
            ],
            [
                'id'    => 44,
                'title' => 'maintenance_event_edit',
            ],
            [
                'id'    => 45,
                'title' => 'maintenance_event_show',
            ],
            [
                'id'    => 46,
                'title' => 'maintenance_event_delete',
            ],
            [
                'id'    => 47,
                'title' => 'maintenance_event_access',
            ],
            [
                'id'    => 48,
                'title' => 'maintenance_access',
            ],
            [
                'id'    => 49,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
