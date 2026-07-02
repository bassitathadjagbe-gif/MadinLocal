<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2C3E50">
    <title>@yield('title', 'MadinLocal') — L'Artisanat Béninois</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- PWA Meta Tags -->
     <meta name="theme-color" content="#8B4513">
     <link rel="manifest" href="/manifest.json">
     <link rel="apple-touch-icon" href="/icons/icon-192.png">
     <meta name="apple-mobile-web-app-capable" content="yes">
     <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
     <meta name="apple-mobile-web-app-title" content="MadinLocal">
    <style>
        :root {
            --ivory: #FAF7F2;
            --ivory-dark: #F0EBE1;
            --indigo: #2C3E50;
            --indigo-light: #34495E;
            --terracotta: #A0522D;
            --terracotta-light: #C17A4F;
            --gold: #C9A961;
            --gold-light: #E0C484;
            --dark: #1A1A1A;
            --muted: #6B7280;
            --font-serif: 'Fraunces', serif;
            --font-sans: 'Inter', sans-serif;
        }
        .logo-img {
    max-height: 60px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
    margin-top: -25px;
}

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-sans);
            background-color: var(--ivory);
            color: var(--dark);
            overflow-x: hidden;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='0.9' numOctaves='2'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
        }

        h1, h2, h3, h4, .serif {
            font-family: var(--font-serif);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .text-terracotta { color: var(--terracotta) !important; }
        .text-gold { color: var(--gold) !important; }
        .text-indigo { color: var(--indigo) !important; }
        .bg-ivory { background-color: var(--ivory) !important; }
        .bg-indigo { background-color: var(--indigo) !important; }

        /* ============ NAVBAR ============ */
        .navbar-artisan {
            background: rgba(250, 247, 242, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(44, 62, 80, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1rem 0;
        }

        .navbar-artisan.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(44, 62, 80, 0.08);
        }

        .navbar-artisan .brand {
            font-family: var(--font-serif);
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--indigo);
            text-decoration: none;
            letter-spacing: -0.03em;
        }

        .navbar-artisan .brand span {
            color: var(--terracotta);
            position: relative;
        }

        .navbar-artisan .brand span::after {
            content: '';
            position: absolute;
            bottom: 2px; left: 0;
            width: 100%; height: 3px;
            background: var(--gold);
            border-radius: 2px;
        }

        .navbar-artisan .nav-link {
            color: var(--indigo) !important;
            font-weight: 500;
            padding: 0.5rem 1.25rem !important;
            position: relative;
            transition: color 0.3s;
        }

        .navbar-artisan .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 0; height: 2px;
            background: var(--terracotta);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-artisan .nav-link:hover::after,
        .navbar-artisan .nav-link.active::after {
            width: 60%;
        }

        .navbar-artisan .nav-link:hover {
            color: var(--terracotta) !important;
        }

        /* ============ BOUTONS ============ */
        .btn-artisan {
            background: var(--indigo);
            color: var(--ivory);
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-artisan::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            background: var(--gold);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
            z-index: 0;
        }

        .btn-artisan:hover::before {
            width: 400px; height: 400px;
        }

        .btn-artisan:hover {
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(201, 169, 97, 0.4);
        }

        .btn-artisan span, .btn-artisan i { position: relative; z-index: 1; }

        .btn-outline-artisan {
            background: transparent;
            color: var(--indigo);
            border: 2px solid var(--indigo);
            padding: 0.75rem 1.9rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-artisan:hover {
            background: var(--indigo);
            color: var(--ivory);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(44, 62, 80, 0.2);
        }

        .btn-gold {
            background: var(--gold);
            color: var(--dark);
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-gold:hover {
            background: var(--gold-light);
            color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(201, 169, 97, 0.4);
        }

        /* ============ FOOTER ============ */
        footer {
            background: var(--indigo);
            color: var(--ivory);
            padding: 4rem 0 1.5rem;
            margin-top: 6rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--terracotta), var(--gold), var(--terracotta));
        }

        footer a {
            color: var(--gold);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover { color: var(--gold-light); }

        footer h5 {
            font-family: var(--font-serif);
            margin-bottom: 1.25rem;
            color: white;
        }

        /* ============ ANIMATIONS ============ */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.9s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.9s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.9s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* ============ UTILITAIRES ============ */
        .section-subtitle {
            color: var(--terracotta);
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-size: 0.8rem;
            margin-bottom: 0.75rem;
            display: inline-block;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3.2rem);
            line-height: 1.1;
            margin-bottom: 1rem;
        }

        .divider-ornament {
            display: inline-block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--terracotta), var(--gold));
            border-radius: 2px;
            margin: 1rem 0;
        }

        /* Scrollbar custom */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--ivory); }
        ::-webkit-scrollbar-thumb {
            background: var(--terracotta);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--indigo); }

         .guest-logo-img {
        max-height: 50px; 
        width: auto;
    }
    </style>

    @stack('styles')

   
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-artisan fixed-top">
        <div class="container">
           <a href="{{ route('accueil') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
    <img src="{{ asset('images/logo.png') }}" alt="MadinLocal" class="guest-logo-img">
           </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list" style="font-size:1.75rem; color:var(--indigo);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/catalogue">Catalogue</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a> </li>
                    {{-- Icône du Panier (visible seulement pour les clients connectés) --}}
@if(auth()->check() && auth()->user()->role === 'client')
    <a href="{{ route('client.panier.index') }}" class="nav-link position-relative me-3">
        <i class="bi bi-cart3 fs-5"></i>
        
        {{-- Badge avec le nombre d'articles dans le panier --}}
        @php
            $nombreArticlesPanier = \App\Models\Panier::where('client_id', auth()->id())->sum('quantite');
        @endphp
        
        @if($nombreArticlesPanier > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" 
                  style="font-size: 0.6rem; padding: 0.2em 0.4em;">
                {{ $nombreArticlesPanier }}
            </span>
        @endif
    </a>
@endif                                                                    
                </ul>
                <div class="d-flex gap-2">
                    <a href="/login" class="btn btn-outline-artisan">Connexion</a>
                    <a href="/register" class="btn btn-artisan"><span>S'inscrire</span></a>
                </div>
            </div>
        </div>
    </nav>

    <main style="padding-top: 90px;">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-3">
                    <a href="{{ route('accueil') }}" class="brand">
    <img src="{{ asset('images/logo.png') }}" alt="MadinLocal" class="logo-img">
</a>
                    <p class="opacity-75 small">La plateforme qui valorise l'artisanat béninois et connecte artisans, clients et investisseurs dans un écosystème numérique unique.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" style="font-size:1.5rem;"><i class="bi bi-facebook"></i></a>
                        <a href="#" style="font-size:1.5rem;"><i class="bi bi-instagram"></i></a>
                        <a href="#" style="font-size:1.5rem;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" style="font-size:1.5rem;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Navigation</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="/">Accueil</a></li>
                        <li class="mb-2"><a href="/catalogue">Catalogue</a></li>
                        <li class="mb-2"><a href="/a-propos">À propos</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Légal</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="/mentions-legales">CGU</a></li>
                        <li class="mb-2"><a href="#">Confidentialité</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6>Newsletter</h6>
                    <p class="small opacity-75">Recevez les dernières nouveautés de l'artisanat local.</p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Votre email" style="border-radius:50px; border:none; padding:0.75rem 1.25rem;">
                        <button class="btn btn-gold" type="submit"><i class="bi bi-send"></i></button>
                    </form>
                </div>
            </div>
            <hr class="opacity-25 my-4">
            <p class="text-center small opacity-50 mb-0">© 2026 MadinLocal — Fait avec <i class="bi bi-heart-fill" style="color:var(--terracotta)"></i> au Bénin 🇧🇯</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.querySelector('.navbar-artisan').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Reveal on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));
        <!-- PWA Service Worker Registration -->
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }
    </script>
    @stack('scripts')
</body>
</html>
