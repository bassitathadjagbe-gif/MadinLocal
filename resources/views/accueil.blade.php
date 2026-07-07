@extends('layouts.guest')

@section('title', 'Accueil - MadinLocal')

@section('content')
{{-- ===== HERO SECTION AVEC SLIDER ===== --}}
<section class="hero-slider">
    {{-- 📸 BACKGROUND IMAGES - ARTISANS AFRICAINS EN ACTION --}}
<div class="slider-background">
    {{-- 1. Couture - Tailleur africain --}}
    <div class="slide active" style="background-image: url('{{ asset('images/artisans/couture8.jpg') }}');"></div>
    
    {{-- 2. Poterie - Potière africaine --}}
    <div class="slide" style="background-image: url('{{ asset('images/artisans/poterie.jpg') }}');"></div>
    
    {{-- 3. Menuiserie - Menuisier africain --}}
    <div class="slide" style="background-image: url('{{ asset('images/artisans/menusierie.jpg') }}');"></div>
    
    {{-- 4. Coiffure - Coiffeuse africaine --}}
    <div class="slide" style="background-image: url('{{ asset('images/artisans/mode.jpg') }}');"></div>
    
    {{-- 5. Art et Décoration --}}
    <div class="slide" style="background-image: url('{{ asset('images/artisans/vanerie.jpg') }}');"></div>
    
    {{-- 6. Agroalimentaire --}}
    <div class="slide" style="background-image: url('{{ asset('images/artisans/bijoux.jpg') }}');"></div>
</div>
    {{-- FIN DES IMAGES DE BACKGROUND --}}
    
    {{-- Overlay --}}
    <div class="slider-overlay"></div>
    
    {{-- Contenu --}}
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-warning text-dark mb-4 px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-stars me-1"></i> Plateforme n°1 de l'artisanat local
                </span>
                <h1 class="display-3 fw-bold mb-4" style="line-height: 1.2; text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                    Découvrez l'Authenticité de <br><span class="text-warning">l'Artisanat Local</span>
                </h1>
                <p class="lead fs-4 mb-5" style="opacity: 0.95; text-shadow: 1px 1px 4px rgba(0,0,0,0.4);">
                    Plus de <strong>{{ $totalArtisans }}</strong> artisans talentueux vous présentent leurs créations uniques. 
                    Soutenez l'économie locale et offrez-vous des pièces d'exception.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('catalogue') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">
                        <i class="bi bi-bag-heart me-2"></i>Explorer le catalogue
                    </a>
                    
                    @auth
                        <a href="
                            @if(auth()->user()->role === 'client') {{ route('client.dashboard') }}
                            @elseif(auth()->user()->role === 'artisan') {{ route('artisan.dashboard') }}
                            @elseif(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
                            @elseif(auth()->user()->role === 'investisseur') {{ route('investisseur.dashboard') }}
                            @else #
                            @endif
                        " class="btn btn-outline-light btn-lg px-4 py-3 fw-bold d-flex align-items-center gap-2">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                     alt="Avatar" 
                                     class="rounded-circle"
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid white;">
                            @else
                                <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; font-weight: 700;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <span>{{ auth()->user()->name }}</span>
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                            <i class="bi bi-person-plus me-2"></i>Devenir artisan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    
    {{-- Indicators --}}
    <div class="slider-indicators">
        <span class="indicator active" data-slide="0"></span>
        <span class="indicator" data-slide="1"></span>
        <span class="indicator" data-slide="2"></span>
        <span class="indicator" data-slide="3"></span>
        <span class="indicator" data-slide="4"></span>
        <span class="indicator" data-slide="5"></span>
    </div>
</section>

{{-- ===== STATISTIQUES ===== --}}
<section class="bg-white" style="margin-top: -80px; padding-top: 100px; padding-bottom: 60px; position: relative; z-index: 10; border-radius: 40px 40px 0 0; box-shadow: 0 -10px 40px rgba(0,0,0,0.05);">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 stat-card bg-light">
                    <div class="stat-icon mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-1 counter" data-target="{{ $totalArtisans }}">0</h3>
                    <p class="text-muted mb-0 small">Artisans talentueux</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 stat-card bg-light">
                    <div class="stat-icon mx-auto mb-3 bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-1 counter" data-target="{{ $totalProduits }}">0</h3>
                    <p class="text-muted mb-0 small">Produits uniques</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 stat-card bg-light">
                    <div class="stat-icon mx-auto mb-3 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-1 counter" data-target="{{ $totalCommandes }}">0</h3>
                    <p class="text-muted mb-0 small">Commandes satisfaites</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 stat-card bg-light">
                    <div class="stat-icon mx-auto mb-3 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h3 class="fw-bold text-danger mb-1 counter" data-target="{{ $totalClients }}">0</h3>
                    <p class="text-muted mb-0 small">Clients satisfaits</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== PRODUITS VEDETTES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary text-white mb-2 px-3 py-2 rounded-pill">Sélection Premium</span>
            <h2 class="display-5 fw-bold" style="color: #8B4513;">Nos Produits Vedettes</h2>
            <p class="lead text-muted">Découvrez les dernières pépites de nos artisans</p>
        </div>

        @if($produitsVedettes->count() > 0)
            <div class="row g-4">
                @foreach($produitsVedettes as $produit)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 produit-card">
                            <div class="position-relative overflow-hidden rounded-top" style="height: 250px; background: #f8f9fa;">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" alt="{{ $produit->nom }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                        <i class="bi bi-image" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3">
                                    {{ $produit->category->nom ?? 'Artisanat' }}
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">{{ $produit->nom }}</h5>
                                <p class="text-muted small mb-3">{{ Str::limit($produit->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-5 fw-bold text-primary">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                    <a href="{{ route('produit.show', $produit) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        Voir <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('catalogue') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Voir tous les produits
                </a>
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted">Aucun produit disponible pour le moment.</p>
            </div>
        @endif
    </div>
</section>

{{-- ===== CATÉGORIES ===== --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" style="color: #8B4513;">Explorez par Univers</h2>
            <p class="lead text-muted">Trouvez exactement ce que vous cherchez</p>
        </div>

        @if($categories->count() > 0)
            <div class="row g-3">
                @foreach($categories as $categorie)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('catalogue', ['category' => $categorie->id]) }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 p-4 category-card h-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold mb-1" style="color: #8B4513;">{{ $categorie->nom }}</h5>
                                        <p class="text-muted mb-0 small">
                                            <i class="bi bi-box-seam me-1"></i>{{ $categorie->produits_count }} produit(s)
                                        </p>
                                    </div>
                                    <i class="bi bi-arrow-right-circle-fill fs-2 text-warning"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">Les catégories seront bientôt disponibles.</p>
            </div>
        @endif
    </div>
</section>

{{-- ===== ARTISANS POPULAIRES ===== --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" style="color: #8B4513;">Artisans Populaires</h2>
            <p class="lead text-muted">Les mieux notés par notre communauté</p>
        </div>

        @if($artisansPopulaires->count() > 0)
            <div class="row g-4">
                @foreach($artisansPopulaires as $artisan)
                    @php
                        $noteMoyenne = $artisan->evaluations()->avg('note') ?? 0;
                        $nbAvis = $artisan->evaluations()->count();
                    @endphp
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                            @if($artisan->user->avatar)
                                <img src="{{ asset('storage/' . $artisan->user->avatar) }}" 
                                     alt="{{ $artisan->user->name }}"
                                     class="rounded-circle mx-auto mb-3"
                                     style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--gold);">
                            @else
                                <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold; background: linear-gradient(135deg, var(--gold), var(--terracotta)); color: white;">
                                    {{ strtoupper(substr($artisan->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <h5 class="fw-bold mb-1">{{ $artisan->user->name }}</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-tools me-1"></i>{{ $artisan->specialite ?? 'Artisan' }}</p>
                            <div class="mb-2 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($noteMoyenne))
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                                <small class="text-muted d-block mt-1">({{ $nbAvis }} avis)</small>
                            </div>
                            <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $artisan->ville ?? 'Guadeloupe' }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">Les artisans populaires seront bientôt disponibles.</p>
            </div>
        @endif
    </div>
</section>

{{-- ===== CALL TO ACTION ===== --}}
<section class="py-5 text-white" style="background: linear-gradient(135deg, #D2691E 0%, #8B4513 100%);">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Rejoignez notre communauté d'artisans !</h2>
        <p class="lead mb-5 opacity-75">Vous êtes artisan ? Donnez de la visibilité à vos créations et développez votre activité.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            @auth
                <a href="
                    @if(auth()->user()->role === 'client') {{ route('client.dashboard') }}
                    @elseif(auth()->user()->role === 'artisan') {{ route('artisan.dashboard') }}
                    @elseif(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->role === 'investisseur') {{ route('investisseur.dashboard') }}
                    @else #
                    @endif
                " class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow d-flex align-items-center gap-2">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                             alt="Avatar" 
                             class="rounded-circle"
                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid white;">
                    @else
                        <div class="rounded-circle bg-white text-dark d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; font-weight: 700;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    @endif
                    <span>Mon Espace</span>
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">
                    <i class="bi bi-person-plus me-2"></i>Créer un compte artisan
                </a>
            @endauth
            <a href="{{ route('catalogue') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                <i class="bi bi-search me-2"></i>Explorer le catalogue
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    /* ===== HERO SLIDER ===== */
    .hero-slider {
        position: relative;
        min-height: 100vh;
        padding: 140px 0 150px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .slider-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1.5s ease-in-out;
    }

    .slide.active {
        opacity: 1;
        animation: zoomSlow 20s linear infinite;
    }

    @keyframes zoomSlow {
        from { transform: scale(1); }
        to { transform: scale(1.1); }
    }

    .slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(139, 69, 19, 0.4) 0%, rgba(210, 105, 30, 0.3) 100%);
        z-index: -1;
    }

    .slider-indicators {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background: #FFC107;
        width: 35px;
        border-radius: 6px;
    }

    .indicator:hover {
        background: rgba(255, 255, 255, 0.9);
    }

    /* Autres styles */
    .stat-card { transition: transform 0.3s ease; }
    .stat-card:hover { transform: translateY(-10px); }
    .produit-card { transition: all 0.3s ease; }
    .produit-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; }
    .produit-card img { transition: transform 0.5s ease; }
    .produit-card:hover img { transform: scale(1.05); }
    .category-card { transition: all 0.3s ease; border-left: 4px solid transparent; }
    .category-card:hover { border-left-color: #D2691E; transform: translateX(5px); }

    @media (max-width: 768px) {
        .hero-slider {
            min-height: 80vh;
            padding: 100px 0 120px 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Hero Slider
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        let currentSlide = 0;
        const interval = 5000;
        
        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            indicators[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');
        }
        
        function nextSlide() {
            const next = (currentSlide + 1) % slides.length;
            goToSlide(next);
        }
        
        let timer = setInterval(nextSlide, interval);
        
        indicators.forEach((ind, idx) => {
            ind.addEventListener('click', () => {
                clearInterval(timer);
                goToSlide(idx);
                timer = setInterval(nextSlide, interval);
            });
        });
        
        const heroSlider = document.querySelector('.hero-slider');
        heroSlider.addEventListener('mouseenter', () => clearInterval(timer));
        heroSlider.addEventListener('mouseleave', () => {
            timer = setInterval(nextSlide, interval);
        });
    });

    // Animation des compteurs
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(animateCounters, 20);
                } else {
                    counter.innerText = target;
                }
            });
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.stat-card');
        if (statsSection) observer.observe(statsSection.parentElement.parentElement);
    });
</script>
@endpush