<?php

use App\Http\Controllers\Api\Employee\EmployeeController;
use App\Http\Controllers\Api\Guard\GuardController;
use App\Http\Controllers\Api\Vehicle\VehicleController;
use App\Http\Controllers\Api\Vehicle\VehicleNoteController;
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
Route::get('guards/{guard}/end-guard-data', [GuardController::class, 'getEndGuardData']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth', function () {
        return 'User is authorized';
    });

    Route::prefix('employees')->group(function() {
       Route::get('/', [EmployeeController::class, 'getEmployees']);
    });

    Route::prefix('vehicles')->group(function() {
        Route::get('/', [VehicleController::class, 'getVehicles']);

        Route::prefix('notes')->group(function() {
            Route::get('/states', [VehicleNoteController::class, 'getStates']);
        });
    });

    Route::prefix('guards')->group(function() {
        Route::post('/', [GuardController::class, 'startGuard']);
        Route::get('/current', [GuardController::class, 'getCurrentGuard']);
        Route::post('/{guard}/create-units', [GuardController::class, 'createUnits']);
        Route::post('/{guard}/create-vehicle-notes', [GuardController::class, 'createVehicleNotes']);
        Route::get('/internal-service-types', [GuardController::class, 'getInternalServiceTypes']);
    });
});

Route::get('test', function () {
   return \Illuminate\Support\Facades\Hash::make('12345678');
});
