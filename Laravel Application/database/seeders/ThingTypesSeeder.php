<?php

namespace Database\Seeders;

use App\Models\SensorType;
use Illuminate\Database\Seeder;

class ThingTypesSeeder extends Seeder
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
                'name' => 'LoRaWANGenDevice'
            ],
            [
                'name' => 'Bosch Parking Sensor'
            ],
            [
                'name' => 'Adeunis LoRa Field Test Device'
            ],
            [
                'name' => 'Hackathon Device'
            ],
        ];

        SensorType::insert($types);
    }
}
