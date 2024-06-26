<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['city' => 'Aconchi', 'region_id' => 5],
            ['city' => 'Agua Prieta', 'region_id' => 4],
            ['city' => 'Alamos', 'region_id' => 10],
            ['city' => 'Altar', 'region_id' => 2],
            ['city' => 'Arivechi', 'region_id' => 5],
            ['city' => 'Arizpe', 'region_id' => 4],
            ['city' => 'Atil', 'region_id' => 2],
            ['city' => 'Bacadéhuachi', 'region_id' => 6],
            ['city' => 'Bacanora', 'region_id' => 5],
            ['city' => 'Bacerac', 'region_id' => 6],
            ['city' => 'Bacoachi', 'region_id' => 4],
            ['city' => 'Bácum', 'region_id' => 9],
            ['city' => 'Banámichi', 'region_id' => 5],
            ['city' => 'Baviácora', 'region_id' => 5],
            ['city' => 'Bavispe', 'region_id' => 6],
            ['city' => 'Benito Juárez', 'region_id' => 10],
            ['city' => 'Benjamín Hill', 'region_id' => 2],
            ['city' => 'Caborca', 'region_id' => 2],
            ['city' => 'Cajeme', 'region_id' => 9],
            ['city' => 'Cananea', 'region_id' => 4],
            ['city' => 'Carbó', 'region_id' => 2],
            ['city' => 'Cocurpe', 'region_id' => 3],
            ['city' => 'Cumpas', 'region_id' => 6],
            ['city' => 'Divisaderos', 'region_id' => 6],
            ['city' => 'Empalme', 'region_id' => 8],
            ['city' => 'Etchojoa', 'region_id' => 10],
            ['city' => 'Fronteras', 'region_id' => 4],
            ['city' => 'General Plutarco Elías Calles', 'region_id' => 1],
            ['city' => 'Granados', 'region_id' => 6],
            ['city' => 'Guaymas', 'region_id' => 8],
            ['city' => 'Hermosillo', 'region_id' => 7],
            ['city' => 'Huachinera', 'region_id' => 6],
            ['city' => 'Huásabas', 'region_id' => 6],
            ['city' => 'Huatabampo', 'region_id' => 10],
            ['city' => 'Huépac', 'region_id' => 5],
            ['city' => 'Imuris', 'region_id' => 3],
            ['city' => 'La Colorada', 'region_id' => 8],
            ['city' => 'Magdalena', 'region_id' => 2],
            ['city' => 'Mazatán', 'region_id' => 5],
            ['city' => 'Moctezuma', 'region_id' => 6],
            ['city' => 'Naco', 'region_id' => 4],
            ['city' => 'Nácori Chico', 'region_id' => 6],
            ['city' => 'Nacozari de García', 'region_id' => 6],
            ['city' => 'Navojoa', 'region_id' => 10],
            ['city' => 'Nogales', 'region_id' => 3],
            ['city' => 'Onavas', 'region_id' => 8],
            ['city' => 'Opodepe', 'region_id' => 5],
            ['city' => 'Oquitoa', 'region_id' => 2],
            ['city' => 'Pitiquito', 'region_id' => 2],
            ['city' => 'Puerto Peñasco', 'region_id' => 1],
            ['city' => 'Quiriego', 'region_id' => 10],
            ['city' => 'Rayón', 'region_id' => 5],
            ['city' => 'Rosario', 'region_id' => 10],
            ['city' => 'Sahuaripa', 'region_id' => 5],
            ['city' => 'San Felipe de Jesús', 'region_id' => 5],
            ['city' => 'San Ignacio Río Muerto', 'region_id' => 9],
            ['city' => 'San Javier', 'region_id' => 8],
            ['city' => 'San Luis Río Colorado', 'region_id' => 1],
            ['city' => 'San Miguel de Horcasitas', 'region_id' => 5],
            ['city' => 'San Pedro de la Cueva', 'region_id' => 5],
            ['city' => 'Santa Ana', 'region_id' => 2],
            ['city' => 'Santa Cruz', 'region_id' => 3],
            ['city' => 'Sáric', 'region_id' => 2],
            ['city' => 'Soyopa', 'region_id' => 5],
            ['city' => 'Suaqui Grande', 'region_id' => 8],
            ['city' => 'Tepache', 'region_id' => 6],
            ['city' => 'Trincheras', 'region_id' => 2],
            ['city' => 'Tubutama', 'region_id' => 2],
            ['city' => 'Ures', 'region_id' => 5],
            ['city' => 'Villa Hidalgo', 'region_id' => 6],
            ['city' => 'Villa Pesqueira', 'region_id' => 5],
            ['city' => 'Yécora', 'region_id' => 5],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'city' => $city['city'],
                'region_id' => $city['region_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
