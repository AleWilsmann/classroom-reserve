<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Reforço Escolar</title>
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
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding: 0 0 24px;
            box-shadow: 4px 0 24px rgba(15,42,94,.22);
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 8px;
        }

        .sidebar-brand .brand-name {
            font-family: var(--font-display);
            font-size: 1.05rem;
            color: var(--white);
            line-height: 1.2;
        }

        .sidebar-brand .brand-sub {
            font-size: 0.7rem;
            color: var(--sky);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            padding: 16px 24px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px 11px 24px;
            margin: 2px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,.65);
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s, color .18s;
            text-decoration: none;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.08);
            color: var(--white);
        }

        .nav-item.active {
            background: var(--blue-light);
            color: var(--white);
            box-shadow: 0 4px 14px rgba(45,125,232,.45);
        }

        .nav-item svg {
            width: 18px; height: 18px;
            flex-shrink: 0;
            opacity: .85;
        }

        .nav-item.active svg { opacity: 1; }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 24px 0;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--blue-light);
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem;
            font-weight: 700;
            color: var(--white);
            flex-shrink: 0;
        }

        .user-name {
            font-size: .82rem;
            font-weight: 700;
            color: var(--white);
        }

        .user-role {
            font-size: .68rem;
            color: var(--sky);
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .04em;
            background: var(--sky);
            color: var(--navy);
            margin-left: 6px;
        }

        /* ─── MAIN ────────────────────────────────────── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── TOPBAR ──────────────────────────────────── */
        .topbar {
            background: var(--white);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(15,42,94,.06);
            box-shadow: var(--shadow-sm);
            position: sticky; top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            color: var(--navy);
        }

        .topbar-sub {
            font-size: .78rem;
            color: var(--sky);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
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
            transition: background .18s, transform .12s;
        }

        .topbar-btn:hover {
            background: var(--blue-light);
            transform: translateY(-1px);
        }

        /* ─── CONTENT ─────────────────────────────────── */
        .content {
            padding: 28px 32px 40px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* ─── STAT CARDS ──────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--card-radius);
            padding: 22px 22px 20px;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            animation: slideUp .45s both;
        }

        .stat-card:nth-child(1) { animation-delay: .05s; }
        .stat-card:nth-child(2) { animation-delay: .10s; }
        .stat-card:nth-child(3) { animation-delay: .15s; }
        .stat-card:nth-child(4) { animation-delay: .20s; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: var(--blue-light);
        }

        .stat-card.green::before  { background: #22c55e; }
        .stat-card.teal::before   { background: #06b6d4; }
        .stat-card.orange::before { background: #f97316; }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .stat-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--sky);
        }

        .stat-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--pale);
            display: flex; align-items: center; justify-content: center;
        }

        .stat-icon svg { width: 18px; height: 18px; color: var(--blue); }

        .stat-value {
            font-family: var(--font-display);
            font-size: 2rem;
            color: var(--navy);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-meta {
            font-size: .72rem;
            color: #94a3b8;
        }

        /* ─── TWO COLUMN ──────────────────────────────── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .panel {
            background: var(--white);
            border-radius: var(--card-radius);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            animation: slideUp .5s .25s both;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .panel-title {
            font-size: .9rem;
            font-weight: 800;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title svg { width: 16px; height: 16px; color: var(--blue); }

        .panel-link {
            font-size: .75rem;
            font-weight: 700;
            color: var(--blue-light);
            text-decoration: none;
        }

        .panel-link:hover { text-decoration: underline; }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 0;
            color: #cbd5e1;
            gap: 8px;
        }

        .empty-state svg { width: 40px; height: 40px; }
        .empty-state p { font-size: .82rem; font-weight: 600; }

        /* ─── QUICK ACTIONS ───────────────────────────── */
        .quick-panel {
            background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
            border-radius: var(--card-radius);
            padding: 24px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-lg);
            animation: slideUp .5s .35s both;
        }

        .quick-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            color: var(--white);
            margin-bottom: 16px;
        }

        .quick-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .quick-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-family: var(--font);
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }

        .quick-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.25); }

        .quick-btn.primary {
            background: var(--white);
            color: var(--navy);
        }

        .quick-btn.secondary {
            background: var(--blue-light);
            color: var(--white);
        }

        .quick-btn svg { width: 16px; height: 16px; }

        .quick-deco {
            opacity: .08;
            position: absolute;
            right: 32px;
            font-family: var(--font-display);
            font-size: 8rem;
            color: var(--white);
            pointer-events: none;
            user-select: none;
        }

        .quick-panel { position: relative; overflow: hidden; }


        /* ─── ACCORDION ───────────────────────────── */
        .nav-accordion { cursor: pointer; user-select: none; }

        .accordion-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .3s ease;
            margin: 0 12px;
        }

        .accordion-menu.open {
            max-height: 200px;
        }

        .nav-sub-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px 8px 36px;
            border-radius: 8px;
            color: rgba(255,255,255,.5);
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s, color .18s;
            margin: 1px 0;
        }

        .nav-sub-item:hover {
            background: rgba(255,255,255,.06);
            color: var(--white);
        }

        .nav-accordion.open .accordion-arrow {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>

{{-- ═══════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════ --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">Educar Mais</div>
        <div class="brand-sub">Sistema de Gestão</div>
    </div>

    <span class="nav-section-label">Menu</span>

  

    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Alunos
    </a>

    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="2" y="5" width="20" height="14" rx="2"/>
            <path d="M2 10h20"/>
        </svg>
        Equipe Profissional
    </a>

    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>
        Financeiro
    </a>

    <!-- Substitua o nav-item de Salas de Aula por este bloco -->
<div class="nav-item nav-accordion" onclick="toggleAccordion(this)">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
    </svg>
    Salas de Aula
    <svg class="accordion-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;width:14px;height:14px;transition:transform .25s;">
        <polyline points="6 9 12 15 18 9"/>
    </svg>
</div>
<div class="accordion-menu">
    <a href="#" class="nav-sub-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <path d="M3 9h18"/>
        </svg>
        Ver Salas
    </a>
    <a href="#" class="nav-sub-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;">
            <circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 3"/>
        </svg>
        Reservas
    </a>
    <a href="#" class="nav-sub-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Nova Sala
    </a>
</div>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar">LA</div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'Lucas Aragao' }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
    </div>
</aside>

{{-- ═══════════════════════════════════════
     MAIN
═══════════════════════════════════════ --}}
<main class="main">

    {{-- Topbar --}}
    <header class="topbar">
        <div>
            <div class="topbar-title">Educar Mais</div>
            <div class="topbar-sub">Visão geral</div>
        </div>
        <div class="topbar-right">
            <button class="topbar-btn">+ Novo Aluno</button>
        </div>
    </header>

    <div class="content">

        {{-- Stat Cards --}}
        <div class="stat-grid">

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-label">Alunos Ativos</div>
                    <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $totalAlunos ?? 0 }}</div>
                <div class="stat-meta">Total de alunos</div>
            </div>

            <div class="stat-card green">
                <div class="stat-top">
                    <div class="stat-label">Alunos designados</div>
                    <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                             <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-value">{{ $alunosDesignados ?? 0 }}</div>
                <div class="stat-meta">Alunos designados</div>
            </div>

            <div class="stat-card teal">
                <div class="stat-top">
                    <div class="stat-label">Salas de aula</div>
                    <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 6h18v12H3z"/>
                        <path d="M3 10h18"/>
                        <path d="M8 21h8"/>
                        <path d="M10 18v3"/>
                        <path d="M14 18v3"/>
                    </svg>
                    </div>
                </div>
                <div class="stat-value"> {{ $salasAula ?? 0  }}</div>
                <div class="stat-meta">Salas de aula</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-top">
                    <div class="stat-label">Pagamentos Pendentes</div>
                    <div class="stat-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v10"/>
                        <path d="M9.5 9.5C9.5 8.7 10.4 8 12 8s2.5.7 2.5 1.5S13.6 11 12 11s-2.5.7-2.5 1.5S10.4 14 12 14s2.5.7 2.5 1.5S13.6 17 12 17s-2.5-.7-2.5-1.5"/>
                    </svg>
                </div>
                </div>
                <div class="stat-value">{{ $pagamentosPendentes ?? 0 }}</div>
                <div class="stat-meta">Em aberto</div>
            </div>

        </div>

        {{-- Two column panels --}}
        <div class="two-col">

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>
                        </svg>
                        Pagamentos Recentes
                    </div>
                    <a href="#" class="panel-link">Ver todos</a>
                </div>

                @if(isset($pagamentosRecentes) && $pagamentosRecentes->count())
                    {{-- lista de pagamentos --}}
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        <p>Nenhum pagamento registrado</p>
                    </div>
                @endif
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Pagamentos Pendentes
                    </div>
                    <a href="#" class="panel-link">Ver todos</a>
                </div>

                @if(isset($listagemPendentes) && $listagemPendentes->count())
                    {{-- lista de pendentes --}}
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <p>Todos os pagamentos em dia!</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="quick-panel">
            <div>
                <div class="quick-title">Ações Rápidas</div>
                <div class="quick-actions">
                    <button class="quick-btn primary">
                        <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 6h18v12H3z"/>
                            <path d="M3 10h18"/>
                            <path d="M8 21h8"/>
                            <path d="M10 18v3"/>
                            <path d="M14 18v3"/>
                        </svg>
                        </div>
                        Reservar sala
                    </button>
                    <button class="quick-btn secondary">
                          <div class="stat-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 6h18v12H3z"/>
                            <path d="M3 10h18"/>
                            <path d="M8 21h8"/>
                            <path d="M10 18v3"/>
                            <path d="M14 18v3"/>
                        </svg>
                        </div>
                        Consultar reservas
                    </button>
                </div>
            </div>
            <span class="quick-deco">$</span>
        </div>

    </div>{{-- /content --}}
</main>

<script>
    function toggleAccordion(el) {
        const menu = el.nextElementSibling;
        const isOpen = menu.classList.contains('open');
        menu.classList.toggle('open', !isOpen);
        el.classList.toggle('open', !isOpen);
        el.classList.toggle('active', !isOpen);
    }
</script>
</body>
</html>