<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Goal;
use App\Models\City;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index()
{
    try {
        // Obtener todos los informes con las relaciones cargadas
        $reports = Report::with('goal')->get();

        if ($reports->isEmpty()) {
            return response()->json(['message' => 'No reports found.'], 404);
        }

        $transformedReports = $reports->map(function ($report) {
            return [
                'id' => $report->id,
                'title' => $report->title,
                'goal' => $report->goal->goal ?? 'N/A',
                'comission_number' => $report->comission_number,
                'date' => $report->date,
                'user_id' => $report->user_id,
                'total_people' => $report->total_people,
                'total_women' => $report->total_women,
                'total_men' => $report->total_men,
                'total_ethnicity' => $report->total_ethnicity,
                'total_deshabilities' => $report->total_deshabilities,
                'city' => $report->city,
                'region' => $report->region,
                'inform' => $report->inform,
                'evidence_id' => $report->evidence_id,
                'comment' => $report->comment,
            ];
        });

        return response()->json($transformedReports);
    } catch (\Exception $e) {
        \Log::error('Error fetching the reports: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching the reports.'], 500);
    }
}
public function show($id)
{
    try {
        // Obtener el reporte con el goal relacionado
        $report = Report::with('goal')->findOrFail($id);

        return response()->json([
            'id' => $report->id,
            'title' => $report->title,
            'goal' => $report->goal->goal,
            'comission_number' => $report->comission_number,
            'date' => $report->date,
            'user_id' => $report->user_id,
            'total_people' => $report->total_people,
            'total_women' => $report->total_women,
            'total_men' => $report->total_men,
            'total_ethnicity' => $report->total_ethnicity,
            'total_deshabilities' => $report->total_deshabilities,
            'inform' => $report->inform,
            'evidence' => $report->evidence_id,
            'comment' => $report->comment,
        ]);
    } catch (\Exception $e) {
        \Log::error('Error fetching the report: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching the report.'], 500);
    }
}

    
        
public function create(Request $request)
{
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
        'evidence_id' => 'required|integer',
        'comment' => 'nullable|string|max:400',
    ]);

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
        'evidence_id' => $request->input('evidence_id'),
        'comment' => $request->input('comment'),
    ]);

    $report->save();

    return response()->json(['message' => 'Reporte creado exitosamente.'], 201);
}
    
    
public function update(Request $request, $id)
{
    // Validación de datos recibidos
    $request->validate([
        'title' => 'required|string|max:128',
        'goal_id' => 'required|integer', // Asegúrate de que sea un ID entero
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
        'evidence_id' => 'required|integer',
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
                    'month' => $date->month
                ];
            }
        
            // Convertir los meses en un formato adecuado para la consulta
            $monthNumbers = array_map(function($month) {
                return sprintf('%04d-%02d', $month['year'], $month['month']);
            }, $months);
        
            // Consulta SQL para obtener los datos
            $results = DB::table('reports')
                ->select(DB::raw('YEAR(TRY_CONVERT(datetime, date, 120)) as year'), DB::raw('MONTH(TRY_CONVERT(datetime, date, 120)) as month'), 
                             DB::raw('SUM(total_people) as total_personas'),
                             DB::raw('SUM(total_women) as total_mujeres'),
                             DB::raw('SUM(total_men) as total_hombres'),
                             DB::raw('SUM(total_ethnicity) as total_etnia'),
                             DB::raw('SUM(total_deshabilities) as total_deshacitados'))
                ->whereIn(DB::raw('FORMAT(TRY_CONVERT(datetime, date, 120), \'yyyy-MM\')'), $monthNumbers)
                ->groupBy(DB::raw('YEAR(TRY_CONVERT(datetime, date, 120))'), DB::raw('MONTH(TRY_CONVERT(datetime, date, 120))'))
                ->get();
        
            // Crear un array con todos los meses para asegurarnos de que todos los meses están representados
            $data = [];
            foreach ($months as $month) {
                $key = $month['year'] . '-' . str_pad($month['month'], 2, '0', STR_PAD_LEFT);
                $data[$key] = [
                    'month' => $month['month'],
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
        
            // Ordenar los datos del mes actual hacia atrás
            uasort($data, function($a, $b) {
                // Primero comparar años
                if ($a['year'] === $b['year']) {
                    // Si los años son iguales, comparar meses
                    return $b['month'] - $a['month'];
                }
                // Si los años son diferentes, ordenar por año
                return $b['year'] - $a['year'];
            });
        
            return response()->json(array_values($data));
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
        

        public function busqueda(Request $request)
        {
            $query = Report::query();
    
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
            }
    
            if ($request->has('goal_id')) {
                $query->where('goal_id', $request->input('goal_id'));
            }
    
            if ($request->has('comission_number')) {
                $query->where('comission_number', 'like', '%' . $request->input('comission_number') . '%');
            }
    
            if ($request->has('city')) {
                $query->where('city', $request->input('city'));
            }
    
            if ($request->has('region')) {
                $query->where('region', $request->input('region'));
            }
    
            if ($request->has('user_id')) {
                $query->where('user_id', $request->input('user_id'));
            }
    
            $reports = $query->get();
    
            return response()->json($reports);
        }
    }
    