<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Responsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // GET /reservations
    public function index()
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->where('user_id', Auth::id())
            ->orderBy('start_time')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

   
    public function create()
    {
        $rooms        = Room::orderBy('name')->get();
        $responsibles = Responsible::orderBy('name')->get();

        return view('reservations.create', compact('rooms', 'responsibles'));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:150',
            'room_id'        => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time'     => 'required|date|after_or_equal:now',
            'end_time'       => 'required|date|after:start_time',
            'description'    => 'nullable|string|max:1000',
            'status'         => 'sometimes|in:pending,confirmed,cancelled',
        ]);

        if (Reservation::hasConflict($data['room_id'], $data['start_time'], $data['end_time'])) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => 'Já existe uma reserva para esta sala neste período.']);
        }

        Reservation::create([
            ...$data,
            'user_id' => Auth::id(),
            'status'  => $data['status'] ?? 'pending',
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reserva criada com sucesso!');
    }

    
    public function show(Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        return view('reservations.show', compact('reservation'));
    }


    public function edit(Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        $rooms        = Room::orderBy('name')->get();
        $responsibles = Responsible::orderBy('name')->get();

        return view('reservations.edit', compact('reservation', 'rooms', 'responsibles'));
    }

    
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        $data = $request->validate([
            'title'          => 'required|string|max:150',
            'room_id'        => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after:start_time',
            'description'    => 'nullable|string|max:1000',
            'status'         => 'required|in:pending,confirmed,cancelled',
        ]);

        if (Reservation::hasConflict($data['room_id'], $data['start_time'], $data['end_time'], $reservation->id)) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => 'Já existe uma reserva para esta sala neste período.']);
        }

        $reservation->update($data);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reserva atualizada com sucesso!');
    }

    // cancel
    public function cancel(Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        if ($reservation->status === 'cancelled') {
            return back()->withErrors(['error' => 'Esta reserva já está cancelada.']);
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reserva cancelada com sucesso.');
    }



    private function authorizeReservation(Reservation $reservation): void
    {
        abort_if($reservation->user_id !== Auth::id(), 403, 'Não autorizado.');
    }
}