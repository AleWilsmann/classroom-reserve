<?php

namespace App\Http\Controllers;

use App\Models\Responsible;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    /**
     * Display a listing of the responsibles.
     */
    public function index()
    {
        $responsibles = Responsible::paginate(15);
        return view('responsibles.index', compact('responsibles'));
    }

    /**
     * Show the form for creating a new responsible.
     */
    public function create()
    {
        return view('responsibles.create');
    }

    /**
     * Store a newly created responsible in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:responsibles|max:255',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Responsible::create($validated);

        return redirect()->route('responsibles.index')
                        ->with('success', 'Responsável criado com sucesso!');
    }

    /**
     * Display the specified responsible.
     */
    public function show(Responsible $responsible)
    {
        return view('responsibles.show', compact('responsible'));
    }

    /**
     * Show the form for editing the specified responsible.
     */
    public function edit(Responsible $responsible)
    {
        return view('responsibles.edit', compact('responsible'));
    }

    /**
     * Update the specified responsible in storage.
     */
    public function update(Request $request, Responsible $responsible)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:responsibles,email,' . $responsible->id . '|max:255',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $responsible->update($validated);

        return redirect()->route('responsibles.index')
                        ->with('success', 'Responsável atualizado com sucesso!');
    }

    /**
     * Remove the specified responsible from storage.
     */
    public function destroy(Responsible $responsible)
    {
        $responsible->delete();

        return redirect()->route('responsibles.index')
                        ->with('success', 'Responsável removido com sucesso!');
    }
}
