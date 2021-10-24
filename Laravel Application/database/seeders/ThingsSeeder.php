<?php

namespace Database\Seeders;

use App\Models\Thing;
use Illuminate\Database\Seeder;

class ThingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $things = [
            [
                'type_id' => '1',
                'name' => 'Device #1',
                'eui' => '0004A30B001FB321',
                'installed_at' => '2021-10-23'
            ],
            [
                'type_id' => '2',
                'name' => 'Device #2',
                'eui' => '0004A30B001FB322',
                'installed_at' => '2021-10-23'
            ],
            [
                'type_id' => '3',
                'name' => 'Device #3',
                'eui' => '0004A30B001FB323',
                'installed_at' => '2021-10-23'
            ],
            [
                'type_id' => '4',
                'name' => 'Hackathon SODAQ',
                'eui' => '0004A30B001FB325',
                'installed_at' => '2021-10-23'
            ],
        ];

        Thing::insert($things);
    }
}
