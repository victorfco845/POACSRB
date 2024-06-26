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
        $request->validate([
            'user' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users,email',
            'password' => 'required|string|max:128',
            'user_number' => 'required|integer|unique:users,user_number',
            'job' => 'required|string|max:128',
            'level' => 'required|integer',
        ], [
            'email.unique' => 'The email is already registered',
            'user_number.unique' => 'The employee number is already registered',
        ]);
        $user = new User([
            'user' => $request->user,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_number' => $request->user_number,
            'job' => $request->job,
            'level' => $request->level,
        ]);

        $user->save();

        return response()->json(['message' => 'User successfully created'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user' => 'required|string|max:128',
            'email' => 'required|string|email|max:128|unique:users,email,' . $id,
            'password' => 'string|max:128|nullable',
            'user_number' => 'required|integer|unique:users,user_number,' . $id,
            'job' => 'required|string|max:128',
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
