<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Educar Mais')</title>
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
            --navbar-h:    60px;
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
            min-height: 100vh;
        }

        /* ─── NAVBAR ──────────────────────────────────── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--navbar-h);
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 200;
            box-shadow: 0 2px 16px rgba(15,42,94,.25);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .navbar-brand {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
            text-decoration: none;
            margin-right: 8px;
        }

        .navbar-brand .brand-name {
            font-family: var(--font-display);
            font-size: .98rem;
            color: var(--white);
            white-space: nowrap;
        }

        .navbar-brand .brand-sub {
            font-size: .62rem;
            color: var(--sky);
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .navbar-divider {
            width: 1px;
            height: 28px;
            background: rgba(255,255,255,.15);
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 13px;
            border-radius: 8px;
            color: rgba(255,255,255,.65);
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .18s, color .18s;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.08);
            color: var(--white);
        }

        .nav-link.active {
            background: var(--blue-light);
            color: var(--white);
        }

        .nav-link svg {
            width: 15px; height: 15px;
            flex-shrink: 0;
            opacity: .85;
        }

        /* Dropdown para Salas de Aula */
        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 13px;
            border-radius: 8px;
            color: rgba(255,255,255,.65);
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s, color .18s;
            white-space: nowrap;
            user-select: none;
        }

        .nav-dropdown-toggle:hover,
        .nav-dropdown.open .nav-dropdown-toggle {
            background: rgba(255,255,255,.08);
            color: var(--white);
        }

        .nav-dropdown-toggle svg { width: 15px; height: 15px; opacity: .85; }

        .dropdown-arrow {
            width: 12px !important;
            height: 12px !important;
            transition: transform .22s;
            margin-left: 2px;
        }

        .nav-dropdown.open .dropdown-arrow {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: var(--navy-mid);
            border-radius: 10px;
            padding: 6px;
            min-width: 160px;
            box-shadow: 0 8px 24px rgba(15,42,94,.3);
            border: 1px solid rgba(255,255,255,.08);
        }

        .nav-dropdown.open .nav-dropdown-menu {
            display: block;
        }

        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 7px;
            color: rgba(255,255,255,.65);
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s, color .15s;
        }

        .nav-dropdown-item:hover {
            background: rgba(255,255,255,.08);
            color: var(--white);
        }

        .nav-dropdown-item svg { width: 13px; height: 13px; }

        /* ─── NAVBAR RIGHT ────────────────────────────── */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 12px 5px 6px;
            border-radius: 30px;
            background: rgba(255,255,255,.07);
            cursor: pointer;
            transition: background .18s;
        }

        .user-chip:hover { background: rgba(255,255,255,.12); }

        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--blue-light);
            display: flex; align-items: center; justify-content: center;
            font-size: .72rem;
            font-weight: 700;
            color: var(--white);
            flex-shrink: 0;
        }

        .user-info .user-name {
            font-size: .78rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
        }

        .user-info .user-role {
            font-size: .63rem;
            color: var(--sky);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 8px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.65);
            font-family: var(--font);
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s, color .18s;
        }

        .btn-logout:hover {
            background: rgba(255,80,80,.2);
            color: #ff9090;
            border-color: rgba(255,80,80,.3);
        }

        .btn-logout svg { width: 14px; height: 14px; }

        /* ─── PAGE WRAPPER ────────────────────────────── */
        .page-wrapper {
            padding-top: var(--navbar-h);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── TOPBAR (subtítulo por página) ───────────── */
        .topbar {
            background: var(--white);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(15,42,94,.06);
            box-shadow: var(--shadow-sm);
        }

        .topbar-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            color: var(--navy);
        }

        .topbar-sub {
            font-size: .76rem;
            color: var(--sky);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-btn {
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            background: var(--blue);
            color: var(--white);
            font-family: var(--font);
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s, transform .12s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-btn:hover {
            background: var(--blue-light);
            transform: translateY(-1px);
        }

        /* ─── CONTENT ─────────────────────────────────── */
        .content {
            padding: 28px 32px 40px;
            flex: 1;
        }

        /* ─── MOBILE MENU TOGGLE ──────────────────────── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            padding: 6px;
        }

        @media (max-width: 900px) {
            .navbar-nav { display: none; }
            .navbar-divider { display: none; }
            .mobile-toggle { display: flex; }

            .navbar-nav.mobile-open {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: var(--navbar-h);
                left: 0; right: 0;
                background: var(--navy);
                padding: 12px;
                gap: 4px;
                box-shadow: 0 8px 24px rgba(15,42,94,.3);
                border-top: 1px solid rgba(255,255,255,.08);
            }

            .nav-dropdown-menu {
                position: static;
                box-shadow: none;
                border: none;
                background: rgba(255,255,255,.04);
                margin-top: 4px;
            }

            .content { padding: 20px 16px 32px; }
        }
    </style>
    @yield('styles')
</head>
<body>

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar">
    <div class="navbar-left">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <span class="brand-name">Educar Mais</span>
            <span class="brand-sub">Sistema de Gestão</span>
        </a>

        <div class="navbar-divider"></div>

        <div class="navbar-nav" id="navbarNav">

            <a href="#" class="nav-link {{ request()->is('alunos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Alunos
            </a>

            <a href="#" class="nav-link {{ request()->is('equipe*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <path d="M2 10h20"/>
                </svg>
                Equipe Profissional
            </a>

            <a href="#" class="nav-link {{ request()->is('financeiro*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                Financeiro
            </a>

            <!-- Dropdown: Salas de Aula -->
            <div class="nav-dropdown {{ request()->is('rooms*') ? 'open' : '' }}" id="salasDropdown">
                <div class="nav-dropdown-toggle {{ request()->is('rooms*') ? 'active' : '' }}"
                     onclick="toggleDropdown('salasDropdown')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 6h18v12H3z"/>
                        <path d="M3 10h18"/>
                        <path d="M8 21h8M10 18v3M14 18v3"/>
                    </svg>
                    Salas de Aula
                    <svg class="dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('rooms.index') }}" class="nav-dropdown-item {{ request()->routeIs('rooms.index') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M3 9h18"/>
                        </svg>
                        Ver Salas
                    </a>
                    <a href="{{ route('rooms.create') }}" class="nav-dropdown-item {{ request()->routeIs('rooms.create') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Nova Sala
                    </a>
                </div>
            </div>

            <a href="{{ route('responsibles.index') }}" class="nav-link {{ request()->is('responsibles*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                Responsáveis
            </a>

            <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->is('reservations*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                Reservas
            </a>

        </div>
    </div>

    <div class="navbar-right">
        <div class="user-chip">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name ?? 'Usuário' }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="btn-logout">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Sair
            </button>
        </form>

        <!-- Mobile toggle -->
        <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menu">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="22" height="22">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
    </div>
</nav>

{{-- ═══ PAGE WRAPPER ═══ --}}
<div class="page-wrapper">

    @if(isset($topbarTitle))
    <header class="topbar">
        <div>
            <div class="topbar-title">{{ $topbarTitle }}</div>
            @if(isset($topbarSub))
                <div class="topbar-sub">{{ $topbarSub }}</div>
            @endif
        </div>
        <div class="topbar-right">
            @yield('topbar-actions')
        </div>
    </header>
    @endif

    <div class="content">
        @yield('content')
    </div>

</div>

<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        el.classList.toggle('open');
        // Fecha outros dropdowns
        document.querySelectorAll('.nav-dropdown').forEach(d => {
            if (d.id !== id) d.classList.remove('open');
        });
    }

    function toggleMobileMenu() {
        document.getElementById('navbarNav').classList.toggle('mobile-open');
    }

    // Fecha dropdown ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-dropdown')) {
            document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('open'));
        }
    });
</script>

@yield('scripts')
</body>
</html>