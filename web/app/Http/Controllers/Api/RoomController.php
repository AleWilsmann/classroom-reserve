<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::all());
    }

    public function show(Room $room)
    {
        return response()->json($room);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'location'    => 'nullable|string',
            'equipment'   => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:ativa,inativa',
        ]);

        $room = Room::create($validated);
        return response()->json($room, 201);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'capacity'    => 'sometimes|integer|min:1',
            'location'    => 'nullable|string',
            'equipment'   => 'nullable|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:ativa,inativa',
        ]);

        $room->update($validated);
        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['message' => 'Sala removida com sucesso.']);
    }
}