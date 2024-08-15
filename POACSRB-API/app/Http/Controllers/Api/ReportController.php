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
        'city' => 'required|integer',
        'region' => 'required|integer',
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

    // Encuentra el reporte recién creado y carga la información relacionada
    $createdReport = Report::with('user')->find($report->id);

    // Transforma la información del reporte
    $transformedReport = [
        'id' => $createdReport->id,
        'title' => $createdReport->title,
        'goal' => $createdReport->goal->goal ?? 'N/A',
        'comission_number' => $createdReport->comission_number,
        'date' => $createdReport->date,
        'user' => $createdReport->user ? $createdReport->user->user : 'Unknown User',
        'total_people' => $createdReport->total_people,
        'total_women' => $createdReport->total_women,
        'total_men' => $createdReport->total_men,
        'total_ethnicity' => $createdReport->total_ethnicity,
        'total_deshabilities' => $createdReport->total_deshabilities,
        'city' => $createdReport->city,
        'region' => $createdReport->region,
        'inform' => $createdReport->inform,
        'comment' => $createdReport->comment,
    ];

    // Devuelve la información del reporte creado en la respuesta
    return response()->json([
        'message' => 'Reporte creado exitosamente.',
        'report' => $transformedReport
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
        'city' => 'required|integer',
        'region' => 'required|integer',
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
                // Consultar el total de personas, mujeres, hombres, etnia y discapacitados por meta
                $totalPersonasPorMeta = Report::select(
                    'goals.goal',
                    DB::raw('SUM(total_people) as total_personas'),
                    DB::raw('SUM(total_women) as total_mujeres'),
                    DB::raw('SUM(total_men) as total_hombres'),
                    DB::raw('SUM(total_ethnicity) as total_etnia'),
                    DB::raw('SUM(total_deshabilities) as total_discapacitados')
                )
                ->join('goals', 'reports.goal_id', '=', 'goals.id')
                ->groupBy('goals.goal')
                ->get();
        
                return response()->json(['total_personas_por_meta' => $totalPersonasPorMeta]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total personas por meta: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total personas por meta.'], 500);
            }
        }
        
        
        public function getTotalPersonasPorMunicipio()
        {
            $results = DB::table('cities')
            ->leftJoin('reports', 'cities.id', '=', 'reports.city')
            ->select(
                'cities.city',
                DB::raw('COALESCE(SUM(reports.total_people), 0) as total_personas'),
                DB::raw('COALESCE(SUM(reports.total_women), 0) as total_mujeres'),
                DB::raw('COALESCE(SUM(reports.total_men), 0) as total_hombres'),
                DB::raw('COALESCE(SUM(reports.total_ethnicity), 0) as total_etnia'),
                DB::raw('COALESCE(SUM(reports.total_deshabilities), 0) as total_discapacitados')
            )
            ->groupBy('cities.city')
            ->orderBy('total_personas', 'desc')
            ->get();

        return response()->json($results); 

            }
        
        public function getTotalPersonasPorRegion()
        {
            $results = DB::table('cities')
            ->leftJoin('reports', 'cities.id', '=', 'reports.city')
            ->select(
                'cities.region',
                DB::raw('COALESCE(SUM(reports.total_people), 0) as total_personas'),
                DB::raw('COALESCE(SUM(reports.total_women), 0) as total_mujeres'),
                DB::raw('COALESCE(SUM(reports.total_men), 0) as total_hombres'),
                DB::raw('COALESCE(SUM(reports.total_ethnicity), 0) as total_etnia'),
                DB::raw('COALESCE(SUM(reports.total_deshabilities), 0) as total_discapacitados')
            )
            ->groupBy('cities.region')
            ->orderBy('total_personas', 'desc')
            ->get();

        return response()->json($results);
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
                    'month_name' => $date->format('F') // Aquí obtenemos el nombre del mes
                ];
            }
        
            // Convertir los meses en un formato adecuado para la consulta
            $monthNumbers = array_map(function($month) {
                return sprintf('%04d-%02d', $month['year'], $month['month']);
            }, $months);
        
            // Consulta SQL para obtener los datos
            $results = DB::table('reports')
                ->select(
                    DB::raw('YEAR(TRY_CONVERT(datetime, date, 103)) as year'), // 103 para el formato DD/MM/YYYY
                    DB::raw('MONTH(TRY_CONVERT(datetime, date, 103)) as month'), 
                    DB::raw('SUM(total_people) as total_personas'),
                    DB::raw('SUM(total_women) as total_mujeres'),
                    DB::raw('SUM(total_men) as total_hombres'),
                    DB::raw('SUM(total_ethnicity) as total_etnia'),
                    DB::raw('SUM(total_deshabilities) as total_deshacitados')
                )
                ->whereIn(DB::raw('FORMAT(TRY_CONVERT(datetime, date, 103), \'yyyy-MM\')'), $monthNumbers)
                ->groupBy(
                    DB::raw('YEAR(TRY_CONVERT(datetime, date, 103))'), 
                    DB::raw('MONTH(TRY_CONVERT(datetime, date, 103))')
                )
                ->get();
                
                
            // Crear un array con todos los meses para asegurarnos de que todos los meses están representados
            $data = [];
            foreach ($months as $month) {
                $key = $month['year'] . '-' . str_pad($month['month'], 2, '0', STR_PAD_LEFT);
                $data[$key] = [
                    'month_name' => $month['month_name'], // Usamos el nombre del mes aquí
                    'year' => $month['year'],
                    'total_personas' => 0,
                    'total_mujeres' => 0,
                    'total_hombres' => 0,
                    'total_etnia' => 0,
                    'total_discapacitados' => 0
                ];
            }
        
            // Rellenar los datos de la consulta en el array de datos
            foreach ($results as $result) {
                $key = $result->year . '-' . str_pad($result->month, 2, '0', STR_PAD_LEFT);
                if (isset($data[$key])) {
                    $data[$key]['total_personas'] = $result->total_personas;
                    $data[$key]['total_mujeres'] = $result->total_mujeres;
                    $data[$key]['total_hombres'] = $result->total_hombres;
                    $data[$key]['total_etnia'] = $result->total_etnia;
                    $data[$key]['total_discapacitados'] = $result->total_deshacitados;
                }
            }
        
            // Ordenar los datpublic function index()
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
            uasort($data, function($a, $b) {
                if ($a['year'] === $b['year']) {
                    return $b['month'] - $a['month'];
                }
                return $b['year'] - $a['year'];
            });
        
            // Convertir el formato de fecha antes de devolver la respuesta
            $formattedData = array_map(function($entry) {
                return $entry;
            }, $data);
        
            return response()->json(array_values($formattedData));
        }
        
        
        
        
        public function getTotalComisionesPorMeta()
        {
            try {
                $totalComisionesPorMeta = DB::table('goals')
                    ->leftJoin('reports', 'goals.id', '=', 'reports.goal_id')
                    ->select('goals.goal', 'goals.id', DB::raw('COUNT(DISTINCT reports.comission_number) as total_comisiones'))
                    ->groupBy('goals.goal', 'goals.id')
                    ->orderBy('goals.id') // Ordenar por goal_id
                    ->get();
        
                return response()->json(['total_comisiones_por_meta' => $totalComisionesPorMeta]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por meta: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por meta.'], 500);
            }
        }
        
        
        public function getTotalComisionesPorMunicipio()
        {
            try {
                $totalComisionesPorCiudad = DB::table('cities')
                    ->leftJoin('reports', 'cities.id', '=', 'reports.city')
                    ->select('cities.city', DB::raw('COUNT(DISTINCT reports.comission_number) as total_comisiones'))
                    ->groupBy('cities.city')
                    ->orderBy('cities.city') // Ordenar por city
                    ->get();
        
                return response()->json(['total_comisiones_por_ciudad' => $totalComisionesPorCiudad]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por ciudad: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por ciudad.'], 500);
            }
        }
        
        public function getTotalComisionesPorRegion()
        {
            try {
                $totalComisionesPorRegion = DB::table('cities')
                    ->leftJoin('reports', 'cities.id', '=', 'reports.region')
                    ->select('cities.region', DB::raw('COUNT(DISTINCT reports.comission_number) as total_comisiones'))
                    ->groupBy('cities.region')
                    ->orderBy('cities.region') // Ordenar por city
                    ->get();
        
                return response()->json(['total_comisiones_por_region' => $totalComisionesPorRegion]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por region: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por region.'], 500);
            }
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
    