<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title', 'Pousada') — Sistema de Gerenciamento </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #1a2942;
            --sidebar-hover: #243656;
            --accent: #e8a838;
        }

        body {
            background: #f4f6f9;
            min-height: 100vh;
        }

        /*  
        Sidebar 
        */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }

        #sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        #sidebar .brand span {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.1rem;
        }

        #sidebar .brand small {
            color: rgba(255, 255, 255, .5);
            font-size: .72rem;
            display: block;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, .75);
            padding: .6rem 1.5rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .6rem;
            transition: background .2s, color .2s;
            font-size: .9rem;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: var(--sidebar-hover);
            color: #fff;
        }

        #sidebar .nav-link.active {
            border-left: 3px solid var(--accent);
        }

        #sidebar .nav-section {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(255, 255, 255, .35);
            padding: 1rem 1.5rem .3rem;
        }

        /*  
        Main
        */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #topbar {
            background: #fff;
            border-bottom: 1px solid #e3e6ea;
            padding: .7rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        #topbar .page-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /*  
        Cards / Tables  
        */
        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
            border-radius: 10px;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eaecef;
            border-radius: 10px 10px 0 0 !important;
        }

        .table th {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6b7280;
        }

        .badge-disponivel {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-ocupado {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-manutencao {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-pendente {
            background: #e0f2fe;
            color: #075985;
        }

        .badge-confirmada {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-cancelada {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-finalizada {
            background: #f3f4f6;
            color: #374151;
        }

        /*  
        Stat cards  
        */
        .stat-card {
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            color: #fff;
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            opacity: .85;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: .8rem;
            opacity: .85;
            margin-top: .25rem;
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ── Sidebar ─────────────────────────────────────────────── --}}
    <nav id="sidebar">
        <div class="brand">
            <span> <i class="bi bi-house-heart-fill me-1"></i> Pousada </span>
            <small> Sistema de Gerenciamento </small>
        </div>

        <div class="mt-2">
            <p class="nav-section"> Painel </p>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"> </i> Dashboard
            </a>

            <p class="nav-section mt-2"> Cadastros Básicos </p>
            <a class="nav-link {{ request()->routeIs('categorias-quarto.*') ? 'active' : '' }}"
                href="{{ route('categorias-quarto.index') }}">
                <i class="bi bi-tag"> </i> Categorias de Quarto
            </a>
            <a class="nav-link {{ request()->routeIs('hospedes.*') ? 'active' : '' }}"
                href="{{ route('hospedes.index') }}">
                <i class="bi bi-people"> </i> Hóspedes
            </a>
            <a class="nav-link {{ request()->routeIs('funcionarios.*') ? 'active' : '' }}"
                href="{{ route('funcionarios.index') }}">
                <i class="bi bi-person-badge"> </i> Funcionários
            </a>

            <p class="nav-section mt-2"> Operação </p>
            <a class="nav-link {{ request()->routeIs('quartos.*') ? 'active' : '' }}"
                href="{{ route('quartos.index') }}">
                <i class="bi bi-door-closed"> </i> Quartos
            </a>
            <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}"
                href="{{ route('reservas.index') }}">
                <i class="bi bi-calendar-check"> </i> Reservas
            </a>
        </div>

        <div class="mt-auto p-3 border-top border-secondary">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-box-arrow-left me-1"> </i> Sair
                </button>
            </form>
        </div>
    </nav>

    {{-- ── Main Content ────────────────────────────────────────── --}}
    <div id="main-content">
        {{-- Topbar --}}
        <div id="topbar">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="bi bi-list"> </i>
            </button>
            <h1 class="page-title"> @yield('page-title', 'Dashboard') </h1>
            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="text-muted small">
                    <i class="bi bi-person-circle me-1"> </i> {{ auth()->user()->name ?? '' }}
                </span>
            </div>
        </div>

        <div class="page-content">
            {{-- Alertas --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"> </button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"> </button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    @stack('scripts')
</body>

</html>