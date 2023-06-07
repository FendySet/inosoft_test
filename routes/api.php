<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VehicleController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'api','prefix' => 'auth'], function () {    
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::post('me', [AuthController::class, 'me'])->middleware('auth');
});

Route::group(['middleware' => 'api','prefix' => 'vehicle'], function () {    
    Route::post('create', [VehicleController::class, 'store'])->middleware('auth');
    Route::post('show', [VehicleController::class, 'show'])->middleware('auth');
    Route::post('{id}/update', [VehicleController::class, 'update'])->middleware('auth');
    Route::post('{id}/delete', [VehicleController::class, 'destroy'])->middleware('auth');
});

Route::group(['middleware' => 'api','prefix' => 'vehicle_sale'], function () {    
    Route::post('create', [VehicleController::class, 'sale'])->middleware('auth');
});

Route::group(['middleware' => 'api','prefix' => 'vehicle_supply'], function () {    
    Route::post('create', [VehicleController::class, 'supply'])->middleware('auth');
});


