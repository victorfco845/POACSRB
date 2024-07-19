<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Goal;
use App\Models\City;


class ReportController extends Controller
{
    public function index()
{
    try {
        // Obtener todos los informes con las relaciones cargadas
        $reports = Report::with('goal')->get(); // Eliminado 'city'

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
                'goal_id' => 'required|string|max:128',
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
            ]);// Validación de datos recibidos
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
            'comment' => 'nullable|string|max:400',
        ]);
    
        // Crea el reporte
        $report = new Report([
            'title' => $request->input('title'),
            'goal_id' => $request->input('goal_id'), // Usa goal_id directamente
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
    
        $report->save();
    
        return response()->json(['message' => 'Reporte creado exitosamente.'], 201);
        
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
            try {
                $totalPersonasPorMunicipio = Report::select('cities.city', DB::raw('SUM(total_people) as total_personas'))
                    ->join('cities', 'reports.city_id', '=', 'cities.id') // Asegúrate de usar 'city_id'
                    ->groupBy('cities.city')
                    ->get();
        
                return response()->json(['total_personas_por_municipio' => $totalPersonasPorMunicipio]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total personas por municipio: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total personas por municipio.'], 500);
            }
        }
        
        public function getTotalPersonasPorRegion()
        {
            try {
                $totalPersonasPorRegion = Report::select('cities.region', DB::raw('SUM(total_people) as total_personas'))
                    ->join('cities', 'reports.city_id', '=', 'cities.id') // Asegúrate de usar 'city_id'
                    ->groupBy('cities.region')
                    ->get();
        
                return response()->json(['total_personas_por_region' => $totalPersonasPorRegion]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total personas por región: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total personas por región.'], 500);
            }
        }
        
        public function getTotalPersonasPorMes()
        {
            try {
                $totalPersonasPorMes = Report::select(DB::raw('LEFT(date, 7) as mes'), DB::raw('SUM(total_people) as total_personas'))
                    ->groupBy(DB::raw('LEFT(date, 7)'))
                    ->get();
        
                return response()->json(['total_personas_por_mes' => $totalPersonasPorMes]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total personas por mes: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total personas por mes.'], 500);
            }
        }
        
        public function getTotalComisionesPorMeta()
        {
            try {
                $totalComisionesPorMeta = Report::select('goals.goal', DB::raw('COUNT(*) as total_comisiones'))
                    ->join('goals', 'reports.goal_id', '=', 'goals.id')
                    ->groupBy('goals.goal')
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
                $totalComisionesPorMunicipio = Report::select('cities.city', DB::raw('COUNT(*) as total_comisiones'))
                    ->join('cities', 'reports.city_id', '=', 'cities.id') // Asegúrate de usar 'city_id'
                    ->groupBy('cities.city')
                    ->get();
        
                return response()->json(['total_comisiones_por_municipio' => $totalComisionesPorMunicipio]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por municipio: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por municipio.'], 500);
            }
        }
        
        public function getTotalComisionesPorRegion()
        {
            try {
                $totalComisionesPorRegion = Report::select('cities.region', DB::raw('COUNT(*) as total_comisiones'))
                    ->join('cities', 'reports.city_id', '=', 'cities.id') // Asegúrate de usar 'city_id'
                    ->groupBy('cities.region')
                    ->get();
        
                return response()->json(['total_comisiones_por_region' => $totalComisionesPorRegion]);
            } catch (\Exception $e) {
                \Log::error('Error fetching total comisiones por región: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred while fetching total comisiones por región.'], 500);
            }
        }
        
    }
    