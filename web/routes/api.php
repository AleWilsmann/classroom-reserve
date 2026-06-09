<?php

use App\Http\Controllers\Api\ReservationController as ApiReservationController;
use App\Http\Controllers\Api\RoomController as ApiRoomController;
use App\Http\Controllers\Api\ResponsibleController as ApiResponsibleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reservations',                        [ApiReservationController::class, 'index']);
    Route::post('/reservations',                       [ApiReservationController::class, 'store']);
    Route::patch('/reservations/{reservation}/cancel', [ApiReservationController::class, 'cancel']);
    Route::get('/reservations/by-room/{room_id}',      [ApiReservationController::class, 'byRoom']);
    Route::get('/reservations/by-date/{date}',         [ApiReservationController::class, 'byDate']);
    Route::get('/rooms',                               [ApiRoomController::class, 'index']);
    Route::post('/rooms',                              [ApiRoomController::class, 'store']);
    Route::delete('/rooms/{room}',                     [ApiRoomController::class, 'destroy']);
    Route::post('/responsibles',                       [ApiResponsibleController::class, 'store']);
    Route::get('/responsibles',                        [ApiResponsibleController::class, 'index']);
    Route::delete('/responsibles/{responsible}',       [ApiResponsibleController::class, 'destroy']);
 

});
