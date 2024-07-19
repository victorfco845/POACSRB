<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ReportController;



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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/users', [UserController::class, 'list']);
Route::get('/users/{id}', [UserController::class, 'id']);
Route::post('/usercreate', [UserController::class, 'create']);
Route::post('/userupdate/{id}', [UserController::class, 'update']);
Route::post('/userdelete/{id}', [UserController::class, 'delete']);

Route::middleware('auth:api')->post('/authtoken', [AuthController::class, 'authtoken']);
Route::post('/', function (Request $request) {
    return response()->json(['message' => 'POST method for root route is not allowed'], 405);
});

Route::get('/cities', [CityController::class, 'index']);
Route::get('/cities/{id}', [CityController::class, 'show']);

Route::get('/reports', [ReportController::class, 'index']);
Route::get('/reports/{id}', [ReportController::class, 'show']);
Route::post('/reports', [ReportController::class, 'create']); // POST para crear
Route::post('/reports/{id}', [ReportController::class, 'update']); // Cambiado a POST para actualizar
Route::delete('/reports/{id}', [ReportController::class, 'delete']); // DELETE para eliminar

Route::get('/total-personas-por-meta', [ReportController::class, 'getTotalPersonasPorMeta']);
Route::get('/total-personas-por-municipio', [ReportController::class, 'getTotalPersonasPorMunicipio']);
Route::get('/total-personas-por-region', [ReportController::class, 'getTotalPersonasPorRegion']);
Route::get('/total-personas-por-mes', [ReportController::class, 'getTotalPersonasPorMes']);
Route::get('/total-comisiones-por-meta', [ReportController::class, 'getTotalComisionesPorMeta']);
Route::get('/total-comisiones-por-municipio', [ReportController::class, 'getTotalComisionesPorMunicipio']);
Route::get('/total-comisiones-por-region', [ReportController::class, 'getTotalComisionesPorRegion']);