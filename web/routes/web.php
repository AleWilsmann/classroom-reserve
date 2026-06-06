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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
    
    // Routes para Rooms (Salas)
    Route::resource('rooms', RoomController::class);
    
    // Routes para Responsibles
    Route::resource('responsibles', ResponsibleController::class);
    
    // Routes para Reservas
    Route::resource('reservations', ReservationController::class);
});