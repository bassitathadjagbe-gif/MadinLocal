@extends('layouts.app')

@section('title', 'Dashboard Client')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('client.commandes.index') }}" class="nav-link {{ request()->routeIs('client.commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        <a href="{{ route('client.favoris.index') }}" class="nav-link {{ request()->routeIs('client.favoris.*') ? 'active' : '' }}">
            <i class="bi bi-heart"></i>
            <span>Mes Favoris</span>
        </a>
        <a href="{{ route('client.profil.edit') }}" class="nav-link {{ request()->routeIs('client.profil.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Mon Profil</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="topbar">
        <div>
            <h1 class="page-title">Tableau de bord</h1>
            <p class="page-subtitle">Bienvenue, <strong>{{ auth()->user()->name }}</strong> 👋</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('catalogue') }}" class="btn-artisan">
                <i class="bi bi-bag-plus"></i> Nouvelle commande
            </a>
        </div>
    </div>

    {{-- STATISTIQUES --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(44, 62, 80, 0.1); color: var(--indigo);">
                    <i class="bi bi-bag"></i>
                </div>
                <p class="stat-value">{{ $totalCommandes ?? 0 }}</p>
                <p class="stat-label">Total commandes</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(201, 169, 97, 0.2); color: var(--gold);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="stat-value">{{ $commandesEnCours ?? 0 }}</p>
                <p class="stat-label">En cours</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <p class="stat-value">{{ $commandesTerminees ?? 0 }}</p>
                <p class="stat-label">Terminées</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <p class="stat-value">{{ $totalFavoris ?? 0 }}</p>
                <p class="stat-label">Favoris</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- COMMANDES RÉCENTES --}}
        <div class="col-lg-8">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-clock-history me-2"></i>Commandes récentes
                    </h4>
                    <a href="{{ route('client.commandes.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($commandesRecentes) && $commandesRecentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-artisan mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Artisan</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesRecentes as $commande)
                                    <tr>
                                        <td>
                                            <strong>{{ $commande->produit->nom ?? 'Produit supprimé' }}</strong>
                                            <br><small class="text-muted">Qté: {{ $commande->quantite }}</small>
                                        </td>
                                        <td>
                                            <small><i class="bi bi-person me-1"></i>{{ $commande->artisan->user->name ?? 'Artisan' }}</small>
                                        </td>
                                        <td>
                                            <strong style="color: var(--terracotta);">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</strong>
                                        </td>
                                        <td>
                                            @switch($commande->statut)
                                                @case('en_attente')
                                                    <span class="badge-status badge-warning">En attente</span>
                                                    @break
                                                @case('acceptee')
                                                    <span class="badge-status badge-info">Acceptée</span>
                                                    @break
                                                @case('en_cours')
                                                    <span class="badge-status badge-info">En cours</span>
                                                    @break
                                                @case('terminee')
                                                    <span class="badge-status badge-success">Terminée</span>
                                                    @break
                                                @case('refusee')
                                                    <span class="badge-status badge-danger">Refusée</span>
                                                    @break
                                                @default
                                                    <span class="badge-status badge-secondary">{{ $commande->statut }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-2 mb-0">Aucune commande pour le moment</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- FAVORIS RÉCENTS --}}
        <div class="col-lg-4">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-heart me-2"></i>Mes Favoris
                    </h4>
                    <a href="{{ route('client.favoris.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($favoris) && $favoris->count() > 0)
                    @foreach($favoris as $produit)
                        @if($produit)
                            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: var(--ivory-dark); border-radius: 12px;" class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">{{ Str::limit($produit->nom, 20) }}</h6>
                                    <small class="text-muted">{{ number_format($produit->prix, 0, ',', ' ') }} F</small>
                                </div>
                                <a href="{{ route('produit.show', $produit) }}" class="btn-outline-artisan" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                    Voir
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-heart" style="font-size: 2.5rem; color: #ddd;"></i>
                        <p class="text-muted mt-2 mb-3 small">Aucun favori</p>
                        <a href="{{ route('catalogue') }}" class="btn-outline-artisan btn-sm">
                            <i class="bi bi-search me-1"></i>Explorer
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection