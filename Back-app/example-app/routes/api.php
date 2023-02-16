<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CommercialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Routes pour l'authentification
Route::post('/login', [ApiAuthController::class, 'login'])->name('user.login');



// Routes pour les utilisateurs (accessibles uniquement si l'utilisateur est connecté)
Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@getUser');
});

// Routes pour les commerciaux (accessibles uniquement si l'utilisateur est connecté)
Route::middleware('auth:api')->group(function () {
    Route::get('/commercials', [CommercialController::class, 'getAllCommercial'])->name('commercials.list');
    Route::get('/commercial/{id}', [CommercialController::class, 'show'])->name('commercials.commercial');
    Route::get('/commercial/{id}/appointments', [CommercialController::class, 'appointments'])->name('commercials.appointments');
});

// Routes pour les rendez-vous (accessibles uniquement si l'utilisateur est connecté)
Route::middleware('auth:api')->group(function () {
    //Route::post('/appointment/{id}', [CommercialController::class, 'getAllCommercials'])->name('commercials.show');
    //Route::delete('/appointment/{id}', [CommercialController::class, 'getAllCommercials'])->name('commercials.show');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('user.logout');
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});
