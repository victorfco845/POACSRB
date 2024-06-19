<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
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

        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }

    /**
     * Login a user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'Correo_Institucional' => 'required|string|email|max:128',
            'Numero_de_Empleado' => 'required|integer',
        ]);
    
        $usuario = User::where('Correo_Institucional', $request->Correo_Institucional)
                       ->where('Numero_de_Empleado', $request->Numero_de_Empleado)
                       ->first();
    
        if (!$usuario) {
            throw ValidationException::withMessages([
                'Correo_Institucional' => ['Las credenciales proporcionadas son incorrectas.'],
                'Numero_de_Empleado' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }
    
        // Authenticate the user based on your application's logic
        Auth::login($usuario);
    
        return response()->json(['message' => 'Inicio de sesión exitoso'], 200);
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request)
    {
        // Revoke the token
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Cierre de sesión exitoso'], 200);
    }
}
