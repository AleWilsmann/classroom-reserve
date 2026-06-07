<?php

use App\Http\Controllers\Api\ReservationController as ApiReservationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::patch('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    Route::get('/reservations/by-room/{room_id}', [ReservationController::class, 'byRoom']);
    Route::get('/reservations/by-date/{date}', [ReservationController::class, 'byDate']);
    Route::get('/reservations',                        [ApiReservationController::class, 'index']);
    Route::post('/reservations',                       [ApiReservationController::class, 'store']);
    Route::patch('/reservations/{reservation}/cancel', [ApiReservationController::class, 'cancel']);

    
});