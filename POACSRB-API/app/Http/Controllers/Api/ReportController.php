<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        // Obtener todos los informes
        $reports = Report::all();
        return response()->json($reports);
    }

    public function create(Request $request)
    {
    // Validación de datos recibidos
    $request->validate([
        'title' => 'required|string|max:128',
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

    try {
        $report = Report::create($request->all());

        return response()->json(['message' => 'Report created successfully', 'report' => $report], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while creating the report. Please try again later.'], 500);
    }
    }

    

    public function show($id)
    {
        // Obtener un informe por ID
        $report = Report::findOrFail($id);
        return response()->json($report);
    }
    public function update(Request $request, $id)
    {
        // Validación de datos recibidos
        $request->validate([
            'title' => 'required|string|max:128',
            'comission_number' => 'required|string|max:128|unique:reports,comission_number,' . $id,
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
}
