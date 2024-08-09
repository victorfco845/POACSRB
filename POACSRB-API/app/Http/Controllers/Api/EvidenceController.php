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
        return response()->json($evidences);
    }

    public function show($id)
    {
        $evidence = Evidence::findOrFail($id);
    
        // Generar la URL completa para la imagen almacenada
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




    public function testUpload(Request $request)
{
    $file = $request->file('evidence');
    $path = $file->store('evidence', 'public');
    return response()->json(['path' => $path]);
}

public function store(Request $request)
{
    // Validar la solicitud
    $request->validate([
        'evidence' => 'required|image', // Validar que sea una imagen
        'report_id' => 'required|exists:reports,id', // Validar que el report_id exista en la tabla reports
    ]);

    // Obtener el archivo de la solicitud
    $file = $request->file('evidence');
    
    // Almacenar el archivo y obtener la ruta
    $path = $file->store('evidence', 'public'); // Guardar en storage/app/public/evidence

    // Crear un nuevo registro en la base de datos
    Evidence::create([
        'evidence' => $path, // Guardar la ruta del archivo
        'report_id' => $request->input('report_id'), // Asociar con el ID del reporte
    ]);

    // Devolver una respuesta de éxito en la base de datos
    return response()->json(['path' => $path]);
}

}