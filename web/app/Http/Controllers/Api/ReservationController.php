<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // GET /api/reservations
    public function index()
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->where('user_id', Auth::id())
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json($reservations);
    }

    // POST /api/reservations
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'room_id'        => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after:start_time',
            'description'    => 'nullable|string|max:1000',
            'status' => 'sometimes|in:pendente,ativa,cancelada',
        ]);

        // verifica se a sala está ativa
        $room = Room::findOrFail($data['room_id']);
        if ($room->status !== 'ativa') {
            return response()->json([
                'message' => 'Esta sala está inativa e não pode ser reservada.'
            ], 422);
        }

        if (Reservation::hasConflict(
            $data['room_id'],
            $data['start_time'],
            $data['end_time']
        )) {
            return response()->json([
                'message' => 'Já existe uma reserva para esta sala neste período.'
            ], 409);
        }

        $reservation = Reservation::create([
            ...$data,
            'user_id' => Auth::id(),
            'status' => $data['status'] ?? 'ativa',
        ]);

        return response()->json(
            $reservation->load(['room', 'responsible']),
            201
        );
    }

    // PATCH /api/reservations/{reservation}/cancel
    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        if ($reservation->status === 'cancelada') {
            return response()->json(['message' => 'Reserva já está cancelada.'], 422);
        }

        $reservation->update(['status' => 'cancelada']);

        return response()->json([
            'message'     => 'Reserva cancelada com sucesso.',
            'reservation' => $reservation->load(['room', 'responsible']),
        ]);
    }


    public function byRoom($room_id)
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->where('room_id', $room_id)
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json($reservations);
    }


    public function byDate($date)
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->whereDate('start_time', $date)
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json($reservations);
    }

    
}