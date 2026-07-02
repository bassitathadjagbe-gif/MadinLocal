<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>@yield('title', 'MadinLocal - Valorisons notre savoir-faire')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.png">
    
    <style>
        
        :root {
            --ivory: #FAF7F2;
            --ivory-dark: #F0EBE1;
            --indigo: #2C3E50;
            --terracotta: #A0522D;
            --gold: #C9A961;
            --dark: #1A1A1A;
            --muted: #6B7280;
            --font-serif: 'Fraunces', serif;
            --font-sans: 'Inter', sans-serif;
            --sidebar-width: 260px;
        }

        /* ===== LOGO ===== */
.brand {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 1.5rem 1.5rem;
    border-bottom: 1px solid rgba(44, 62, 80, 0.08);
    margin-bottom: 1rem;
    text-decoration: none;
}

.logo-img {
    max-height: 60px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.brand:hover .logo-img {
    transform: scale(1.05);
}

@media (max-width: 991px) {
    .logo-img {
        max-height: 50px;
    }
}

        * { box-sizing: border-box; }

       body {
    background: linear-gradient(135deg, #f5f0e8 0%, #e8e0d5 100%);
    /* OU background plus foncé */
    /* background: #f0ebe3; */
}

/* Dashboard background */
.dashboard-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
}

/* Cards avec plus de relief */
.card, .stat-card {
    background: white;
    box-shadow: 0 4px 15px rgba(139, 69, 19, 0.1);
    border: 1px solid rgba(139, 69, 19, 0.05);
}

.card:hover {
    box-shadow: 0 8px 25px rgba(139, 69, 19, 0.15);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

        h1, h2, h3, h4, h5, .serif {
            font-family: var(--font-serif);
            font-weight: 600;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            border-right: 1px solid rgba(44, 62, 80, 0.08);
            padding: 1.5rem 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar .brand {
            font-family: var(--font-serif);
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--indigo);
            text-decoration: none;
            padding: 0 1.5rem 1.5rem;
            display: block;
            border-bottom: 1px solid rgba(44, 62, 80, 0.08);
            margin-bottom: 1rem;
        }

        .sidebar .brand span { color: var(--terracotta); }

        .sidebar .user-card {
            margin: 0 1rem 1.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, var(--indigo), #3d566e);
            border-radius: 16px;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
            color: white;
        }

        .sidebar .user-card img {
            width: 45px; height: 45px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            object-fit: cover;
        }

        .sidebar .user-card .avatar-letter {
            width: 45px; height: 45px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            background: linear-gradient(135deg, var(--gold), var(--terracotta));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            flex-shrink: 0;
            color: white;
        }

        .sidebar .user-card .name {
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0;
        }

        .sidebar .user-card .role {
            font-size: 0.75rem;
            opacity: 0.75;
            margin: 0;
            text-transform: capitalize;
        }

        /* ===== NAVIGATION ===== */
        .sidebar .nav-section {
            padding: 0 1rem;
            margin-bottom: 0.5rem;
        }

        .sidebar .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 0.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--indigo);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            transition: all 0.25s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.15rem;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background: var(--ivory-dark);
            color: var(--terracotta);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--terracotta), #c0693a);
            color: white;
            box-shadow: 0 8px 20px rgba(160, 82, 45, 0.3);
        }

        .sidebar .nav-link .badge-count {
            margin-left: auto;
            background: var(--gold);
            color: var(--dark);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 10px;
        }

        .sidebar .nav-link.active .badge-count {
            background: white;
            color: var(--terracotta);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .topbar .page-title {
            font-size: 1.75rem;
            margin: 0;
            color: var(--indigo);
        }

        .topbar .page-subtitle {
            color: var(--muted);
            font-size: 0.9rem;
            margin: 0;
        }

        /* ===== CARTES ===== */
        .card-artisan {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-artisan:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(44, 62, 80, 0.1);
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100px; height: 100px;
            background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
            opacity: 0.1;
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card:hover { transform: translateY(-5px); }

        .stat-card .stat-icon {
            width: 50px; height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-family: var(--font-serif);
            font-size: 2rem;
            font-weight: 700;
            color: var(--indigo);
            margin: 0;
            line-height: 1;
        }

        .stat-card .stat-label {
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        /* ===== BOUTONS ===== */
        .btn-artisan {
            background: var(--indigo);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-artisan:hover {
            background: var(--terracotta);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(160, 82, 45, 0.3);
        }

        .btn-outline-artisan {
            background: transparent;
            color: var(--indigo);
            border: 2px solid var(--indigo);
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-artisan:hover {
            background: var(--indigo);
            color: white;
        }

        .badge-status {
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .badge-status::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .badge-success { background: #D1FAE5; color: #065F46; }
        .badge-warning { background: #FEF3C7; color: #92400E; }
        .badge-danger { background: #FEE2E2; color: #991B1B; }
        .badge-info { background: #DBEAFE; color: #1E40AF; }
        .badge-secondary { background: #E5E7EB; color: #374151; }

        .table-artisan {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
        }

        .table-artisan thead { background: var(--ivory-dark); }

        .table-artisan thead th {
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--indigo);
            padding: 1rem 1.25rem;
            border: none;
        }

        .table-artisan tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-color: rgba(44, 62, 80, 0.05);
        }

        .table-artisan tbody tr { transition: background 0.2s; }
        .table-artisan tbody tr:hover { background: var(--ivory); }

        /* ===== SIDEBAR BOTTOM ===== */
        .sidebar-bottom {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(44, 62, 80, 0.08);
        }

        .sidebar-legal-links {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .sidebar-legal-links a {
            font-size: 0.72rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .sidebar-legal-links a:hover {
            color: var(--terracotta);
            text-decoration: underline;
        }

        .sidebar-legal-links span {
            color: var(--muted);
            font-size: 0.72rem;
        }

        .sidebar-copyright {
            text-align: center;
            font-size: 0.7rem;
            color: var(--muted);
            margin-bottom: 0.75rem;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #991B1B;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .btn-logout:hover {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* ===== SIDEBAR TOGGLE (mobile) ===== */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 20px; right: 20px;
            width: 55px; height: 55px;
            border-radius: 50%;
            background: var(--indigo);
            color: white;
            border: none;
            box-shadow: 0 10px 30px rgba(44, 62, 80, 0.3);
            z-index: 1001;
            font-size: 1.5rem;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); box-shadow: 0 0 50px rgba(0,0,0,0.2); }
            .main-content { margin-left: 0; padding: 1rem; }
            .sidebar-toggle { display: flex; align-items: center; justify-content: center; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
<a href="{{ route('accueil') }}" class="brand">
    <img src="{{ asset('images/logo.png') }}" alt="MadinLocal" class="logo-img">
</a>

        @auth
            {{-- ===== UTILISATEUR CONNECTÉ ===== --}}
            <a href="
                @if(auth()->user()->role === 'client') {{ route('client.dashboard') }}
                @elseif(auth()->user()->role === 'artisan') {{ route('artisan.dashboard') }}
                @elseif(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
                @elseif(auth()->user()->role === 'investisseur') {{ route('investisseur.dashboard') }}
                @else {{ route('accueil') }}
                @endif
            " class="user-card" title="Cliquez pour aller à votre dashboard">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                @else
                    <div class="avatar-letter">
                        <i class="bi bi-person-fill" style="font-size: 1.3rem;"></i>
                    </div>
                @endif
                <div>
                    <p class="name">{{ auth()->user()->name }}</p>
                    <p class="role">{{ auth()->user()->role }}</p>
                </div>
            </a>

            <div class="nav-section">
                <div class="nav-section-title">Navigation</div>
                <a href="{{ route('accueil') }}" class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Accueil</span>
                </a>
            </div>

            @yield('sidebar-menu')

           <div class="nav-section">
    <div class="nav-section-title">Communication</div>
    <a href="{{ route('notifications.index') }}" class="nav-link position-relative">
    <i class="bi bi-bell fs-5"></i> <span>Notifications</span>
    @php
        $nbNotifications = \App\Models\Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();
    @endphp
    @if($nbNotifications > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
              style="font-size: 0.6rem; padding: 0.2em 0.4em;">
            {{ $nbNotifications }}
        </span>
    @endif
</a>
    <a href="{{ route('messages.index') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i>
        <span>Messages</span>
        @php
            $nbNonLus = \App\Models\Message::where('destinataire_id', auth()->id())->whereNull('lu_a')->count();
        @endphp
        @if($nbNonLus > 0)
            <span class="badge-count">{{ $nbNonLus }}</span>
        @endif
    </a>
</div>



            {{-- ===== SIDEBAR BOTTOM (Legal + Déconnexion) ===== --}}
            <div class="sidebar-bottom">
                <div class="sidebar-legal-links">
                    <a href="{{ route('conditions') }}">Conditions</a>
                    <span>•</span>
                    <a href="{{ route('confidentialite') }}">Confidentialité</a>
                </div>
                <p class="sidebar-copyright">
                    © {{ now()->year }} MadinLocal
                </p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.15rem; width: 20px; text-align: center;"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>

        @else
            

            <div class="nav-section">
                <div class="nav-section-title">Navigation</div>
                <a href="{{ route('accueil') }}" class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Accueil</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Mon Compte</div>
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Connexion</span>
                </a>
                <a href="{{ route('register') }}" class="nav-link" style="background: var(--terracotta); color: white;">
                    <i class="bi bi-person-plus"></i>
                    <span>Inscription</span>
                </a>
            </div>

            {{-- ===== SIDEBAR BOTTOM (Legal) ===== --}}
            <div class="sidebar-bottom">
                <div class="sidebar-legal-links">
                    <a href="{{ route('conditions') }}">Conditions</a>
                    <span>•</span>
                    <a href="{{ route('confidentialite') }}">Confidentialité</a>
                </div>
                <p class="sidebar-copyright">
                    © {{ now()->year }} MadinLocal
                </p>
            </div>
        @endauth
    </aside>

    <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
        <i class="bi bi-list"></i>
    </button>

    <!-- MAIN -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" style="background: #D1FAE5; color: #065F46;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" style="background: #FEE2E2; color: #991B1B;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>