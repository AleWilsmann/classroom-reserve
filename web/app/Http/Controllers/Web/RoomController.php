<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms.
     */
    public function index()
    {
        $rooms = Room::paginate(15);
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:rooms|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'equipment' => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:ativa,inativa',
        ]);

        // Converter equipamentos string em array
        if ($validated['equipment']) {
            $validated['equipment'] = array_map('trim', explode(',', $validated['equipment']));
        } else {
            $validated['equipment'] = [];
        }

        Room::create($validated);

        return redirect()->route('rooms.index')
                        ->with('success', 'Sala criada com sucesso!');
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:rooms,name,' . $room->id . '|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'equipment' => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:ativa,inativa',
        ]);

        // Converter equipamentos string em array
        if ($validated['equipment']) {
            $validated['equipment'] = array_map('trim', explode(',', $validated['equipment']));
        } else {
            $validated['equipment'] = [];
        }

        $room->update($validated);

        return redirect()->route('rooms.index')
                        ->with('success', 'Sala atualizada com sucesso!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
                        ->with('success', 'Sala removida com sucesso!');
    }
}
