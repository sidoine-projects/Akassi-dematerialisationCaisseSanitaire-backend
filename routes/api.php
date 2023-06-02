<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
// Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Update Password
Route::put('/update-password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');

// Reset Password
// Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password');


Route::post('/request-password', [AuthController::class, 'requestPassword']);

// Register
Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('permissions', PermissionController::class)->middleware('auth:sanctum');
Route::apiResource('roles', RoleController::class)->middleware('auth:sanctum');
Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
Route::apiResource('patients', PatientController::class)->middleware('auth:sanctum');
Route::apiResource('actmedical', ActMedicalController::class)->middleware('auth:sanctum');
Route::apiResource('quartier', QuartierController::class)->middleware('auth:sanctum');
Route::apiResource('arrondissement', ArrondissementController::class)->middleware('auth:sanctum');
Route::apiResource('commune', CommuneController::class)->middleware('auth:sanctum');
Route::apiResource('pays', PaysController::class)->middleware('auth:sanctum');
Route::apiResource('departement', DepartementController::class)->middleware('auth:sanctum');
Route::post('droitusers', [RoleController::class, 'droitUsers'])->middleware('auth:sanctum');
