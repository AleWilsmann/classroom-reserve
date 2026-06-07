<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #eef4fc;
            color: #0f2a5e;
        }

        .container {
            max-width: 1200px;
            margin: 36px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .title {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            color: #0f2a5e;
        }

        .btn-primary {
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            background: #1e5fc2;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
        }

        .btn-primary:hover {
            background: #2d7de8;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        .table-wrap {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 42, 94, .08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 18px 16px;
            text-align: left;
            font-size: .95rem;
        }

        thead {
            background: #ddeeff;
        }

        th {
            color: #1e3a72;
            font-weight: 700;
            letter-spacing: .03em;
        }

        tbody tr {
            border-top: 1px solid rgba(15, 42, 94, .08);
        }

        tbody tr:hover {
            background: rgba(45, 125, 232, .06);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .78rem;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn-secondary {
            padding: 8px 14px;
            border-radius: 10px;
            border: 1px solid #1e5fc2;
            background: transparent;
            color: #1e5fc2;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-danger {
            padding: 8px 14px;
            border-radius: 10px;
            border: none;
            background: #ef4444;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .empty-state {
            padding: 48px 24px;
            text-align: center;
            color: #64748b;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 class="title">Reservas</h1>
                <p>Lista de reservas de sala vinculadas ao responsável.</p>
            </div>
            <a href="{{ route('reservations.create') }}" class="btn-primary">Nova Reserva</a>
        </div>

        <div
            style="background:#fff; border-radius:20px; box-shadow:0 10px 30px rgba(15,42,94,.08); padding:24px; margin-bottom:24px;">
            <p style="font-weight:700; color:#1e3a72; margin-bottom:16px;">🔍 Filtrar Reservas</p>
            <div style="display:flex; gap:16px; flex-wrap:wrap; align-items:flex-end;">

                <div style="display:flex; flex-direction:column; gap:6px; flex:1; min-width:200px;">
                    <label style="font-size:.85rem; font-weight:600; color:#1e3a72;">Por Sala</label>
                    <select onchange="if(this.value) window.location='/reservations/by-room/'+this.value"
                        style="padding:12px 16px; border-radius:12px; border:1.5px solid #ddeeff; font-family:inherit; font-size:.95rem; color:#0f2a5e; background:#f8fbff;">
                        <option value="">Selecione uma sala...</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ isset($selectedRoom) && $selectedRoom->id == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; flex-direction:column; gap:6px; flex:1; min-width:200px;">
                    <label style="font-size:.85rem; font-weight:600; color:#1e3a72;">Por Data</label>
                    <input type="date" value="{{ $date ?? '' }}" onblur="if(this.value) window.location='/reservations/by-date/'+this.value" style="padding:12px 16px; border-radius:12px; border:1.5px solid #ddeeff; font-family:inherit; font-size:.95rem; color:#0f2a5e; background:#f8fbff;">
                </div>

                <a href="/reservations"
                    style="padding:12px 24px; border-radius:12px; border:1.5px solid #1e5fc2; background:transparent; color:#1e5fc2; font-weight:700; text-decoration:none;">Limpar
                    filtros</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            @if($reservations->count())
                <table>
                    <thead>
                        <tr>
                            <th>Reserva</th>
                            <th>Sala</th>
                            <th>Responsável</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->title }}</td>
                                <td>{{ $reservation->room->name ?? '—' }}</td>
                                <td>{{ $reservation->responsible->name ?? '—' }}</td>
                                <td>{{ $reservation->start_time->format('d/m/Y H:i') }}</td>
                                <td>{{ $reservation->end_time->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span>
                                </td>
                                <td class="actions">
                                    <a href="{{ route('reservations.edit', $reservation) }}" class="btn-secondary">Editar</a>
                                    <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger"
                                            onclick="return confirm('Remover reserva?')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <p>Nenhuma reserva registrada ainda.</p>
                </div>
            @endif
        </div>

        <div style="margin-top: 18px;">{{ $reservations->links() }}</div>
    </div>
</body>

</html>