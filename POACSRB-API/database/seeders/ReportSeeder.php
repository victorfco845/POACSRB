<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
            'title' => 'Visita a la planta del bacanora',
            'goal_id' => 1,
            'comission_number' => 'COM001',
            'date' => '01/08/2024',
            'user_id' => 1,
            'total_people' => 150,
            'total_women' => 80,
            'total_men' => 70,
            'total_ethnicity' => 10,
            'total_deshabilities' => 5,
            'city' => 'Hermosillo',
            'region' => 'Región Capital',
            'inform' => 'Se realizó una evaluación de las medidas de seguridad en la planta del bacanora.',
            'comment' => 'Ningún incidente reportado.',
            ],
            [
            'title' => 'Inspeccion al producto mas reciente de bacanora',
            'goal_id' => 2,
            'comission_number' => 'COM002',
            'date' => '02/08/2024',
            'user_id' => 2,
            'total_people' => 100,
            'total_women' => 50,
            'total_men' => 50,
            'total_ethnicity' => 8,
            'total_deshabilities' => 3,
            'city' => 'Huachinera',
            'region' => 'Región de la Sierra Alta',
            'inform' => 'Se inspeccionaron los productos de acuerdo con las normas de calidad.',
            'comment' => 'Requiere seguimiento adicional.',
            ],
            [
            'title' => 'Visita a la cdmx por motivos de conferencia',
            'goal_id' => 3,
            'comission_number' => 'COM003',
            'date' => '03/02/2024',
            'user_id' => 2,
            'total_people' => 200,
            'total_women' => 90,
            'total_men' => 110,
            'total_ethnicity' => 15,
            'total_deshabilities' => 7,
            'city' => 'Naco',
            'region' => 'Región de las Cuatro Sierras',
            'inform' => 'Producción alcanzó el 95% de la meta mensual.',
            'comment' => 'Resultados excelentes.',
            ],
            [
            'title' => 'Auditoría Interna',
            'goal_id' => 4,
            'comission_number' => 'COM004',
            'date' => '04/08/2024',
            'user_id' => 1,
            'total_people' => 120,
            'total_women' => 60,
            'total_men' => 60,
            'total_ethnicity' => 5,
            'total_deshabilities' => 2,
            'city' => 'Hermosillo',
            'region' => 'Región Capital',
            'inform' => 'Auditoría interna realizada conforme al plan de auditoría 2024.',
            'comment' => 'Se encontraron algunas no conformidades menores.',
            ],
            [
            'title' => 'Evaluación Ambiental',
            'goal_id' => 5,
            'comission_number' => 'COM005',
            'date' => '05/08/2024',
            'user_id' => 2,
            'total_people' => 180,
            'total_women' => 90,
            'total_men' => 90,
            'total_ethnicity' => 12,
            'total_deshabilities' => 6,
            'city' => 'Hermosillo',
            'region' => 'Región Capital',
            'inform' => 'Se realizó una evaluación completa del impacto ambiental de las operaciones.',
            'comment' => 'Medidas de mitigación recomendadas.',
        ]
            ];
            DB::table('reports')->insert($reports);
    }
    
}
