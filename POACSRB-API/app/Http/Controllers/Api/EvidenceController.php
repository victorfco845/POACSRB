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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'evidence' => 'required|image',
            'report_id' => 'required|exists:reports,id',
        ]);

        $evidenceData = file_get_contents($request->file('evidence')->getRealPath()); // Obtener el contenido de la imagen como bytes

        Evidence::create([
            'evidence' => $evidenceData,
            'report_id' => $request->input('report_id'),
        ]);

        return response()->json(['message' => 'Evidence stored successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evidence = Evidence::findOrFail($id);

        return response($evidence->evidence)->header('Content-Type', 'image/jpeg'); // Cambia 'image/jpeg' según el tipo de imagen almacenada
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $evidence = Evidence::findOrFail($id);
        $evidence->delete();

        return response()->json(['message' => 'Evidence deleted successfully']);
    }
}
