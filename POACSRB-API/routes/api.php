<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CompanieController;
use App\Http\Controllers\Api\PetitionController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AsistentController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('profile')->group(function () {
    Route::get('elements', [ProfileController::class, 'getElements']);
    Route::get('search', [ProfileController::class, 'search']);
    Route::get('view/{id}', [ProfileController::class, 'viewProfile']);
});


// Jobs
Route::get('/jobs', [JobController::class, 'list']);
Route::get('/jobs/{id}', [JobController::class, 'item']);
Route::post('/jjobs', [JobController::class, 'create']); 
Route::post('/jjjobs/{id}', [JobController::class, 'update']);


// Profiles
Route::get('/profiles', [ProfileController::class, 'list']);
Route::get('/profiles/{id}', [ProfileController::class, 'id']);
Route::post('/profiles', [ProfileController::class, 'create']);
Route::post('/profiles/{id}', [ProfileController::class, 'update']);

// Companies
Route::get('/companies', [CompanieController::class, 'list']);
Route::get('/companies/{id}', [CompanieController::class, 'id']);
Route::post('/companies', [CompanieController::class, 'create']);
Route::post('/companies/{id}', [CompanieController::class, 'update']);

// Petitions
Route::get('/petitions', [PetitionController::class, 'list']);
Route::get('/petitions/{id}', [PetitionController::class, 'id']);
Route::post('/petitions', [PetitionController::class, 'create']);
Route::post('/petitions/{id}', [PetitionController::class, 'update']);

Route::post('/asistents/{id}/updatereview', [AsistentController::class, 'updateReview']);

Route::post('/asistents/{id}/edit', [AsistentController::class, 'update']);
// Users
Route::get('/users', [UserController::class, 'list']);
Route::get('/asistents', [AsistentController::class, 'index']);
Route::get('/asistents/{id}', [AsistentController::class, 'show']);

Route::get('/users/{id}', [UserController::class, 'id']);
Route::post('/uusers', [UserController::class, 'create']);
Route::post('/uuusers/{id}', [UserController::class, 'update']);
Route::middleware('auth:api')->post('/authtoken', [AuthController::class, 'authtoken']);

?>
