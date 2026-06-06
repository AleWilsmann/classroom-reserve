{{-- resources/views/reservations/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Minhas Reservas</h1>
        <a href="{{ route('reservations.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nova Reserva
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <p class="text-gray-500">Você não tem reservas ativas.</p>
    @else
        <table class="w-full bg-white shadow rounded overflow-hidden">
            <thead class="bg-gray-100 text-gray-600 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">Sala</th>
                    <th class="px-4 py-3 text-left">Data</th>
                    <th class="px-4 py-3 text-left">Horário</th>
                    <th class="px-4 py-3 text-left">Motivo</th>
                    <th class="px-4 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($reservations as $r)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $r->classroom }}</td>
                    <td class="px-4 py-3">{{ $r->date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ substr($r->start_time, 0, 5) }} – {{ substr($r->end_time, 0, 5) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $r->purpose ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('reservations.cancel', $r) }}" method="POST"
                              onsubmit="return confirm('Cancelar esta reserva?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="text-red-600 hover:underline text-sm">
                                Cancelar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection