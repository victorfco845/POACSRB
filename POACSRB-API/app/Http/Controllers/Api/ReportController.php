<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Goal;
use App\Models\City;
use App\Models\User;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index()
    {
        try {
            $reports = Report::with('user')->get();

    
            // Transforma los informes
            $transformedReports = $reports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'goal' => $report->goal->goal ?? 'N/A',
                    'comission_number' => $report->comission_number,
                    'date' => $report->date,
                    'user' => $report->user ? $report->user->user : 'Unknown User',
                    'total_people' => $report->total_people,
                    'total_women' => $report->total_women,
                    'total_men' => $report->total_men,
                    'total_ethnicity' => $report->total_ethnicity,
                    'total_deshabilities' => $report->total_deshabilities,
                    'city' => $report->city,
                    'region' => $report->region,
                    'inform' => $report->inform,
                    'comment' => $report->comment,
                ];
            });
    
            return response()->json($transformedReports);
        } catch (\Exception $e) {
            \Log::error('Error fetching the reports: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function show($id)
{
    try {
        // Encuentra el informe por ID
        $report = Report::with('user')->findOrFail($id);

        // Transforma el informe
        $transformedReport = [
            'id' => $report->id,
            'title' => $report->title,
            'goal' => $report->goal->goal ?? 'N/A',
            'comission_number' => $report->comission_number,
            'date' => $report->date,
            'user' => $report->user ? $report->user->user : 'Unknown User',
            'total_people' => $report->total_people,
            'total_women' => $report->total_women,
            'total_men' => $report->total_men,
            'total_ethnicity' => $report->total_ethnicity,
            'total_deshabilities' => $report->total_deshabilities,
            'city' => $report->city,
            'region' => $report->region,
            'inform' => $report->inform,
            'comment' => $report->comment,
        ];

        return response()->json($transformedReport);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['error' => 'Report not found'], 404);
    } catch (\Exception $e) {
        \Log::error('Error fetching the report: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function create(Request $request)
{
    // Validación de los datos de entrada
    $request->validate([
        'title' => 'required|string|max:128',
        'goal_id' => 'required|integer',
        'comission_number' => 'required|string|max:128',
        'date' => 'required|string|max:128',
        'user_id' => 'required|integer',
        'total_people' => 'required|integer',
        'total_women' => 'required|integer',
        'total_men' => 'required|integer',
        'total_ethnicity' => 'required|integer',
        'total_deshabilities' => 'required|integer',
        'city' => 'required|string|max:128',
        'region' => 'required|string|max:128',
        'inform' => 'required|string|max:2500',
        'comment' => 'nullable|string|max:400',
    ]);

    // Crea una nueva instancia del reporte
    $report = new Report([
        'title' => $request->input('title'),
        'goal_id' => $request->input('goal_id'),
        'comission_number' => $request->input('comission_number'),
        'date' => $request->input('date'),
        'user_id' => $request->input('user_id'),
        'total_people' => $request->input('total_people'),
        'total_women' => $request->input('total_women'),
        'total_men' => $request->input('total_men'),
        'total_ethnicity' => $request->input('total_ethnicity'),
        'total_deshabilities' => $request->input('total_deshabilities'),
        'city' => $request->input('city'),
        'region' => $request->input('region'),
        'inform' => $request->input('inform'),
        'comment' => $request->input('comment'),
    ]);

    // Guarda el reporte en la base de datos
    $report->save();

    // Devuelve solo el ID del reporte recién creado
    return response()->json([
        'message' => 'Reporte creado exitosamente.',
        'id' => $report->id
    ], 201);
}

    
    
public function update(Request $request, $id)
{
    // Validación de datos recibidos
    $request->validate([
        'title' => 'required|string|max:128',
        'goal_id' => 'required|integer', // Asegúrate de que sea un ID entero
        'comission_number' => 'required|string|max:128',
        'date' => 'required|string|max:128',
        'total_people' => 'required|integer',
        'total_women' => 'required|integer',
        'total_men' => 'required|integer',
        'total_ethnicity' => 'required|integer',
        'total_deshabilities' => 'required|integer',
        'city' => 'required|string|max:128',
        'region' => 'required|string|max:128',
        'inform' => 'required|string|max:2500',
        'comment' => 'nullable|string|max:400',
    ]);

    try {
        // Actualizar el informe
        $report = Report::findOrFail($id);
        $report->update($request->all());

        return response()->json(['message' => 'Report updated successfully', 'report' => $report]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while updating the report. Please try again later.'], 500);
    }
}

        
        public function delete($id)
        {
            try {
                // Eliminar el informe
                $report = Report::findOrFail($id);
                $report->delete();
    
                return response()->json(['message' => 'Report deleted successfully']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the report. Please try again later.'], 500);
            }
        }
    
        //Funciones de consultas
        public function getTotalPersonasPorMeta()
        {
            try {
                // Consulta para obtener el total de personas, mujeres, hombres, etnia y discapacitados por meta
                $totalPersonasPorMeta = DB::table('goals')
                    ->leftJoin('reports', 'goals.id', '=', 'reports.goal_id')
                    ->select(
                        'goals.id',
                        'goals.goal',
                        DB::raw('COALESCE(SUM(CAST(reports.total_people AS BIGINT)), 0) as total_personas'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_women AS BIGINT)), 0) as total_mujeres'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_men AS BIGINT)), 0) as total_hombres'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_ethnicity AS BIGINT)), 0) as total_etnia'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_deshabilities AS BIGINT)), 0) as total_discapacitados')
                    )
                    ->groupBy('goals.id', 'goals.goal')
                    ->havingRaw('SUM(reports.total_people) > 0') // Filtrar metas sin registros
                    ->orderBy('goals.id')
                    ->get();
        
                // Consulta para obtener el total de personas por mes para cada meta
                $totalPersonasPorMetaPorMes = DB::table('goals')
                    ->leftJoin('reports', 'goals.id', '=', 'reports.goal_id')
                    ->select(
                        'goals.id',
                        'goals.goal',
                        DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM') as month"),
                        DB::raw('COALESCE(SUM(CAST(reports.total_people AS BIGINT)), 0) as total_personas_mes'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_women AS BIGINT)), 0) as total_mujeres_mes'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_men AS BIGINT)), 0) as total_hombres_mes'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_ethnicity AS BIGINT)), 0) as total_etnia_mes'),
                        DB::raw('COALESCE(SUM(CAST(reports.total_deshabilities AS BIGINT)), 0) as total_discapacitados_mes')
                    )
                    ->groupBy('goals.id', 'goals.goal', DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM')"))
                    ->orderBy('goals.id')
                    ->orderBy(DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
                    ->get();
        
                // Mapeo de números de meses a nombres en español
                $mesesEspañol = [
                    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                ];
        
                // Formatear los resultados combinados
                $result = [];
        
                foreach ($totalPersonasPorMeta as $meta) {
                    // Añadir los totales generales
                    $metaData = [
                        'goal' => $meta->goal,
                        'total_personas' => $meta->total_personas,
                        'total_mujeres' => $meta->total_mujeres,
                        'total_hombres' => $meta->total_hombres,
                        'total_etnia' => $meta->total_etnia,
                        'total_discapacitados' => $meta->total_discapacitados,
                    ];
        
                    // Filtrar los resultados por meta y añadir los totales por mes
                    $meses = $totalPersonasPorMetaPorMes->where('id', $meta->id);
                    foreach ($meses as $mes) {
                        $fecha = explode('-', $mes->month);
                        $mounth = $fecha[0];
                        $mesTexto = $mesesEspañol[$fecha[1]];
        
                        $metaData['meses'][] = [
                            'mes' => $mesTexto,
                            'año' => $mounth,
                            'total_personas_mes' => $mes->total_personas_mes,
                            'total_mujeres_mes' => $mes->total_mujeres_mes,
                            'total_hombres_mes' => $mes->total_hombres_mes,
                            'total_etnia_mes' => $mes->total_etnia_mes,
                            'total_discapacitados_mes' => $mes->total_discapacitados_mes,
                        ];
                    }
        
                    // Agregar la meta formateada al resultado
                    $result[] = $metaData;
                }
        
            } catch (\Exception $e) {
                \Log::error('Error fetching total personas por meta: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        
            return response()->json(['data' => $result]);
        }
        
        
        public function getTotalPersonasPorMunicipio()
{
    try {
        // Consulta para obtener el total de personas, mujeres, hombres, etnia y discapacitados por municipio
        $totalPersonasPorMunicipio = DB::table('cities')
            ->leftJoin('reports', 'cities.city', '=', 'reports.city')
            ->select(
                'cities.city',
                DB::raw('COALESCE(SUM(CAST(reports.total_people AS BIGINT)), 0) as total_personas'),
                DB::raw('COALESCE(SUM(CAST(reports.total_women AS BIGINT)), 0) as total_mujeres'),
                DB::raw('COALESCE(SUM(CAST(reports.total_men AS BIGINT)), 0) as total_hombres'),
                DB::raw('COALESCE(SUM(CAST(reports.total_ethnicity AS BIGINT)), 0) as total_etnia'),
                DB::raw('COALESCE(SUM(CAST(reports.total_deshabilities AS BIGINT)), 0) as total_discapacitados')
            )
            ->groupBy('cities.city')
            ->havingRaw('SUM(reports.total_people) > 0') // Filtrar municipios sin registros
            ->orderBy('cities.city') // Ordena alfabéticamente por nombre de la ciudad
            ->get();

        // Consulta para obtener el total de personas por mes para cada municipio
        $totalPersonasPorMunicipioPorMes = DB::table('cities')
            ->leftJoin('reports', 'cities.city', '=', 'reports.city')
            ->select(
                'cities.city',
                DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM') as month"),
                DB::raw('COALESCE(SUM(CAST(reports.total_people AS BIGINT)), 0) as total_personas_mes'),
                DB::raw('COALESCE(SUM(CAST(reports.total_women AS BIGINT)), 0) as total_mujeres_mes'),
                DB::raw('COALESCE(SUM(CAST(reports.total_men AS BIGINT)), 0) as total_hombres_mes'),
                DB::raw('COALESCE(SUM(CAST(reports.total_ethnicity AS BIGINT)), 0) as total_etnia_mes'),
                DB::raw('COALESCE(SUM(CAST(reports.total_deshabilities AS BIGINT)), 0) as total_discapacitados_mes')
            )
            ->groupBy('cities.city', DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM')"))
            ->orderBy('cities.city')
            ->orderBy(DB::raw("FORMAT(CONVERT(DATE, reports.date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
            ->get();

        // Mapeo de números de meses a nombres en español
        $mesesEspañol = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];

        // Formatear los resultados combinados
        $result = [];

        foreach ($totalPersonasPorMunicipio as $municipio) {
            // Añadir los totales generales
            $municipioData = [
                'city' => $municipio->city,
                'total_personas' => $municipio->total_personas,
                'total_mujeres' => $municipio->total_mujeres,
                'total_hombres' => $municipio->total_hombres,
                'total_etnia' => $municipio->total_etnia,
                'total_discapacitados' => $municipio->total_discapacitados,
            ];

            // Filtrar los resultados por municipio y añadir los totales por mes
            $meses = $totalPersonasPorMunicipioPorMes->where('city', $municipio->city);
            foreach ($meses as $mes) {
                $fecha = explode('-', $mes->month);
                $mounth = $fecha[0];
                $mesTexto = $mesesEspañol[$fecha[1]];

                $municipioData['meses'][] = [
                    'mes' => $mesTexto,
                    'año' => $mounth,
                    'total_personas_mes' => $mes->total_personas_mes,
                    'total_mujeres_mes' => $mes->total_mujeres_mes,
                    'total_hombres_mes' => $mes->total_hombres_mes,
                    'total_etnia_mes' => $mes->total_etnia_mes,
                    'total_discapacitados_mes' => $mes->total_discapacitados_mes,
                ];
            }

            // Agregar el municipio formateado al resultado
            $result[] = $municipioData;
        }

    } catch (\Exception $e) {
        \Log::error('Error fetching total personas por municipio: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }

    return response()->json(['data' => $result]);
}

        
public function getTotalPersonasPorRegion()
{
    try {
        // Subconsulta para agrupar y sumar los valores en la tabla 'reports'
        $subQuery = DB::table('reports')
            ->select(
                'region',
                DB::raw('SUM(CAST(total_people AS BIGINT)) as total_personas'),
                DB::raw('SUM(CAST(total_women AS BIGINT)) as total_mujeres'),
                DB::raw('SUM(CAST(total_men AS BIGINT)) as total_hombres'),
                DB::raw('SUM(CAST(total_ethnicity AS BIGINT)) as total_etnia'),
                DB::raw('SUM(CAST(total_deshabilities AS BIGINT)) as total_discapacitados')
            )
            ->groupBy('region');
        
        // Consulta principal uniendo 'cities' con la subconsulta
        $results = DB::table('cities')
            ->leftJoinSub($subQuery, 'reports', 'cities.region', '=', 'reports.region')
            ->select(
                'cities.region',
                DB::raw('COALESCE(reports.total_personas, 0) as total_personas'),
                DB::raw('COALESCE(reports.total_mujeres, 0) as total_mujeres'),
                DB::raw('COALESCE(reports.total_hombres, 0) as total_hombres'),
                DB::raw('COALESCE(reports.total_etnia, 0) as total_etnia'),
                DB::raw('COALESCE(reports.total_discapacitados, 0) as total_discapacitados')
            )
            ->whereRaw('COALESCE(reports.total_personas, 0) > 0') // Filtrar regiones sin registros
            ->groupBy('cities.region', 'reports.total_personas', 'reports.total_mujeres', 'reports.total_hombres', 'reports.total_etnia', 'reports.total_discapacitados')
            ->orderBy('total_personas', 'desc')
            ->get();
        
        // Consulta para obtener el total de personas por mes para cada región
        $totalPersonasPorRegionPorMes = DB::table('reports')
            ->select(
                'region',
                DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                DB::raw('COALESCE(SUM(CAST(total_people AS BIGINT)), 0) as total_personas_mes'),
                DB::raw('COALESCE(SUM(CAST(total_women AS BIGINT)), 0) as total_mujeres_mes'),
                DB::raw('COALESCE(SUM(CAST(total_men AS BIGINT)), 0) as total_hombres_mes'),
                DB::raw('COALESCE(SUM(CAST(total_ethnicity AS BIGINT)), 0) as total_etnia_mes'),
                DB::raw('COALESCE(SUM(CAST(total_deshabilities AS BIGINT)), 0) as total_discapacitados_mes')
            )
            ->groupBy('region', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"))
            ->orderBy('region')
            ->orderBy(DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
            ->get();
        
        // Mapeo de números de meses a nombres en español
        $mesesEspañol = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];

        // Formatear los resultados combinados
        $result = [];

        foreach ($results as $region) {
            // Añadir los totales generales
            $regionData = [
                'region' => $region->region,
                'total_personas' => $region->total_personas,
                'total_mujeres' => $region->total_mujeres,
                'total_hombres' => $region->total_hombres,
                'total_etnia' => $region->total_etnia,
                'total_discapacitados' => $region->total_discapacitados,
            ];

            // Filtrar los resultados por región y añadir los totales por mes
            $meses = $totalPersonasPorRegionPorMes->where('region', $region->region);
            foreach ($meses as $mes) {
                $fecha = explode('-', $mes->month);
                $mounth = $fecha[0];
                $mesTexto = $mesesEspañol[$fecha[1]];

                $regionData['meses'][] = [
                    'mes' => $mesTexto,
                    'año' => $mounth,
                    'total_personas_mes' => $mes->total_personas_mes,
                    'total_mujeres_mes' => $mes->total_mujeres_mes,
                    'total_hombres_mes' => $mes->total_hombres_mes,
                    'total_etnia_mes' => $mes->total_etnia_mes,
                    'total_discapacitados_mes' => $mes->total_discapacitados_mes,
                ];
            }

            // Agregar la región formateada al resultado
            $result[] = $regionData;
        }

    } catch (\Exception $e) {
        \Log::error('Error fetching total personas por region: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching total personas por region.'], 500);
    }

    return response()->json(['data' => $result]);
}

        
        public function getTotalPersonasPorMes()
        {
            $currentYear = date('Y');
            $currentMonth = date('m');
            
            // Generar los últimos 12 meses, incluyendo el mes actual
            $months = [];
            for ($i = 0; $i < 12; $i++) {
                $date = \Carbon\Carbon::create($currentYear, $currentMonth)->subMonths($i);
                $months[] = [
                    'year' => $date->year,
                    'month' => $date->month,
                    'month_name' => $date->locale('es')->format('F') // Obtener el nombre del mes en español
                ];
            }
        
            // Convertir los meses en un formato adecuado para la consulta
            $monthNumbers = array_map(function($month) {
                return sprintf('%04d-%02d', $month['year'], $month['month']);
            }, $months);
        
            // Consulta SQL para obtener los datos
            $results = DB::table('reports')
                ->select(
                    DB::raw('YEAR(TRY_CONVERT(datetime, date, 103)) as year'),
                    DB::raw('MONTH(TRY_CONVERT(datetime, date, 103)) as month'),
                    DB::raw('SUM(total_people) as total_personas'),
                    DB::raw('SUM(total_women) as total_mujeres'),
                    DB::raw('SUM(total_men) as total_hombres'),
                    DB::raw('SUM(total_ethnicity) as total_etnia'),
                    DB::raw('SUM(total_deshabilities) as total_discapacitados')
                )
                ->whereIn(DB::raw('FORMAT(TRY_CONVERT(datetime, date, 103), \'yyyy-MM\')'), $monthNumbers)
                ->groupBy(
                    DB::raw('YEAR(TRY_CONVERT(datetime, date, 103))'),
                    DB::raw('MONTH(TRY_CONVERT(datetime, date, 103))')
                )
                ->get();
        
            // Crear un array con todos los meses para asegurar que todos los meses estén representados
            $data = [];
            foreach ($months as $month) {
                $key = $month['year'] . '-' . str_pad($month['month'], 2, '0', STR_PAD_LEFT);
                $data[$key] = [
                    'month_name' => $month['month_name'],
                    'year' => $month['year'],
                    'total_personas' => "0",
                    'total_mujeres' => "0",
                    'total_hombres' => "0",
                    'total_etnia' => "0",
                    'total_discapacitados' => "0"
                ];
            }
        
            // Poblar el array data con los resultados de la consulta
            foreach ($results as $result) {
                $key = $result->year . '-' . str_pad($result->month, 2, '0', STR_PAD_LEFT);
                if (isset($data[$key])) {
                    $data[$key]['total_personas'] = (string) $result->total_personas;
                    $data[$key]['total_mujeres'] = (string) $result->total_mujeres;
                    $data[$key]['total_hombres'] = (string) $result->total_hombres;
                    $data[$key]['total_etnia'] = (string) $result->total_etnia;
                    $data[$key]['total_discapacitados'] = (string) $result->total_discapacitados;
                }
            }
        
            // Ordenar los datos por año y mes del más reciente al más antiguo
            uasort($data, function($a, $b) {
                if (!isset($a['year'], $a['month'], $b['year'], $b['month'])) {
                    return 0;
                }
                $dateA = $a['year'] . '-' . str_pad($a['month'], 2, '0', STR_PAD_LEFT);
                $dateB = $b['year'] . '-' . str_pad($b['month'], 2, '0', STR_PAD_LEFT);
                return strcmp($dateB, $dateA); // Orden descendente
            });
        
            // Convertir los datos en un array y devolver la respuesta
            $formattedData = array_values($data);
        
            return response()->json($formattedData);
        }
        
        
        
        public function getTotalComisionesPorMeta()
        {
            try {
                // Subconsulta para contar comisiones por meta y mes
                $subQuery = DB::table('reports')
                    ->select(
                        'goal_id',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('goal_id', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"));
        
                // Consulta principal uniendo 'goals' con la subconsulta
                $totalComisionesPorMeta = DB::table('goals')
                    ->leftJoinSub($subQuery, 'report_subquery', 'goals.id', '=', 'report_subquery.goal_id')
                    ->select(
                        'goals.goal',
                        'goals.id',
                        DB::raw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) as total_comisiones')
                    )
                    ->groupBy('goals.goal', 'goals.id')
                    ->havingRaw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) > 0') // Filtrar metas sin comisiones
                    ->orderBy('goals.id') // Ordenar por goal_id
                    ->get();
        
                // Consulta para obtener el total de comisiones por mes para cada meta
                $totalComisionesPorMetaPorMes = DB::table('reports')
                    ->select(
                        'goal_id',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('goal_id', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"))
                    ->orderBy('goal_id')
                    ->orderBy(DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
                    ->get();
        
                // Mapeo de números de meses a nombres en español
                $mesesEspañol = [
                    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                ];
        
                // Formatear los resultados combinados
                $result = [];
        
                foreach ($totalComisionesPorMeta as $meta) {
                    // Añadir los totales generales
                    $metaData = [
                        'goal' => $meta->goal,
                        'id' => $meta->id,
                        'total_comisiones' => $meta->total_comisiones,
                    ];
        
                    // Filtrar los resultados por meta y añadir los totales por mes
                    $meses = $totalComisionesPorMetaPorMes->where('goal_id', $meta->id);
                    foreach ($meses as $mes) {
                        $fecha = explode('-', $mes->month);
                        $mounth = $fecha[0];
                        $mesTexto = $mesesEspañol[$fecha[1]];
        
                        $metaData['meses'][] = [
                            'mes' => $mesTexto,
                            'año' => $mounth,
                            'total_comisiones_mes' => $mes->total_comisiones_mes,
                        ];
                    }
        
                    // Agregar la meta formateada al resultado
                    $result[] = $metaData;
                }
        
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por meta: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por meta.'], 500);
            }
        
            return response()->json(['total_comisiones_por_meta' => $result]);
        }
        
        
        public function getTotalComisionesPorMunicipio()
        {
            try {
                // Subconsulta para contar comisiones por ciudad y mes
                $subQuery = DB::table('reports')
                    ->select(
                        'city',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('city', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"));
        
                // Consulta principal uniendo 'cities' con la subconsulta
                $totalComisionesPorCiudad = DB::table('cities')
                    ->leftJoinSub($subQuery, 'report_subquery', 'cities.city', '=', 'report_subquery.city')
                    ->select(
                        'cities.city',
                        DB::raw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) as total_comisiones')
                    )
                    ->groupBy('cities.city')
                    ->havingRaw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) > 0') // Filtrar ciudades sin comisiones
                    ->orderBy('cities.city')
                    ->get();
        
                // Consulta para obtener el total de comisiones por mes para cada ciudad
                $totalComisionesPorCiudadPorMes = DB::table('reports')
                    ->select(
                        'city',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('city', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"))
                    ->orderBy('city')
                    ->orderBy(DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
                    ->get();
        
                // Mapeo de números de meses a nombres en español
                $mesesEspañol = [
                    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                ];
        
                // Formatear los resultados combinados
                $result = [];
        
                foreach ($totalComisionesPorCiudad as $ciudad) {
                    // Añadir los totales generales
                    $ciudadData = [
                        'city' => $ciudad->city,
                        'total_comisiones' => $ciudad->total_comisiones,
                    ];
        
                    // Filtrar los resultados por ciudad y añadir los totales por mes
                    $meses = $totalComisionesPorCiudadPorMes->where('city', $ciudad->city);
                    foreach ($meses as $mes) {
                        $fecha = explode('-', $mes->month);
                        $mounth = $fecha[0];
                        $mesTexto = $mesesEspañol[$fecha[1]];
        
                        $ciudadData['meses'][] = [
                            'mes' => $mesTexto,
                            'año' => $mounth,
                            'total_comisiones_mes' => $mes->total_comisiones_mes,
                        ];
                    }
        
                    // Agregar la ciudad formateada al resultado
                    $result[] = $ciudadData;
                }
        
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por ciudad: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por ciudad.'], 500);
            }
        
            return response()->json(['total_comisiones_por_ciudad' => $result]);
        }
        
        
        public function getTotalComisionesPorRegion()
        {
            try {
                // Subconsulta para contar comisiones por región y mes
                $subQuery = DB::table('reports')
                    ->select(
                        'region',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('region', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"));
        
                // Consulta principal uniendo 'cities' con la subconsulta
                $totalComisionesPorRegion = DB::table('cities')
                    ->leftJoinSub($subQuery, 'report_subquery', 'cities.region', '=', 'report_subquery.region')
                    ->select(
                        'cities.region',
                        DB::raw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) as total_comisiones')
                    )
                    ->groupBy('cities.region')
                    ->havingRaw('COALESCE(SUM(report_subquery.total_comisiones_mes), 0) > 0') // Filtrar regiones sin comisiones
                    ->orderBy('cities.region')
                    ->get();
        
                // Consulta para obtener el total de comisiones por mes para cada región
                $totalComisionesPorRegionPorMes = DB::table('reports')
                    ->select(
                        'region',
                        DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM') as month"),
                        DB::raw('COUNT(DISTINCT comission_number) as total_comisiones_mes')
                    )
                    ->groupBy('region', DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"))
                    ->orderBy('region')
                    ->orderBy(DB::raw("FORMAT(CONVERT(DATE, date, 105), 'yyyy-MM')"), 'desc') // Ordenar de más reciente a más antiguo
                    ->get();
        
                // Mapeo de números de meses a nombres en español
                $mesesEspañol = [
                    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
                    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                ];
        
                // Formatear los resultados combinados
                $result = [];
        
                foreach ($totalComisionesPorRegion as $region) {
                    // Añadir los totales generales
                    $regionData = [
                        'region' => $region->region,
                        'total_comisiones' => $region->total_comisiones,
                    ];
        
                    // Filtrar los resultados por región y añadir los totales por mes
                    $meses = $totalComisionesPorRegionPorMes->where('region', $region->region);
                    foreach ($meses as $mes) {
                        $fecha = explode('-', $mes->month);
                        $ano = $fecha[0];
                        $mesTexto = $mesesEspañol[$fecha[1]];
        
                        $regionData['meses'][] = [
                            'mes' => $mesTexto,
                            'ano' => $ano,
                            'total_comisiones_mes' => $mes->total_comisiones_mes,
                        ];
                    }
        
                    // Agregar la región formateada al resultado
                    $result[] = $regionData;
                }
        
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por region: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por region.'], 500);
            }
        
            return response()->json(['total_comisiones_por_region' => $result]);
        }
        

        public function search(Request $request)
        {
            $query = Report::with(['user', 'goal']); // Cargar relaciones con user y goal
        
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
            }
        
            // Buscar por nombre del goal en lugar del goal_id
            if ($request->has('goal')) {
                $query->whereHas('goal', function ($q) use ($request) {
                    $q->where('goal', 'like', '%' . $request->input('goal') . '%');
                });
            }
        
            if ($request->has('comission_number')) {
                $query->where('comission_number', 'like', '%' . $request->input('comission_number') . '%');
            }
        
            // Buscar por ciudad (string)
            if ($request->has('city')) {
                $query->where('city', 'like', '%' . $request->input('city') . '%');
            }
        
            // Buscar por región (string)
            if ($request->has('region')) {
                $query->where('region', 'like', '%' . $request->input('region') . '%');
            }
        
            // Buscar por nombre de usuario en lugar del user_id
            if ($request->has('user')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('user', 'like', '%' . $request->input('user') . '%');
                });
            }
        
            // Filtrar por rango de fechas
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                $query->whereBetween('date', [$startDate, $endDate]);
            }
        
            $reports = $query->get();
        
            // Transformar los resultados
            $transformedReports = $reports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'goal' => $report->goal->goal ?? 'N/A',
                    'comission_number' => $report->comission_number,
                    'date' => $report->date,
                    'user' => $report->user ? $report->user->user : 'Unknown User',
                    'total_people' => $report->total_people,
                    'total_women' => $report->total_women,
                    'total_men' => $report->total_men,
                    'total_ethnicity' => $report->total_ethnicity,
                    'total_deshabilities' => $report->total_deshabilities,
                    'city' => $report->city,
                    'region' => $report->region,
                    'inform' => $report->inform,
                    'comment' => $report->comment,
                ];
            });
        
            return response()->json($transformedReports);
        }
        


        
        
    }
    