<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContractController;
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

Route::post('/register-user', [UserController::class, 'registerUser']);
Route::post('/login-user', [UserController::class, 'loginPost']);

// Route::resource('accommodations', AccommodationController::class);

Route::middleware(['api','auth:sanctum'])->group(function () {
    Route::post('/logout-user', [UserController::class, 'logout']);
    Route::resource('accommodations', AccommodationController::class);
    Route::resource('contracts', ContractController::class);
    Route::post('/bookings', [BookingController::class, 'store']);
});
