<?php

use App\Http\Controllers\Api\ReservationController as ApiReservationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reservations',                        [ApiReservationController::class, 'index']);
    Route::post('/reservations',                       [ApiReservationController::class, 'store']);
    Route::patch('/reservations/{reservation}/cancel', [ApiReservationController::class, 'cancel']);
    
});