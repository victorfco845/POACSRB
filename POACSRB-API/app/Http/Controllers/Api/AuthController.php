<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;
use App\Models\Job;
use App\Models\Asistent;
use App\Models\Review;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required',
            'password' => 'required'
        ]);
    
        $validatedData['password'] = bcrypt($request->password);
        
        $user = User::create($validatedData);
        
        $accessToken = $user->createToken('authToken')->accessToken;
        
        $profile = Profile::create([
            'name' => 'Nombre por defecto',
            'exp_job' => 'Nombre por defecto',
        ]);
        
        $job = Job::create([
            'jobs' => 'Nombre por defecto',
            'description' => 'Nombre por defecto',
        ]);

        $review = Review::create([
            'review' => 'Revisión predeterminada',
            'calification' => '5',
        ]);
        
        $asistent = Asistent::create([
            'asistent' => 'Default Asistent Name',
            'companie_id' => $job->id,
            'petition_id' => $job->id,
            'job_id' => $job->id,
            'review_id' => $job->id,
            'search_id' => $job->id,
            'profile_id' => $profile->id,
            'user_id' => $user->id,
        ]);

        
        
        return response([
            'profile' => $user,
            'access_token' => $accessToken,
            'asistent' => $asistent,
        ]);
    }
    
    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
    
        if (!auth()->attempt($loginData)) {
            return response([
                'response' => 'Invalid Credentials',
                'message' => 'error'
            ]);
        }
    
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
    
        return response([
            'profile' => auth()->user(),
            'access_token' => $accessToken,
            'message' => 'success',
        ]);
    }
    
    public function authtoken(Request $request) {
        $user = $request->user();
        $accessToken = $user->createToken('authToken')->accessToken;
    
        return response()->json(['access_token' => $accessToken]);
    }
    
    

    public function logout(Request $request) {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } else {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }
    }
    

    public function user(Request $request) {
        $user = $request->user();
        $profile = Profile::where('user_id', '=', $user->id)->first();

        return response()->json([$user, $profile]);
    }
}
