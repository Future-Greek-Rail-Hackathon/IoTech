<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Seeder;

class POISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pois = [
            [
                'name' => 'Λιανοκλάδι #1',
                'latitude' => '38.893078905462374',
                'longitude' => '22.37091150423377',
                'description' => 'Σημείο στο λιανοκλάδι #1'
            ],
            [
                'name' => 'Λιανοκλάδι #2',
                'latitude' => '38.872093824023835',
                'longitude' => '22.419043527594834',
                'description' => 'Σημείο στο λιανοκλάδι #2'
            ],
            [
                'name' => 'Λιανοκλάδι #3',
                'latitude' => '38.909244696423706',
                'longitude' => '22.327443881052464',
                'description' => '<p>Σημείο ενδιαφέροντος Λιανοκλάδι #3</p>'
            ],
        ];

        Point::insert($pois);
    }
}
