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
            ['city' => 'Aconchi', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Agua Prieta', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'Alamos', 'region' => 'Región del Río Mayo'],
            ['city' => 'Altar', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Arivechi', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Arizpe', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'Atil', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Bacadéhuachi', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Bacanora', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Bacerac', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Bacoachi', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'Bácum', 'region' => 'Región del Río Yaqui'],
            ['city' => 'Banámichi', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Baviácora', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Bavispe', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Benito Juárez', 'region' => 'Región del Río Mayo'],
            ['city' => 'Benjamín Hill', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Caborca', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Cajeme', 'region' => 'Región del Río Yaqui'],
            ['city' => 'Cananea', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'Carbó', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Cocurpe', 'region' => 'Región de la Frontera'],
            ['city' => 'Cumpas', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Divisaderos', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Empalme', 'region' => 'Región del Puerto'],
            ['city' => 'Etchojoa', 'region' => 'Región del Río Mayo'],
            ['city' => 'Fronteras', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'General Plutarco Elías Calles', 'region' => 'Región del Alto Golfo'],
            ['city' => 'Granados', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Guaymas', 'region' => 'Región del Puerto'],
            ['city' => 'Hermosillo', 'region' => 'Región Capital'],
            ['city' => 'Huachinera', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Huásabas', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Huatabampo', 'region' => 'Región del Río Mayo'],
            ['city' => 'Huépac', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Imuris', 'region' => 'Región de la Frontera'],
            ['city' => 'La Colorada', 'region' => 'Región del Puerto'],
            ['city' => 'Magdalena', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Mazatán', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Moctezuma', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Naco', 'region' => 'Región de las Cuatro Sierras'],
            ['city' => 'Nácori Chico', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Nacozari de García', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Navojoa', 'region' => 'Región del Río Mayo'],
            ['city' => 'Nogales', 'region' => 'Región de la Frontera'],
            ['city' => 'Onavas', 'region' => 'Región del Puerto'],
            ['city' => 'Opodepe', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Oquitoa', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Pitiquito', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Puerto Peñasco', 'region' => 'Región del Alto Golfo'],
            ['city' => 'Quiriego', 'region' => 'Región del Río Mayo'],
            ['city' => 'Rayón', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Rosario', 'region' => 'Región del Río Mayo'],
            ['city' => 'Sahuaripa', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'San Felipe de Jesús', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'San Ignacio Río Muerto', 'region' => 'Región del Río Yaqui'],
            ['city' => 'San Javier', 'region' => 'Región del Puerto'],
            ['city' => 'San Luis Río Colorado', 'region' => 'Región del Alto Golfo'],
            ['city' => 'San Miguel de Horcasitas', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'San Pedro de la Cueva', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Santa Ana', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Santa Cruz', 'region' => 'Región de la Frontera'],
            ['city' => 'Sáric', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Soyopa', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Suaqui Grande', 'region' => 'Región del Puerto'],
            ['city' => 'Tepache', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Trincheras', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Tubutama', 'region' => 'Región del Gran Desierto'],
            ['city' => 'Ures', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Villa Hidalgo', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Villa Pesqueira', 'region' => 'Región de la Sierra Alta'],
            ['city' => 'Yécora', 'region' => 'Región de la Sierra Alta'],
        ];
        

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'city' => $city['city'],
                'region' => $city['region'],
            ]);
        }
    }
}
