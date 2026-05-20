<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap');

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root {
            --bg-outer: #2da8d8;
            --bg-card: #3a5a8c;
            --input-bg: #ffffff;
            --input-border: #d0dce8;
            --input-focus: #2da8d8;
            --btn-bg: #2da8d8;
            --btn-hover: #1e90bf;
            --btn-text: #000000;
            --text-placeholder: #9aafbf;
            --radius-card: 18px;
            --radius-input: 50px;
            --radius-btn: 50px;
            --shadow-card: 0 12px 48px rgba(0,0,0,0.22);
            --shadow-btn: 0 4px 18px rgba(45,168,216,0.35);
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-outer);
            font-family: 'Nunito', sans-serif;
        }

        .login-card {
            background: var(--bg-card);
            border-radius: var(--radius-card);
            padding: 40px 40px 48px;
            width: 100%;
            max-width: 520px;
            box-shadow: var(--shadow-card);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            animation: fadeUp 0.55s cubic-bezier(.23,1.01,.32,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-wrapper {
            margin-bottom: 8px;
            animation: popIn 0.65s 0.15s cubic-bezier(.23,1.01,.32,1) both;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.7); }
            to   { opacity: 1; transform: scale(1); }
        }

        .logo-wrapper img {
            width: 130px;
            height: 130px;
            object-fit: contain;
            filter: drop-shadow(0 6px 18px rgba(0,0,0,0.28));
        }

        .input-group {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .input-field {
            width: 100%;
            padding: 16px 24px;
            border-radius: var(--radius-input);
            border: 2px solid transparent;
            background: var(--input-bg);
            font-family: 'Nunito', sans-serif;
            font-size: 1rem;
            color: #2c3e50;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .input-field::placeholder {
            color: var(--text-placeholder);
            font-weight: 600;
        }

        .input-field:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 4px rgba(45,168,216,0.18);
        }

        .btn-entrar {
            width: 100%;
            margin-top: 6px;
            padding: 17px 24px;
            border-radius: var(--radius-btn);
            border: none;
            background: var(--btn-bg);
            color: var(--btn-text);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 0.12em;
            cursor: pointer;
            box-shadow: var(--shadow-btn);
            transition: background 0.22s, transform 0.15s, box-shadow 0.22s;
        }

        .btn-entrar:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(30,144,191,0.45);
        }

        .btn-entrar:active {
            transform: translateY(0);
            box-shadow: var(--shadow-btn);
        }

        /* Error messages */
        .error-msg {
            color: #ff6b6b;
            font-size: 0.82rem;
            font-weight: 600;
            margin-top: -8px;
            padding-left: 16px;
            align-self: flex-start;
        }

        .alert-error {
            width: 100%;
            background: rgba(255,107,107,0.15);
            border: 1px solid rgba(255,107,107,0.4);
            border-radius: 10px;
            padding: 12px 18px;
            color: #ffb3b3;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 560px) {
            .login-card {
                margin: 16px;
                padding: 30px 24px 36px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- Logo --}}
    <div class="logo-wrapper">
        <img src= "https://img.magnific.com/vetores-gratis/pilha-de-design-plano-desenhado-a-mao-de-ilustracao-de-livros_23-2149341898.jpg?semt=ais_hybrid&w=740&q=80" alt="Logo">
    </div>

    {{-- Session errors --}}
    @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Login form --}}
    <div class="input-group">

        {{-- Login field --}}
        <input
            type="text"
            name="login"
            class="input-field"
            placeholder="Login"
            value="{{ old('login') }}"
            autocomplete="username"
            required
        >
        @error('login')
            <span class="error-msg">{{ $message }}</span>
        @enderror

        {{-- Password field --}}
        <input
            type="password"
            name="password"
            class="input-field"
            placeholder="Senha"
            autocomplete="current-password"
            required
        >
        @error('password')
            <span class="error-msg">{{ $message }}</span>
        @enderror

        {{-- Submit button --}}
        <button
            type="button"
            class="btn-entrar"
            onclick="submitLogin()"
        >
            ENTRAR
        </button>

    </div>
</div>

<script>
    function submitLogin() {
        const login    = document.querySelector('input[name="login"]').value.trim();
        const password = document.querySelector('input[name="password"]').value;

        if (!login || !password) {
            alert('Preencha login e senha.');
            return;
        }

        // Build and submit a real form with CSRF token
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("login") }}';

        const csrf = document.createElement('input');
        csrf.type  = 'hidden';
        csrf.name  = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        ['login', 'password'].forEach(field => {
            const el = document.createElement('input');
            el.type  = 'hidden';
            el.name  = field;
            el.value = document.querySelector(`input[name="${field}"]`).value;
            form.appendChild(el);
        });

        document.body.appendChild(form);
        form.submit();
    }

    // Allow Enter key to submit
    document.addEventListener('keydown', e => {
        if (e.key === 'Enter') submitLogin();
    });
</script>

</body>
</html>