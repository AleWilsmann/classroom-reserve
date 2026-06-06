<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #eef4fc; color: #0f2a5e; min-height: 100vh; padding: 40px 24px; }
        .container { max-width: 1000px; margin: 0 auto; }

        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
        .back-link { font-size: 13px; color: #5ba8f5; text-decoration: none; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }
        .page-title { font-family: 'Syne', sans-serif; font-size: 1.8rem; color: #0f2a5e; }
        .btn-new { padding: 12px 22px; border-radius: 14px; border: none; background: #1e5fc2; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block; transition: background .18s; }
        .btn-new:hover { background: #2d7de8; }

        .alert { border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; font-weight: 600; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error   { background: #fee2e2; color: #991b1b; }

        .card { background: #fff; border-radius: 20px; box-shadow: 0 6px 24px rgba(15,42,94,.1); overflow: hidden; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th { background: #ddeeff; color: #0f2a5e; font-size: 11px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; text-align: left; padding: 12px 16px; border-bottom: 1px solid #bfdbfe; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8faff; }
        td { padding: 12px 16px; color: #374151; }
        td.title { font-weight: 700; color: #0f2a5e; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        .action-link { font-size: 12px; font-weight: 600; text-decoration: none; margin-right: 10px; }
        .action-link.edit   { color: #64748b; }
        .action-link.view   { color: #1e5fc2; }
        .btn-cancel-inline { background: none; border: none; font-size: 12px; font-weight: 600; color: #dc2626; cursor: pointer; padding: 0; }

        .empty { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
        .empty svg { width: 44px; height: 44px; margin: 0 auto 10px; display: block; }
        .empty p { font-size: 14px; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">

    <div class="page-header">
        <div>
            <a href="{{ route('dashboard') }}" class="back-link">← Dashboard</a>
            <h1 class="page-title">Reservas de Salas</h1>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn-new">+ Nova Reserva</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->has('error'))
        <div class="alert alert-error">{{ $errors->first('error') }}</div>
    @endif

    <div class="card">
        @if($reservations->isEmpty())
            <div class="empty">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                <p>Nenhuma reserva encontrada</p>
            </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Sala</th>
                    <th>Responsável</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                <tr>
                    <td class="title">{{ $r->title }}</td>
                    <td>{{ $r->room->name ?? '—' }}</td>
                    <td>{{ $r->responsible->name ?? '—' }}</td>
                    <td>{{ $r->start_time->format('d/m/Y H:i') }}</td>
                    <td>{{ $r->end_time->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge badge-{{ $r->status }}">
                            {{ match($r->status) { 'pending' => 'Pendente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada', default => $r->status } }}
                        </span>
                    </td>
                    <td style="white-space:nowrap">
                        <a href="{{ route('reservations.show', $r) }}" class="action-link view">Ver</a>
                        <a href="{{ route('reservations.edit', $r) }}" class="action-link edit">Editar</a>
                        @if($r->status !== 'cancelled')
                            <form action="{{ route('reservations.cancel', $r) }}" method="POST" style="display:inline"
                                  onsubmit="return confirm('Cancelar esta reserva?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-cancel-inline">Cancelar</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
</body>
</html>