@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        <a href="{{ route('client.dashboard') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('client.commandes.index') }}" class="nav-link">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        <a href="{{ route('client.favoris.index') }}" class="nav-link active">
            <i class="bi bi-heart"></i>
            <span>Mes Favoris</span>
        </a>
        <a href="{{ route('client.profil.edit') }}" class="nav-link">
            <i class="bi bi-person-circle"></i>
            <span>Mon Profil</span>
        </a>
    </div>
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Mes Favoris</h1>
        <p class="page-subtitle">Vos produits préférés</p>
    </div>
    <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
</div>

@if($favoris->count() > 0)
    <div class="row g-4">
        @foreach($favoris as $favori)
            @if($favori->produit)
                <div class="col-lg-4 col-md-6">
                    <div class="card-artisan position-relative">
                        <form method="POST" action="{{ route('client.favoris.toggle', $favori->produit) }}" class="position-absolute" style="top: 1rem; right: 1rem; z-index: 10;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm rounded-circle" style="width: 35px; height: 35px;" title="Retirer des favoris">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>

                        @if($favori->produit->image_principale)
                            <img src="{{ $favori->produit->image_principale }}" 
                                 alt="{{ $favori->produit->nom }}" 
                                 class="rounded-3 mb-3"
                                 style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                            <div class="rounded-3 mb-3 d-flex align-items-center justify-content-center" 
                                 style="width: 100%; height: 200px; background: var(--ivory-dark);">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ddd;"></i>
                            </div>
                        @endif

                        <h5 class="fw-bold mb-2">{{ $favori->produit->nom }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-person me-1"></i>{{ $favori->produit->artisan->user->name ?? 'Artisan' }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5 fw-bold" style="color: var(--terracotta);">
                                {{ number_format($favori->produit->prix, 0, ',', ' ') }} F
                            </span>
                            <a href="{{ route('produit.show', $favori->produit) }}" class="btn-artisan btn-sm">
                                Voir <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@else
    <div class="card-artisan text-center py-5">
        <i class="bi bi-heart" style="font-size: 5rem; color: #ddd;"></i>
        <h4 class="fw-bold mt-3 mb-2" style="color: var(--indigo);">Aucun favori pour le moment</h4>
        <p class="text-muted mb-4">Explorez notre catalogue et ajoutez des produits à vos favoris ❤️</p>
        <a href="{{ route('catalogue') }}" class="btn-artisan">
            <i class="bi bi-search me-2"></i>Explorer le catalogue
        </a>
    </div>
@endif
@endsection