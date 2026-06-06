{{-- resources/views/reservations/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">

    <h1 class="text-2xl font-bold mb-6">Nova Reserva</h1>

    @if($errors->has('conflict'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
            {{ $errors->first('conflict') }}
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4 bg-white shadow rounded p-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sala</label>
            <select name="classroom" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione uma sala...</option>
                @foreach($classrooms as $room)
                    <option value="{{ $room }}" {{ old('classroom') == $room ? 'selected' : '' }}>
                        {{ $room }}
                    </option>
                @endforeach
            </select>
            @error('classroom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Data</label>
            <input type="date" name="date" required
                   value="{{ old('date') }}"
                   min="{{ date('Y-m-d') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Início</label>
                <input type="time" name="start_time" required
                       value="{{ old('start_time') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fim</label>
                <input type="time" name="end_time" required
                       value="{{ old('end_time') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Motivo (opcional)</label>
            <input type="text" name="purpose"
                   value="{{ old('purpose') }}"
                   placeholder="Ex: Aula de Laravel, Reunião de equipe..."
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Reservar
            </button>
            <a href="{{ route('reservations.index') }}"
               class="text-gray-600 px-4 py-2 rounded border hover:bg-gray-50">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection