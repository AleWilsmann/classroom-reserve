@extends('layouts.app')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #eef4fc; color: #0f2a5e; }
        .container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 24px; padding: 32px; box-shadow: 0 18px 36px rgba(15,42,94,.1); }
        .title { font-family: 'Syne', sans-serif; font-size: 2rem; margin-bottom: 8px; }
        .subtitle { color: #5b7f99; margin-bottom: 28px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-weight: 700; }
        input, select, textarea { width: 100%; padding: 14px 16px; border-radius: 14px; border: 1px solid rgba(15,42,94,.15); font-size: 1rem; outline: none; }
        input:focus, select:focus, textarea:focus { border-color: #1e5fc2; box-shadow: 0 0 0 5px rgba(45,125,232,.1); }
        textarea { min-height: 140px; resize: vertical; }
        .actions { display: flex; gap: 12px; margin-top: 22px; justify-content: flex-end; }
        .btn-primary { padding: 14px 26px; border-radius: 14px; border: none; background: #1e5fc2; color: #fff; font-weight: 700; cursor: pointer; }
        .btn-secondary { padding: 14px 26px; border-radius: 14px; border: 1px solid #1e5fc2; background: #fff; color: #1e5fc2; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .error-list { background: #fee2e2; color: #7f1d1d; border: 1px solid #fecaca; border-radius: 12px; padding: 16px; margin-bottom: 18px; }
    </style>

    <div class="container">
        <div class="card">
            <h1 class="title">Editar Reserva</h1>
            <p class="subtitle">Atualize os dados da reserva.</p>

            @if ($errors->any())
                <div class="error-list">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Título da Reserva *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $reservation->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="room_id">Sala *</label>
                    <select id="room_id" name="room_id" required>
                        <option value="">Selecione a sala</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }} — {{ $room->location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="responsible_id">Responsável *</label>
                    <select id="responsible_id" name="responsible_id" required>
                        <option value="">Selecione o responsável</option>
                        @foreach($responsibles as $responsible)
                            <option value="{{ $responsible->id }}" {{ old('responsible_id', $reservation->responsible_id) == $responsible->id ? 'selected' : '' }}>{{ $responsible->name }} — {{ $responsible->email }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_time">Início *</label>
                    <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time', $reservation->start_time->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="form-group">
                    <label for="end_time">Fim *</label>
                    <input type="datetime-local" id="end_time" name="end_time" value="{{ old('end_time', $reservation->end_time->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="pendente">Pendente</option>
                        <option value="ativa">Ativa</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea id="description" name="description">{{ old('description', $reservation->description) }}</textarea>
                </div>

                <div class="actions">
                    <a href="{{ route('reservations.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Atualizar Reserva</button>
                </div>
            </form>
        </div>
    </div>
@endsection
