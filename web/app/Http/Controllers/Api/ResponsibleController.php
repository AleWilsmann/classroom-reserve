<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Responsible;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    public function index()
    {
        return response()->json(Responsible::paginate(15));
    }

    public function show(Responsible $responsible)
    {
        return response()->json($responsible);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:responsibles|max:255',
            'phone'       => 'nullable|string|max:20',
            'department'  => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $responsible = Responsible::create($validated);
        return response()->json($responsible, 201);
    }

    public function update(Request $request, Responsible $responsible)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'email'       => 'sometimes|email|unique:responsibles,email,' . $responsible->id . '|max:255',
            'phone'       => 'nullable|string|max:20',
            'department'  => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $responsible->update($validated);
        return response()->json($responsible);
    }

    public function destroy(Responsible $responsible)
    {
        $responsible->delete();
        return response()->json(['message' => 'Responsável removido com sucesso.']);
    }
}