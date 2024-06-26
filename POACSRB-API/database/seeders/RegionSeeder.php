<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Región del Alto Golfo',
            'Región del Gran Desierto',
            'Región de la Frontera',
            'Región de las Cuatro Sierras',
            'Región de los Tres Ríos',
            'Región de la Sierra Alta',
            'Región Capital',
            'Región del Puerto',
            'Región del Río Yaqui',
            'Región del Río Mayo',
            'Región del Río Sonora',
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'region' => $region,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
