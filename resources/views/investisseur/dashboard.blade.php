@extends('layouts.app')

@section('title', 'Dashboard Investisseur')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace Investisseur</div>
        <a href="{{ route('investisseur.dashboard') }}" class="nav-link {{ request()->routeIs('investisseur.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('investisseur.opportunites') }}" class="nav-link {{ request()->routeIs('investisseur.opportunites') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>
            <span>Mes Opportunités</span>
            @if(isset($totalOpportunites) && $totalOpportunites > 0)
                <span class="badge-count">{{ $totalOpportunites }}</span>
            @endif
        </a>
        <a href="{{ route('investisseur.entreprise') }}" class="nav-link {{ request()->routeIs('investisseur.entreprise') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Mon Entreprise</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="topbar">
        <div>
            <h1 class="page-title">Tableau de bord Investisseur</h1>
            <p class="page-subtitle">Bienvenue, <strong>{{ auth()->user()->name }}</strong> 💼</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('investisseur.entreprise') }}" class="btn-artisan">
                <i class="bi bi-building"></i> Mon Entreprise
            </a>
        </div>
    </div>

    {{-- STATUT DU PROFIL INVESTISSEUR --}}
    @if($profilInvestisseur && $profilInvestisseur->is_approved)
        <div class="alert alert-success border-0 rounded-3 mb-4 d-flex align-items-center" style="background: #D1FAE5; color: #065F46;">
            <i class="bi bi-patch-check-fill me-3" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Votre profil investisseur est approuvé.</strong><br>
                <small>Entreprise : {{ $profilInvestisseur->entreprise }} • Budget : {{ number_format($profilInvestisseur->budget_min ?? 0, 0, ',', ' ') }} - {{ number_format($profilInvestisseur->budget_max ?? 0, 0, ',', ' ') }} FCFA</small>
            </div>
        </div>
    @elseif($profilInvestisseur)
        <div class="alert alert-warning border-0 rounded-3 mb-4 d-flex align-items-center" style="background: #FEF3C7; color: #92400E;">
            <i class="bi bi-hourglass-split me-3" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Votre profil est en attente d'approbation.</strong><br>
                <small>Un administrateur examinera votre demande sous peu. <a href="{{ route('investisseur.entreprise') }}" class="text-decoration-underline">Compléter mon profil →</a></small>
            </div>
        </div>
    @endif

    {{-- STATISTIQUES --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(44, 62, 80, 0.1); color: var(--indigo);">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <p class="stat-value">{{ $totalOpportunites ?? 0 }}</p>
                <p class="stat-label">Total opportunités</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(201, 169, 97, 0.2); color: var(--gold);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="stat-value">{{ $opportunitesEnAttente ?? 0 }}</p>
                <p class="stat-label">En attente</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <p class="stat-value">{{ $opportunitesAcceptees ?? 0 }}</p>
                <p class="stat-label">Acceptées</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <p class="stat-value">{{ number_format($montantTotalPropose ?? 0, 0, ',', ' ') }}</p>
                <p class="stat-label">Total proposé (FCFA)</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ARTISANS DISPONIBLES --}}
        <div class="col-lg-7">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-lightbulb me-2"></i>Artisans à soutenir
                    </h4>
                </div>

                @if(isset($artisansDisponibles) && $artisansDisponibles->count() > 0)
                    @foreach($artisansDisponibles as $artisan)
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                @if($artisan->user->avatar)
                                    <img src="{{ asset('storage/' . $artisan->user->avatar) }}" 
                                         alt="{{ $artisan->user->name }}"
                                         class="rounded-circle"
                                         style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--gold);">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--gold), var(--terracotta)); color: white; font-weight: 700; flex-shrink: 0;">
                                        {{ strtoupper(substr($artisan->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $artisan->user->name }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-tools me-1"></i>{{ $artisan->specialite ?? 'Artisan' }} 
                                        @if($artisan->ville) • <i class="bi bi-geo-alt me-1"></i>{{ $artisan->ville }} @endif
                                    </small>
                                </div>
                            </div>
                           <a href="{{ route('investisseur.propositions.create', $artisan->id) }}" 
   class="btn btn-sm btn-primary rounded-pill px-3">
    <i class="bi bi-hand-thumbs-up me-1"></i>Proposer
</a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle" style="font-size: 3rem; color: #10B981;"></i>
                        <p class="text-muted mt-2 mb-0">Vous avez déjà exploré tous les artisans disponibles !</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- MES DERNIÈRES PROPOSITIONS --}}
        <div class="col-lg-5">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-graph-up me-2"></i>Mes propositions
                    </h4>
                    <a href="{{ route('investisseur.opportunites') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($mesOpportunites) && $mesOpportunites->count() > 0)
                    @foreach($mesOpportunites as $opp)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between mb-1">
                                <strong style="font-size: 0.9rem;">{{ $opp->artisan_name ?? 'Artisan' }}</strong>
                                @if($opp->statut === 'en_attente')
                                    <span class="badge-status badge-warning">En attente</span>
                                @elseif($opp->statut === 'acceptee')
                                    <span class="badge-status badge-success">Acceptée</span>
                                @else
                                    <span class="badge-status badge-danger">Refusée</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between text-muted small">
                                <span><i class="bi bi-tools me-1"></i>{{ $opp->specialite ?? 'Artisanat' }}</span>
                                <span class="fw-bold" style="color: var(--terracotta);">
                                    {{ number_format($opp->montant_propose ?? 0, 0, ',', ' ') }} F
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-piggy-bank" style="font-size: 2.5rem; color: #ddd;"></i>
                        <p class="text-muted mt-2 mb-0 small">Vous n'avez pas encore fait de proposition</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection