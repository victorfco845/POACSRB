<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evidence;

class EvidenceController extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evidences = Evidence::all();
        
        foreach ($evidences as $evidence) {
            $evidence->evidence_url = asset('storage/' . $evidence->evidence);
        }
        
        return response()->json($evidences);
    }
    
    

    public function show($id)
    {
        $evidence = Evidence::findOrFail($id);
        
        $fileUrl = asset('storage/' . $evidence->evidence);
        
        return response()->json(['url' => $fileUrl]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'evidence' => 'nullable|image', // Validar que sea una imagen si se proporciona
            'report_id' => 'required|exists:reports,id', // Validar que el report_id exista en la tabla reports
        ]);

        $evidence = Evidence::findOrFail($id);

        if ($request->hasFile('evidence')) {
            $evidenceData = file_get_contents($request->file('evidence')->getRealPath()); // Obtener el contenido de la imagen como bytes
            $evidence->evidence = $evidenceData;
        }

        $evidence->report_id = $request->input('report_id');
        $evidence->save();

        return response()->json(['message' => 'Evidence updated successfully']);
    }


    public function insert(Request $request)
    {
        $request->validate([
            'evidence' => 'required|image',
            'report_id' => 'required|exists:reports,id',
        ]);
    
        $file = $request->file('evidence');
    
        $path = $file->store('evidence', 'public');
    
        Evidence::create([
            'evidence' => $path,
            'report_id' => $request->input('report_id'),
        ]);
    
        return response()->json(['path' => asset('storage/' . $path)]);
    }
    
public function delete($id)
{
    try {
        // Encuentra el registro por ID
        $evidence = Evidence::findOrFail($id);

        // Elimina el registro
        $evidence->delete();

        // Retorna una respuesta de éxito
        return response()->json(['message' => 'Evidence deleted successfully.'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Si no se encuentra el registro, retorna un error 404
        return response()->json(['error' => 'Evidence not found'], 404);
    } catch (\Exception $e) {
        // Manejo a otros errores
        \Log::error('Error deleting evidence: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while deleting the evidence. Please try again later.'], 500);
    }
}

public function searchforid($reportId)
{
    $evidences = Evidence::where('report_id', $reportId)->get();

    if ($evidences->isEmpty()) {
        return response()->json(['message' => 'No evidence found'], 404);
    }

    $evidences->transform(function ($evidence) {
        $fileUrl = url('storage/' . $evidence->evidence);

        \Log::info("Generated file URL: " . $fileUrl);

        $evidence->evidence = $fileUrl;
        
        return $evidence;
    });

    return response()->json($evidences);
}




}