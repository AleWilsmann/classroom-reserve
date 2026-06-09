<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Responsible;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $salasAula        = Room::count();
        $totalResponsaveis = Responsible::count();
        $reservasHoje     = Reservation::whereDate('start_time', today())->count();
        $reservasPendentes = Reservation::where('status', 'pendente')->count();

        $proximasReservas = Reservation::with(['room', 'responsible'])
            ->where('start_time', '>=', now())
            ->whereIn('status', ['ativa', 'pendente'])
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $reservasHojeList = Reservation::with(['room', 'responsible'])
            ->whereDate('start_time', today())
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('auth.dashboard', compact(
            'salasAula',
            'totalResponsaveis',
            'reservasHoje',
            'reservasPendentes',
            'proximasReservas',
            'reservasHojeList'
        ));
    }
}