<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            return response()->json(['message' => 'The User was not found'], 404);
        }
        return response()->json($user);
    }
    public function create(Request $request)
    {
        // Validación de los campos enviados en la solicitud
        $request->validate([
            'user' => 'required|string|max:128',
            'email' => 'required|string|email|max:128',
            'password' => 'required|string|max:128',
            'user_number' => 'required|integer',
            'job' => 'required|string|max:128',
            'level' => 'required|integer',
        ]);
    
        try {
            // Verificar si ya existe un usuario con el mismo correo electrónico
            $existingEmail = User::where('email', $request->email)->first();
            if ($existingEmail) {
                return response()->json(['error' => 'The email is already registered'], 422);
            }
    
            // Verificar si ya existe un usuario con el mismo número de empleado
            $existingUserNumber = User::where('user_number', $request->user_number)->first();
            if ($existingUserNumber) {
                return response()->json(['error' => 'The employee number is already registered'], 422);
            }
    
            // Si no hay conflictos, crear el nuevo usuario
            $user = new User([
                'user' => $request->user,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_number' => $request->user_number,
                'job' => $request->job,
                'status' => 'activo',
                'level' => $request->level,
            ]);
            $user->save();
    
            // Cargar el usuario creado (para incluir datos en la respuesta)
            $createdUser = User::find($user->id);
    
            // Transformar la información del usuario
            $transformedUser = [
                'id' => $createdUser->id,
                'user' => $createdUser->user,
                'email' => $createdUser->email,
                'user_number' => $createdUser->user_number,
                'job' => $createdUser->job,
                'status' => $createdUser->status,
                'level' => $createdUser->level,
            ];
    
            // Devolver la información del usuario creado en la respuesta
            return response()->json([
                'message' => 'User successfully created',
                'user' => $transformedUser
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the user. Please try again later.'], 500);
        }
    }
    


    public function update(Request $request, $id)
    {
        $request->validate([
            'user' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users,email,' . $id,
            'password' => 'string|max:128|nullable',
            'user_number' => 'required|integer|unique:users,user_number,' . $id,
            'job' => 'required|string|max:128',
            'status' => 'required|string|max:128',
            'level' => 'required|integer',
        ], [
            'email.unique' => 'The email is already registered',
            'user_number.unique' => 'The employee number is already registered',
        ]);

        $user = User::findOrFail($id);

        $user->user = $request->user;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->user_number = $request->user_number;
        $user->job = $request->job;
        $user->status = $request->status;
        $user->level = $request->level;

        $user->save();

        return response()->json(['message' => 'User successfully updated'], 200);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User successfully deleted'], 200);
    }


}
