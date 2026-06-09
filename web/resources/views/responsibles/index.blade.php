@extends('layouts.app')

@section('content')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Responsáveis — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0f2a5e;
            --navy-mid:    #1a3a7a;
            --blue:        #1e5fc2;
            --blue-light:  #2d7de8;
            --sky:         #5ba8f5;
            --pale:        #ddeeff;
            --white:       #ffffff;
            --bg:          #eef4fc;
            --sidebar-w:   240px;
            --card-radius: 16px;
            --shadow-sm:   0 2px 8px rgba(15,42,94,.08);
            --shadow-md:   0 6px 24px rgba(15,42,94,.13);
            --shadow-lg:   0 16px 48px rgba(15,42,94,.18);
            --font:        'Plus Jakarta Sans', sans-serif;
            --font-display:'Syne', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--navy);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .title {
            font-family: var(--font-display);
            font-size: 2rem;
            color: var(--navy);
            font-weight: 800;
        }

        .btn-primary {
            padding: 10px 24px;
            border-radius: 10px;
            border: none;
            background: var(--blue);
            color: var(--white);
            font-family: var(--font);
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s, transform .12s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: var(--blue-light);
            transform: translateY(-1px);
        }

        .btn-danger {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            background: #ef4444;
            color: var(--white);
            font-family: var(--font);
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid var(--blue);
            background: transparent;
            color: var(--blue);
            font-family: var(--font);
            font-size: .8rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: var(--pale);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: .9rem;
            font-weight: 600;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fecaca;
        }

        .table-container {
            background: var(--white);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--pale);
            padding: 16px;
            text-align: left;
            font-weight: 700;
            color: var(--navy);
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        td {
            padding: 16px;
            border-top: 1px solid rgba(15, 42, 94, .06);
            font-size: .9rem;
        }

        tr:hover {
            background: rgba(93, 168, 245, .05);
        }

        .responsible-name {
            font-weight: 700;
            color: var(--navy);
        }

        .email-badge {
            background: var(--pale);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: .8rem;
            display: inline-block;
            color: var(--blue);
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #cbd5e1;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            opacity: .5;
        }

        .empty-state p {
            font-size: .95rem;
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid var(--sky);
            color: var(--blue);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 600;
        }

        .pagination a:hover {
            background: var(--pale);
        }

        .pagination .active span {
            background: var(--blue);
            color: var(--white);
            border-color: var(--blue);
        }
    </style>

    <div class="container">
        <div class="header">
            <h1 class="title">Gerenciar Responsáveis</h1>
            <a href="{{ route('responsibles.create') }}" class="btn-primary">+ Novo Responsável</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-error">{{ $message }}</div>
        @endif

        @if($responsibles->count())
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Departamento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($responsibles as $responsible)
                            <tr>
                                <td><span class="responsible-name">{{ $responsible->name }}</span></td>
                                <td><span class="email-badge">{{ $responsible->email }}</span></td>
                                <td>{{ $responsible->phone ?? '-' }}</td>
                                <td>{{ $responsible->department ?? '-' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('responsibles.edit', $responsible) }}" class="btn-secondary">Editar</a>
                                        <form method="POST" action="{{ route('responsibles.destroy', $responsible) }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($responsibles->hasPages())
                <div class="pagination">
                    {{ $responsibles->links() }}
                </div>
            @endif
        @else
            <div class="table-container">
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <p>Nenhum responsável cadastrado.</p>
                    <a href="{{ route('responsibles.create') }}" class="btn-primary">Criar Primeiro Responsável</a>
                </div>
            </div>
        @endif
    </div>
@endsection
