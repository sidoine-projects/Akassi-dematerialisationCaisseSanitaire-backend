<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MTNController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ActMedicalController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\ArrondissementController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\DepartementController;

use App\Http\Controllers\Pays;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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
// use Illuminate\Auth\Middleware\Authenticate as Middleware;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login']);
// Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('auth/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password');
Route::post('auth/request-password', [AuthController::class, 'requestPassword']);
Route::post('auth/register', [AuthController::class, 'register']);


Route::post('/payment', [MTNController::class, 'makePayment'])->name('payment');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('actmedical', ActMedicalController::class);
    Route::apiResource('quartier', QuartierController::class);
    Route::apiResource('arrondissement', ArrondissementController::class);
    Route::apiResource('commune', CommuneController::class);
    Route::apiResource('pays', PaysController::class);
    Route::apiResource('departement', DepartementController::class);
    Route::post('droitusers', [RoleController::class, 'droitUsers']);
    Route::put('auth/update-password', [AuthController::class, 'updatePassword']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
});