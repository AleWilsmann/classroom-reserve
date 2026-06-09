<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ReservationController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\ResponsibleController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::patch('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);

    
    // Routes para Rooms (Salas)
    Route::resource('rooms', RoomController::class);
    
    // Routes para Responsibles
    Route::resource('responsibles', ResponsibleController::class);

    Route::get('/reservations/by-room/{room_id}', [ReservationController::class, 'byRoom'])->name('reservations.byRoom');
    Route::get('/reservations/by-date/{date}', [ReservationController::class, 'byDate'])->name('reservations.byDate');
    
    // Routes para Reservas
    Route::resource('reservations', ReservationController::class);
});