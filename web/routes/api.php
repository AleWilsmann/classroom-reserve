<?php

use App\Http\Controllers\Api\ReservationController as ApiReservationController;
use App\Http\Controllers\Api\RoomController as ApiRoomController;
use App\Http\Controllers\Api\ResponsibleController as ApiResponsibleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin']);

Route::middleware('auth:sanctum')->group(function () {

    // Reservas
    Route::get('/reservations',                        [ApiReservationController::class, 'index']); //lista as reservas
    Route::post('/reservations',                       [ApiReservationController::class, 'store']); //cria reserva 
    Route::get('/reservations/by-room/{room_id}',      [ApiReservationController::class, 'byRoom']);  //lista reserva sala especifica
    Route::get('/reservations/by-date/{date}',         [ApiReservationController::class, 'byDate']);  //lista resevas por data
    Route::get('/reservations/{reservation}',          [ApiReservationController::class, 'show']);  //mostra reserva especifica
    Route::put('/reservations/{reservation}',          [ApiReservationController::class, 'update']); //atualiza uma reserva
    Route::patch('/reservations/{reservation}/cancel', [ApiReservationController::class, 'cancel']); //calncela uma reserva

    // Salas
    Route::get('/rooms',                               [ApiRoomController::class, 'index']); //lista salas
    Route::post('/rooms',                              [ApiRoomController::class, 'store']); //cria sala
    Route::delete('/rooms/{room}',                     [ApiRoomController::class, 'destroy']); //deleta sala

    // Responsáveis
    Route::post('/responsibles',                       [ApiResponsibleController::class, 'store']); //cria responsável
    Route::get('/responsibles',                        [ApiResponsibleController::class, 'index']); //lista responsáveis
    Route::delete('/responsibles/{responsible}',       [ApiResponsibleController::class, 'destroy']); //deleta responsável

});