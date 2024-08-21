<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\EvidenceController;
use App\Http\Middleware\Api\EnsureTokenIsValid;


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
Route::middleware('ensureTokenIsValid')->group(function () {

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:api')->post('/authtoken', [AuthController::class, 'authtoken']);
Route::post('/', function (Request $request) {
    return response()->json(['message' => 'POST method for root route is not allowed'], 405);
});


    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reportcreate', [ReportController::class, 'create']);
    Route::post('/reportupdate/{id}', [ReportController::class, 'update']);
    Route::delete('/reportdelete/{id}', [ReportController::class, 'delete']);

Route::get('/users', [UserController::class, 'list']);
Route::get('/users/{id}', [UserController::class, 'id']);
Route::post('/usercreate', [UserController::class, 'create']);
Route::post('/userupdate/{id}', [UserController::class, 'update']);


Route::get('/total-personas-por-meta', [ReportController::class, 'getTotalPersonasPorMeta']);

Route::get('/total-personas-por-mes', [ReportController::class, 'getTotalPersonasPorMes']);
Route::get('/total-comisiones-por-meta', [ReportController::class, 'getTotalComisionesPorMeta']);
Route::get('/total-comisiones-por-mes', [ReportController::class, 'getTotalComisionesPorMes']);



Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'show']);

Route::get('/report', [ReportController::class, 'search']);
Route::post('evidenceinsert', [EvidenceController::class, 'insert']);
Route::get('/evidences', [EvidenceController::class, 'index']);
Route::post('/evidencedelete/{id}', [EvidenceController::class, 'delete']);

Route::get('/evidences/{id}', [EvidenceController::class, 'show']);
Route::get('/evidencesid/{id}', [EvidenceController::class, 'searchforid']);


}); 
Route::get('/total-comisiones-por-region', [ReportController::class, 'getTotalComisionesPorRegion']);
Route::get('/total-comisiones-por-municipio', [ReportController::class, 'getTotalComisionesPorMunicipio']);
Route::get('/total-personas-por-municipio', [ReportController::class, 'getTotalPersonasPorMunicipio']);
Route::get('/total-personas-por-region', [ReportController::class, 'getTotalPersonasPorRegion']);