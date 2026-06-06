<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ResponsibleController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reservas (resource completo + rota de cancelamento)
    Route::resource('reservations', ReservationController::class);
    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
         ->name('reservations.cancel');

    // Salas
    Route::resource('rooms', RoomController::class);

    // Responsáveis
    Route::resource('responsibles', ResponsibleController::class);

});