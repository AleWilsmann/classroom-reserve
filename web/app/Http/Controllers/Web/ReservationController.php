<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Responsible;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('name')->get();
        $reservations = Reservation::with(['room', 'responsible'])->orderBy('start_time', 'desc')->paginate(15);
        return view('reservations.index', compact('reservations', 'rooms'));
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
            'title'          => 'required|string|max:255',
            'room_id'        => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after:start_time',
            'description'    => 'nullable|string',
            'status'         => 'sometimes|in:pendente,ativa,cancelada',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = $validated['status'] ?? 'ativa'; // garante status padrão

        // Verifica se a sala está ativa
        $room = Room::findOrFail($validated['room_id']);
        if ($room->status !== 'ativa') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta sala está inativa e não pode ser reservada.');
        }

        // Verifica conflito de horário
        if (Reservation::hasConflict(
            $validated['room_id'],
            $validated['start_time'],
            $validated['end_time']
        )) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe uma reserva para esta sala neste período.');
        }

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
            'title'          => 'required|string|max:255',
            'room_id'        => 'required|exists:rooms,id',
            'responsible_id' => 'required|exists:responsibles,id',
            'start_time'     => 'required|date',
            'end_time'       => 'required|date|after:start_time',
            'description'    => 'nullable|string',
            'status'         => 'required|in:pendente,ativa,cancelada',
        ]);

        // Verifica se a sala está ativa
        $room = Room::findOrFail($validated['room_id']);
        if ($room->status !== 'ativa') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta sala está inativa e não pode ser reservada.');
        }

        // Verifica conflito de horário (excluindo a própria reserva)
        if (Reservation::hasConflict(
            $validated['room_id'],
            $validated['start_time'],
            $validated['end_time'],
            $reservation->id  // <-- exclui a reserva atual da verificação
        )) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Já existe uma reserva para esta sala neste período.');
        }

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

    public function byRoom($room_id)
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->where('room_id', $room_id)
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $rooms = Room::orderBy('name')->get();
        $selectedRoom = Room::find($room_id);

        return view('reservations.index', compact('reservations', 'rooms', 'selectedRoom'));
    }

    public function byDate($date)
    {
        $reservations = Reservation::with(['room', 'responsible'])
            ->whereDate('start_time', $date)
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $rooms = Room::orderBy('name')->get();
        return view('reservations.index', compact('reservations', 'rooms', 'date'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'cancelada') {
            return redirect()->back()->with('error', 'Reserva já está cancelada.');
        }

        $reservation->update(['status' => 'cancelada']);

        return redirect()->route('reservations.index')
            ->with('success', 'Reserva cancelada com sucesso!');
    }
}