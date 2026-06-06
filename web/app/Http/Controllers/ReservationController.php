<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id()) //lista reservas
            ->where('status', 'active')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return response()->json($reservations);
    }

    public function store(Request $request) //cria reserva
    {
        $data = $request->validate([
            'classroom'  => 'required|string|max:100',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'purpose'    => 'nullable|string|max:255',
        ]);

        if (Reservation::hasConflict($data['classroom'], $data['date'], $data['start_time'], $data['end_time'])) {
            return response()->json([
                'message' => 'Já existe uma reserva para esta sala neste horário.'
            ], 409);
        }//confere conflito de reserva

        $reservation = Reservation::create([
            ...$data,
            'user_id' => Auth::id(),
            'status'  => 'active',
        ]);

        return response()->json($reservation, 201);
    }

    public function cancel(Reservation $reservation)
{
    return response()->json([
        'auth_id'         => Auth::id(),
        'auth_id_type'    => gettype(Auth::id()),
        'reservation_user_id'      => $reservation->user_id,
        'reservation_user_id_type' => gettype($reservation->user_id),
    ]);
}

//     public function cancel(Reservation $reservation)
// {
//     if ((int) $reservation->user_id !== (int) Auth::id()) {
//         return response()->json(['message' => 'Acesso negado.'], 403);
//     }

//     $reservation->update(['status' => 'cancelled']);

//     return response()->json(['message' => 'Reserva cancelada com sucesso.']);
// }
}
