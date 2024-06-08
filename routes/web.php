<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::view('/login', 'app')->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'getCurrentUserData']);

    Route::view('/guard/start', 'app');
    Route::view('/guard/create-units', 'app');
    Route::view('/guard/create-vehicle-notes', 'app');
    Route::view('/guard/end', 'app');

    Route::view('/emergencies/{emergency}', 'app');

    Route::view('/documents/service-book', 'app');
    Route::view('/documents/vehicle-log-book', 'app');
    Route::view('/documents/dispatcher-log-book', 'app');

    Route::view('/', 'app');
});

