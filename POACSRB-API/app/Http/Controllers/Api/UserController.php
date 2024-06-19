<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de importar el modelo User correctamente aquí
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function id($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'El Usuario no se encuentra'], 404);
        }
        return response()->json($user);
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:128',
            'Apellidos' => 'required|string|max:128',
            'Correo_Institucional' => 'required|string|email|max:128|unique:usuarios',
            'Numero_de_Empleado' => 'required|integer|unique:usuarios',
            'Puesto' => 'required|string|max:128',
            'Nivel' => 'required|integer',
        ]);

        $usuario = new User([
            'Nombre' => $request->Nombre,
            'Apellidos' => $request->Apellidos,
            'Correo_Institucional' => $request->Correo_Institucional,
            'Numero_de_Empleado' => $request->Numero_de_Empleado,
            'Puesto' => $request->Puesto,
            'Nivel' => $request->Nivel,
        ]);

        $usuario->save();

        return response()->json(['message' => 'Usuario creado con éxito'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nombre' => 'required|string|max:128',
            'Apellidos' => 'required|string|max:128',
            'Correo_Institucional' => 'required|string|email|max:128|unique:usuarios,Correo_Institucional,'.$id.',id_usuario',
            'Numero_de_Empleado' => 'required|integer|unique:usuarios,Numero_de_Empleado,'.$id.',id_usuario',
            'Puesto' => 'required|string|max:128',
            'Nivel' => 'required|integer',
        ]);

        $usuario = User::findOrFail($id);

        $usuario->Nombre = $request->Nombre;
        $usuario->Apellidos = $request->Apellidos;
        $usuario->Correo_Institucional = $request->Correo_Institucional;
        $usuario->Numero_de_Empleado = $request->Numero_de_Empleado;
        $usuario->Puesto = $request->Puesto;
        $usuario->Nivel = $request->Nivel;

        $usuario->save();

        return response()->json(['message' => 'Usuario actualizado con éxito'], 200);
    }

    public function delete($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito'], 200);
    }
}
