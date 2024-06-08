<?php

use App\Http\Controllers\Api\Emergency\EmergencyController;
use App\Http\Controllers\Api\Employee\EmployeeController;
use App\Http\Controllers\Api\Guard\GuardController;
use App\Http\Controllers\Api\Vehicle\VehicleController;
use App\Http\Controllers\Api\Vehicle\VehicleNoteController;
use App\Http\Controllers\Api\Workplace\WorkplaceController;
use App\Models\Employee\EmployeePosition;
use App\Models\Workplace\Detachment;
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
        Route::get('/current/units', [GuardController::class, 'getUnits']);
        Route::get('/internal-service-types', [GuardController::class, 'getInternalServiceTypes']);
        Route::get('/{guard}/end-guard-data', [GuardController::class, 'getEndGuardData']);
        Route::post('/{guard}/create-units', [GuardController::class, 'createUnits']);
        Route::post('/{guard}/create-vehicle-notes', [GuardController::class, 'createVehicleNotes']);
        Route::post('/{guard}/end-guard', [GuardController::class, 'endGuard']);
    });

    Route::prefix('emergencies')->group(function () {
        Route::get('/', [EmergencyController::class, 'getActiveEmergencies']);
        Route::get('/{emergency}', [EmergencyController::class, 'getEmergency']);
        Route::post('/{emergency}/accept-liquidation', [EmergencyController::class, 'acceptLiquidation']);
        Route::post('/{emergency}/decline-liquidation', [EmergencyController::class, 'declineLiquidation']);
        Route::post('/{emergency}/close', [EmergencyController::class, 'closeLiquidation']);
        Route::post('/{emergency}/sync-liquidations', [EmergencyController::class, 'syncLiquidations']);
        Route::get('/{emergency}/comments', [EmergencyController::class, 'getComments']);
        Route::post('/{emergency}/comments', [EmergencyController::class, 'storeComment']);
        Route::get('/types', [EmergencyController::class, 'getTypes']);
    });

    Route::prefix('workplaces')->group(function() {
        Route::get('/firehouses', [WorkplaceController::class, 'getFirehouses']);
    });
});

Route::get('test', function () {
    $data = \App\Models\Emergency\Emergency::create([
       'type_id' => 1,
       'address' => 'м. Київ, вул. Полякова, 5',
       'comment' => 'Горить магазин АТБ. Повідомив гр. Анатолій Тарасович Товшенко',
       'reporter_workplace_id' => 1,
       'reporter_workplace_type' => Detachment::class,
       'reporter_id' => 35,
       'reported_at' => \Carbon\Carbon::now(),
       'closed_at' => null,
   ]);

    \App\Models\Emergency\EmergencyLiquidationRequest::create([
        'emergency_id' => $data->id,
        'firehouse_id' => 1,
        'is_accepted' => null,
    ]);

//   $data = \App\Models\Employee\Employee::create([
//       'first_name' => 'Xyz-asd',
//       'last_name' => 'Dispatcher-asd',
//       'patronymic' => 'A',
//       'workplace_id' => 1,
//       'workplace_type' => Detachment::class,
//       'position_id' => EmployeePosition::getDispatcherId(),
//   ]);

   return response()->json($data);
});
