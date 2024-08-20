<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            "1. Celebrar convenios de colaboración con dependencias, instituciones académicas y de investigación, cámaras empresariales y organizaciones privadas, que impulsen el desarrollo integral de la cadena productiva del Bacanora; la propiedad intelectual, el aseguramiento de la calidad; la apertura de mercados, la validación y transferencia de tecnología para esta Industria.",
            "2. Participar en reuniones de trabajo enfocadas a las Denominaciones de Origen Protegidas en México/ Internacional.",
            "8. Impartir cursos y talleres de capacitación a Productores, Comercializadores de Agave y Bacanora y sus subproductos, así como al Personal del Consejo, en procesos, formación empresarial, actualización disciplinaria, aplicación de la Norma Oficial Mexicana del Bacanora y Registros, Bitácoras y Certificación de Producto.",
            "9. Desarrollar cursos y talleres de capacitación para el Emprendimiento y Formación Empresarial con Perspectiva de Género.",
            "10. Llevar a cabo acciones de registro, evaluación y seguimiento del establecimiento de viveros, plantaciones agrícolas y silvestres de Agave angustifolia Haw, así como fábricas de Bacanora.",
            "11. Participación y organización de eventos promocionales para el Bacanora: Ferias, Exposiciones, Encuentros de Negocios Nacionales e Internacionales y Festivales.",
            "12. Realizar Reuniones de trabajo con Productores, Empresarios, Instituciones, Sector Gubernamental y/o Asociaciones de Productores de Agave y Bacanora.",
            "13. Elaborar y publicar Manuales Operativos, Libros y/o Documentos Informativos sobre la Industria del Bacanora.",
            "14. Elaborar censos (viveros, plantaciones y vinatas de Bacanora)."
        ];

        foreach ($goals as $goal) {
            DB::table('goals')->insert([
                'goal' => $goal,
            ]);
        }
    }
}
