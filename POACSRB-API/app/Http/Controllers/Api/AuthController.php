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
    public function login(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'email' => 'required|string|email|max:128',
            'password' => 'required|string|max:128',
        ]);

        // Busca el usuario por correo electrónico
        $user = User::where('email', $request->email)->first();

        // Verifica si el usuario existe, si la contraseña es correcta y si el estado es 'activo'
        if (!$user || !Hash::check($request->password, $user->password) || $user->status !== 'activo') {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or the user is not active.'],
            ]);
        }

        // Inicia sesión para el usuario
        Auth::login($user);

        // Devuelve una respuesta JSON con el usuario y un mensaje de éxito
        return response()->json([
            'message' => 'Successful login',
            'user' => $user
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successful logout'], 200);
    }
}
