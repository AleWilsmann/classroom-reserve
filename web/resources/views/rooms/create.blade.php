<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Sala — Educar Mais</title>
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
            --font:        'Plus Jakarta Sans', sans-serif;
            --font-display:'Syne', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--navy);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--blue);
            text-decoration: none;
            font-size: .9rem;
            font-weight: 700;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .card {
            background: var(--white);
            border-radius: var(--card-radius);
            padding: 32px;
            box-shadow: var(--shadow-md);
        }

        .title {
            font-family: var(--font-display);
            font-size: 1.8rem;
            color: var(--navy);
            margin-bottom: 8px;
            font-weight: 800;
        }

        .subtitle {
            font-size: .9rem;
            color: var(--sky);
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: .9rem;
            color: var(--navy);
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(15, 42, 94, .15);
            border-radius: 8px;
            font-family: var(--font);
            font-size: .9rem;
            transition: border-color .18s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(45, 125, 232, .1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-list {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #7f1d1d;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: .85rem;
        }

        .error-list ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            font-family: var(--font);
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--blue);
            color: var(--white);
            flex: 1;
        }

        .btn-primary:hover {
            background: var(--blue-light);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--pale);
            color: var(--blue);
            border: 1px solid var(--sky);
        }

        .btn-secondary:hover {
            background: rgba(93, 168, 245, .1);
        }

        .help-text {
            font-size: .8rem;
            color: var(--sky);
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('rooms.index') }}" class="back-link">← Voltar para Salas</a>

        <div class="card">
            <h1 class="title">Nova Sala de Aula</h1>
            <p class="subtitle">Preencha os dados para cadastrar uma nova sala</p>

            @if ($errors->any())
                <div class="error-list">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('rooms.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nome da Sala *</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Ex: Sala 101"
                        required
                    />
                    <p class="help-text">Deve ser único no sistema</p>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacidade (pessoas) *</label>
                    <input
                        type="number"
                        id="capacity"
                        name="capacity"
                        value="{{ old('capacity', 30) }}"
                        min="1"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="location">Localização *</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Ex: Bloco A, 1º Andar"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="equipment">Equipamentos</label>
                    <input
                        type="text"
                        id="equipment"
                        name="equipment"
                        value="{{ old('equipment') ? implode(', ', old('equipment')) : '' }}"
                        placeholder="Ex: Projetor, Quadro branco, Ar-condicionado"
                    />
                    <p class="help-text">Separe os equipamentos por vírgula</p>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea
                        id="description"
                        name="description"
                        placeholder="Informações adicionais sobre a sala..."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Criar Sala</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
