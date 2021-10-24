<?php

namespace Database\Seeders;

use App\Models\MaintenanceEventType;
use Illuminate\Database\Seeder;

class MaintenanceEventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Rail Defects'
            ],
            [
                'name' => 'Installation'
            ],
            [
                'name' => 'Broken component'
            ],
            [
                'name' => 'Scheduled maintenance'
            ],
        ];

        MaintenanceEventType::insert($types);
    }
}
