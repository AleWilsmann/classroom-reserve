<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Educar Mais</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap');
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy:#0f2a5e; --navy-mid:#1a3a7a; --blue:#1e5fc2; --blue-light:#2d7de8;
            --sky:#5ba8f5; --pale:#ddeeff; --white:#ffffff; --bg:#eef4fc;
            --sidebar-w:240px; --card-radius:16px;
            --shadow-sm:0 2px 8px rgba(15,42,94,.08); --shadow-md:0 6px 24px rgba(15,42,94,.13);
            --shadow-lg:0 16px 48px rgba(15,42,94,.18);
            --font:'Plus Jakarta Sans',sans-serif; --font-display:'Syne',sans-serif;
        }
        body { font-family:var(--font); background:var(--bg); color:var(--navy); display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-w); min-height:100vh; background:var(--navy); display:flex; flex-direction:column; position:fixed; top:0; left:0; z-index:100; padding:0 0 24px; box-shadow:4px 0 24px rgba(15,42,94,.22); }
        .sidebar-brand { padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,.08); margin-bottom:8px; }
        .sidebar-brand .brand-name { font-family:var(--font-display); font-size:1.05rem; color:var(--white); }
        .sidebar-brand .brand-sub { font-size:.7rem; color:var(--sky); letter-spacing:.06em; text-transform:uppercase; margin-top:2px; }
        .nav-section-label { font-size:.65rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:rgba(255,255,255,.35); padding:16px 24px 6px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:11px 20px 11px 24px; margin:2px 12px; border-radius:10px; color:rgba(255,255,255,.65); font-size:.88rem; font-weight:600; cursor:pointer; transition:background .18s,color .18s; text-decoration:none; }
        .nav-item:hover { background:rgba(255,255,255,.08); color:var(--white); }
        .nav-item.active { background:var(--blue-light); color:var(--white); }
        .nav-item svg { width:18px; height:18px; flex-shrink:0; opacity:.85; }
        .sidebar-footer { margin-top:auto; padding:16px 24px 0; border-top:1px solid rgba(255,255,255,.08); }
        .user-chip { display:flex; align-items:center; gap:10px; }
        .user-avatar { width:36px; height:36px; border-radius:50%; background:var(--blue-light); display:flex; align-items:center; justify-content:center; font-size:.8rem; font-weight:700; color:var(--white); flex-shrink:0; }
        .user-name { font-size:.82rem; font-weight:700; color:var(--white); }
        .user-role { font-size:.68rem; color:var(--sky); }
        .nav-accordion { cursor:pointer; user-select:none; }
        .accordion-menu { max-height:0; overflow:hidden; transition:max-height .3s ease; margin:0 12px; }
        .accordion-menu.open { max-height:200px; }
        .nav-sub-item { display:flex; align-items:center; gap:10px; padding:8px 16px 8px 36px; border-radius:8px; color:rgba(255,255,255,.5); font-size:.82rem; font-weight:600; text-decoration:none; transition:background .18s,color .18s; margin:1px 0; }
        .nav-sub-item:hover { background:rgba(255,255,255,.06); color:var(--white); }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar { background:var(--white); padding:16px 32px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid rgba(15,42,94,.06); box-shadow:var(--shadow-sm); position:sticky; top:0; z-index:50; }
        .topbar-title { font-family:var(--font-display); font-size:1.35rem; color:var(--navy); }
        .topbar-sub { font-size:.78rem; color:var(--sky); margin-top:1px; }
        .topbar-btn { padding:8px 18px; border-radius:8px; border:none; background:var(--blue); color:var(--white); font-family:var(--font); font-size:.82rem; font-weight:700; cursor:pointer; text-decoration:none; transition:background .18s,transform .12s; display:inline-flex; align-items:center; gap:6px; }
        .topbar-btn:hover { background:var(--blue-light); transform:translateY(-1px); }
        .content { padding:28px 32px 40px; display:flex; flex-direction:column; gap:28px; }

        /* STAT CARDS */
        .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; }
        .stat-card { background:var(--white); border-radius:var(--card-radius); padding:22px 22px 20px; box-shadow:var(--shadow-sm); position:relative; overflow:hidden; transition:transform .2s,box-shadow .2s; animation:slideUp .45s both; }
        .stat-card:nth-child(1){animation-delay:.05s} .stat-card:nth-child(2){animation-delay:.10s} .stat-card:nth-child(3){animation-delay:.15s} .stat-card:nth-child(4){animation-delay:.20s}
        @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .stat-card:hover { transform:translateY(-3px); box-shadow:var(--shadow-md); }
        .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:4px; background:var(--blue-light); }
        .stat-card.green::before{background:#22c55e} .stat-card.teal::before{background:#06b6d4} .stat-card.orange::before{background:#f97316}
        .stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px; }
        .stat-label { font-size:.72rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--sky); }
        .stat-icon { width:36px; height:36px; border-radius:8px; background:var(--pale); display:flex; align-items:center; justify-content:center; }
        .stat-icon svg { width:18px; height:18px; color:var(--blue); }
        .stat-value { font-family:var(--font-display); font-size:2rem; color:var(--navy); line-height:1; margin-bottom:4px; }
        .stat-meta { font-size:.72rem; color:#94a3b8; }

        /* PANELS */
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        .panel { background:var(--white); border-radius:var(--card-radius); padding:22px 24px; box-shadow:var(--shadow-sm); animation:slideUp .5s .25s both; }
        .panel-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
        .panel-title { font-size:.9rem; font-weight:800; color:var(--navy); display:flex; align-items:center; gap:8px; }
        .panel-title svg { width:16px; height:16px; color:var(--blue); }
        .panel-link { font-size:.75rem; font-weight:700; color:var(--blue-light); text-decoration:none; }
        .panel-link:hover { text-decoration:underline; }
        .empty-state { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:32px 0; color:#cbd5e1; gap:8px; }
        .empty-state svg { width:40px; height:40px; }
        .empty-state p { font-size:.82rem; font-weight:600; }

        /* RESERVATION LIST */
        .reservation-list { display:flex; flex-direction:column; gap:10px; }
        .reservation-item { display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:10px; background:var(--bg); transition:background .15s; }
        .reservation-item:hover { background:var(--pale); }
        .reservation-time { font-size:.75rem; font-weight:700; color:var(--blue); min-width:48px; text-align:center; background:var(--pale); padding:4px 8px; border-radius:6px; }
        .reservation-info { flex:1; min-width:0; }
        .reservation-title { font-size:.85rem; font-weight:700; color:var(--navy); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .reservation-meta { font-size:.72rem; color:#94a3b8; margin-top:2px; }
        .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:999px; font-weight:700; font-size:.7rem; white-space:nowrap; }
        .badge-ativa     { background:#dcfce7; color:#166534; }
        .badge-pendente  { background:#fef3c7; color:#92400e; }
        .badge-cancelada { background:#fee2e2; color:#991b1b; }

        /* QUICK ACTIONS */
        .quick-panel { background:linear-gradient(135deg,var(--navy) 0%,var(--blue) 100%); border-radius:var(--card-radius); padding:24px 28px; display:flex; align-items:center; justify-content:space-between; box-shadow:var(--shadow-lg); animation:slideUp .5s .35s both; position:relative; overflow:hidden; }
        .quick-title { font-family:var(--font-display); font-size:1.1rem; color:var(--white); margin-bottom:16px; }
        .quick-actions { display:flex; gap:12px; flex-wrap:wrap; }
        .quick-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; border:none; font-family:var(--font); font-size:.85rem; font-weight:700; cursor:pointer; text-decoration:none; transition:transform .15s,box-shadow .15s; }
        .quick-btn:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(0,0,0,.25); }
        .quick-btn.primary { background:var(--white); color:var(--navy); }
        .quick-btn.secondary { background:var(--blue-light); color:var(--white); }
        .quick-btn svg { width:16px; height:16px; }
        .quick-deco { opacity:.08; position:absolute; right:32px; font-family:var(--font-display); font-size:8rem; color:var(--white); pointer-events:none; user-select:none; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">Educar Mais</div>
        <div class="brand-sub">Sistema de Gestão</div>
    </div>
    <span class="nav-section-label">Menu</span>
    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Alunos
    </a>
    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        Equipe Profissional
    </a>
    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Financeiro
    </a>
    <div class="nav-item nav-accordion" onclick="toggleAccordion(this)">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18v12H3z"/><path d="M3 10h18M8 21h8M10 18v3M14 18v3"/></svg>
        Salas de Aula
        <svg class="accordion-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;width:14px;height:14px;transition:transform .25s;"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="accordion-menu">
        <a href="{{ route('rooms.index') }}" class="nav-sub-item">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/></svg>
            Ver Salas
        </a>
        <a href="{{ route('rooms.create') }}" class="nav-sub-item">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nova Sala
        </a>
    </div>
    <a href="{{ route('responsibles.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        Responsáveis
    </a>
    <a href="{{ route('reservations.index') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Reservas
    </a>
    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'Usuário' }}</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
    </div>
</aside>

<main class="main">
    <header class="topbar">
        <div>
            <div class="topbar-title">Educar Mais</div>
            <div class="topbar-sub">Visão geral — {{ now()->format('d/m/Y') }}</div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('reservations.create') }}" class="topbar-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nova Reserva
            </a>
        </div>
    </header>

    <div class="content">

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-label">Salas de Aula</div>
                    <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18v12H3z"/><path d="M3 10h18M8 21h8M10 18v3M14 18v3"/></svg></div>
                </div>
                <div class="stat-value">{{ $salasAula }}</div>
                <div class="stat-meta">Salas cadastradas</div>
            </div>
            <div class="stat-card green">
                <div class="stat-top">
                    <div class="stat-label">Responsáveis</div>
                    <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                </div>
                <div class="stat-value">{{ $totalResponsaveis }}</div>
                <div class="stat-meta">Responsáveis cadastrados</div>
            </div>
            <div class="stat-card teal">
                <div class="stat-top">
                    <div class="stat-label">Reservas Hoje</div>
                    <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                </div>
                <div class="stat-value">{{ $reservasHoje }}</div>
                <div class="stat-meta">Agendadas para hoje</div>
            </div>
            <div class="stat-card orange">
                <div class="stat-top">
                    <div class="stat-label">Pendentes</div>
                    <div class="stat-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                </div>
                <div class="stat-value">{{ $reservasPendentes }}</div>
                <div class="stat-meta">Reservas pendentes</div>
            </div>
        </div>

        <div class="two-col">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Próximas Reservas
                    </div>
                    <a href="{{ route('reservations.index') }}" class="panel-link">Ver todas</a>
                </div>
                @if($proximasReservas->count())
                    <div class="reservation-list">
                        @foreach($proximasReservas as $r)
                            <div class="reservation-item">
                                <div class="reservation-time">{{ $r->start_time->format('H:i') }}</div>
                                <div class="reservation-info">
                                    <div class="reservation-title">{{ $r->title }}</div>
                                    <div class="reservation-meta">{{ $r->room->name ?? '—' }} · {{ $r->start_time->format('d/m') }}</div>
                                </div>
                                <span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p>Nenhuma reserva futura</p>
                    </div>
                @endif
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Reservas de Hoje
                    </div>
                    <a href="{{ route('reservations.index') }}" class="panel-link">Ver todas</a>
                </div>
                @if($reservasHojeList->count())
                    <div class="reservation-list">
                        @foreach($reservasHojeList as $r)
                            <div class="reservation-item">
                                <div class="reservation-time">{{ $r->start_time->format('H:i') }}</div>
                                <div class="reservation-info">
                                    <div class="reservation-title">{{ $r->title }}</div>
                                    <div class="reservation-meta">{{ $r->room->name ?? '—' }} · {{ $r->responsible->name ?? '—' }}</div>
                                </div>
                                <span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <p>Nenhuma reserva para hoje</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="quick-panel">
            <div>
                <div class="quick-title">Ações Rápidas</div>
                <div class="quick-actions">
                    <a href="{{ route('reservations.create') }}" class="quick-btn primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nova Reserva
                    </a>
                    <a href="{{ route('rooms.create') }}" class="quick-btn secondary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Cadastrar Sala
                    </a>
                    <a href="{{ route('responsibles.create') }}" class="quick-btn secondary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Cadastrar Responsável
                    </a>
                    <a href="{{ route('rooms.index') }}" class="quick-btn secondary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18v12H3z"/><path d="M3 10h18M8 21h8M10 18v3M14 18v3"/></svg>
                        Ver Salas
                    </a>
                    <a href="{{ route('reservations.index') }}" class="quick-btn secondary">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Ver Reservas
                    </a>
                </div>
            </div>
            <span class="quick-deco">+</span>
        </div>

    </div>
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