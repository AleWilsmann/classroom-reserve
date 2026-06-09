@extends('layouts.app')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Reserva — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #eef4fc; color: #0f2a5e; }
        .container { max-width: 720px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 24px; padding: 32px; box-shadow: 0 18px 36px rgba(15,42,94,.1); }
        .title { font-family: 'Syne', sans-serif; font-size: 2rem; margin-bottom: 12px; }
        .meta { margin-bottom: 24px; color: #5b7f99; }
        .item { margin-bottom: 16px; }
        .label { display: block; font-weight: 700; margin-bottom: 6px; }
        .value { padding: 16px; border-radius: 16px; background: #f8fafc; border: 1px solid rgba(15,42,94,.08); }
        .badge { display: inline-block; padding: 8px 16px; border-radius: 999px; font-weight: 700; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .actions { margin-top: 28px; display: flex; gap: 10px; }
        .btn-secondary, .btn-primary { padding: 12px 20px; border-radius: 14px; text-decoration: none; font-weight: 700; }
        .btn-secondary { background: #fff; border: 1px solid #1e5fc2; color: #1e5fc2; }
        .btn-primary { background: #1e5fc2; color: #fff; }
    </style>
    <div class="container">
        <div class="card">
            <h1 class="title">Detalhes da Reserva</h1>
            <p class="meta">Informações completas da reserva e responsáveis.</p>

            <div class="item">
                <span class="label">Título</span>
                <div class="value">{{ $reservation->title }}</div>
            </div>

            <div class="item">
                <span class="label">Sala</span>
                <div class="value">{{ $reservation->room->name ?? '—' }} ({{ $reservation->room->location ?? 'Sem localização' }})</div>
            </div>

            <div class="item">
                <span class="label">Responsável</span>
                <div class="value">{{ $reservation->responsible->name ?? '—' }} — {{ $reservation->responsible->email ?? '—' }}</div>
            </div>

            <div class="item">
                <span class="label">Período</span>
                <div class="value">{{ $reservation->start_time->format('d/m/Y H:i') }} até {{ $reservation->end_time->format('d/m/Y H:i') }}</div>
            </div>

            <div class="item">
                <span class="label">Status</span>
                <div class="value">
                    <span class="badge badge-{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span>
                </div>
            </div>

            <div class="item">
                <span class="label">Descrição</span>
                <div class="value">{{ $reservation->description ?? 'Nenhuma descrição informada.' }}</div>
            </div>

            <div class="actions">
                <a href="{{ route('reservations.index') }}" class="btn-secondary">Voltar</a>
                <a href="{{ route('reservations.edit', $reservation) }}" class="btn-primary">Editar Reserva</a>
            </div>
        </div>
    </div>
@endsection