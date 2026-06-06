<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Responsible;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['room', 'responsible'])->orderBy('start_time', 'desc')->paginate(15);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $rooms = Room::orderBy('name')->get();
        $responsibles = Responsible::orderBy('name')->get();

        return view('reservations.create', compact('rooms', 'responsibles'));
    }

    public function store(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Sua sessão expirou. Faça login novamente.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $validated['user_id'] = Auth::id();

        Reservation::create($validated);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reserva criada com sucesso!');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['room', 'responsible']);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $rooms = Room::orderBy('name')->get();
        $responsibles = Responsible::orderBy('name')->get();

        return view('reservations.edit', compact('reservation', 'rooms', 'responsibles'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')
                         ->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Reserva removida com sucesso!');
    }
}
