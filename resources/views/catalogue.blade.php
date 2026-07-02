@extends('layouts.guest')

@section('title', 'Catalogue - MadinLocal')

@section('content')
<section class="catalogue-section py-5">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-grid-3x3-gap me-2"></i>Notre Catalogue
            </h1>
            <p class="lead text-muted">Découvrez les meilleurs produits et services de l'artisanat béninois</p>
        </div>

        <!-- Filtres et Recherche -->
        <div class="filter-bar mb-5">
            <form method="GET" action="{{ route('catalogue') }}" class="row g-3">
                <!-- Barre de recherche -->
                <div class="col-lg-4 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               placeholder="Rechercher un produit ou service..."
                               value="{{ $search }}">
                    </div>
                </div>

                <!-- Filtre catégorie -->
                <div class="col-lg-3 col-md-6">
                    <select class="form-select" name="category">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre type -->
                <div class="col-lg-2 col-md-6">
                    <select class="form-select" name="type">
                        <option value="">Tous les types</option>
                        <option value="produit" {{ $type == 'produit' ? 'selected' : '' }}>📦 Produits</option>
                        <option value="service" {{ $type == 'service' ? 'selected' : '' }}>💼 Services</option>
                    </select>
                </div>

                <!-- Tri -->
                <div class="col-lg-2 col-md-6">
                    <select class="form-select" name="sort">
                        <option value="recent" {{ $sortBy == 'recent' ? 'selected' : '' }}>Plus récents</option>
                        <option value="price_low" {{ $sortBy == 'price_low' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_high" {{ $sortBy == 'price_high' ? 'selected' : '' }}>Prix décroissant</option>
                        <option value="popular" {{ $sortBy == 'popular' ? 'selected' : '' }}>Populaires</option>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-madin px-4">
                        <i class="bi bi-funnel me-2"></i>Filtrer
                    </button>
                    <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Résultats -->
        @if($produits->count() > 0)
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <p class="text-muted mb-0">
                    <strong>{{ $produits->total() }}</strong> résultat(s) trouvé(s)
                </p>
                @if($search || $category || $type)
                    <span class="badge bg-secondary">
                        <i class="bi bi-funnel-fill me-1"></i>Filtres actifs
                    </span>
                @endif
            </div>

            <!-- Grille de produits -->
            <div class="row g-4">
                @foreach($produits as $produit)
                    <div class="col-lg-3 col-md-6">
                        <div class="produit-card h-100 {{ $produit->isService() ? 'service-card' : '' }}">
                            <!-- Image -->
                            <div class="produit-image-container">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" alt="{{ $produit->nom }}" class="produit-image">
                                @else
                                    <div class="produit-image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif

                                <!-- Badge type amélioré -->
                                <span class="produit-type-badge {{ $produit->isService() ? 'badge-service' : 'badge-produit' }}">
                                    <i class="bi {{ $produit->type_icon }} me-1"></i>
                                    {{ $produit->isProduit() ? 'Produit' : 'Service' }}
                                </span>
                            </div>

                            <!-- Contenu -->
                            <div class="produit-content">
                                <!-- Catégorie -->
                                <span class="produit-category">
                                    <i class="bi bi-tag"></i> {{ $produit->category->nom ?? 'Non catégorisé' }}
                                </span>

                                <!-- Titre -->
                                <h5 class="produit-title">
                                    <a href="{{ route('produit.show', $produit) }}" class="text-decoration-none">
                                        {{ $produit->nom }}
                                    </a>
                                </h5>

                                <!-- Description courte -->
                                <p class="produit-description">
                                    {{ Str::limit($produit->description, 80) }}
                                </p>

                                <!-- Prix et stock/rendez-vous -->
                                <div class="produit-footer">
                                    <div class="produit-price">
                                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                    </div>
                                    <div class="produit-stock">
                                        @if($produit->isService())
                                            <span class="badge-rdv">
                                                <i class="bi bi-calendar-check me-1"></i>Sur RDV
                                            </span>
                                        @elseif($produit->stock > 0)
                                            <span class="badge-stock">
                                                <i class="bi bi-box-seam me-1"></i>Stock: {{ $produit->stock }}
                                            </span>
                                        @else
                                            <span class="badge-rupture">
                                                <i class="bi bi-x-circle me-1"></i>Rupture
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Artisan -->
                                <div class="produit-artisan">
                                    <i class="bi bi-person-circle"></i>
                                    <span>{{ $produit->artisan->user->name ?? 'Artisan' }}</span>
                                    @if(isset($produit->artisan->is_verified) && $produit->artisan->is_verified)
                                        <i class="bi bi-patch-check-fill text-success" title="Artisan vérifié"></i>
                                    @endif
                                </div>

                                <!-- Bouton adapté au type -->
                                @if($produit->isService())
                                    <a href="{{ route('produit.show', $produit) }}" class="btn btn-service w-100 mt-2">
                                        <i class="bi bi-calendar-plus me-2"></i>Prendre rendez-vous
                                    </a>
                                @else
                                    <a href="{{ route('produit.show', $produit) }}" class="btn btn-madin w-100 mt-2">
                                        <i class="bi bi-eye me-2"></i>Voir le détail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $produits->links() }}
            </div>
        @else
            <!-- Aucun résultat -->
            <div class="empty-state text-center py-5">
                <i class="bi bi-search" style="font-size: 5rem; color: #ddd;"></i>
                <h4 class="mt-4 text-muted">Aucun résultat trouvé</h4>
                <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('catalogue') }}" class="btn btn-madin mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Voir tous les produits et services
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .catalogue-section {
        background: #fafafa;
        padding-top: 100px !important;
    }

    .filter-bar {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }

    .produit-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .produit-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(139, 69, 19, 0.15);
    }

    /* Carte spécifique pour les services */
    .service-card {
        border-left: 4px solid #3B82F6;
    }

    .produit-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .produit-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .produit-card:hover .produit-image {
        transform: scale(1.05);
    }

    .produit-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        color: #bbb;
        font-size: 4rem;
    }

    /* Badge type */
    .produit-type-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .badge-produit {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .badge-service {
        background: rgba(59, 130, 246, 0.95);
        color: white;
    }

    .produit-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .produit-category {
        display: inline-block;
        background: var(--light-bg);
        color: var(--primary-color);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        width: fit-content;
    }

    .produit-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 0.8rem;
        line-height: 1.3;
    }

    .produit-title a:hover {
        color: var(--secondary-color);
    }

    .produit-description {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.6;
        flex-grow: 1;
        margin-bottom: 1rem;
    }

    .produit-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .produit-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .produit-stock {
        font-size: 0.85rem;
    }

    /* Badges stock/rdv */
    .badge-stock {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-rdv {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-rupture {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .produit-artisan {
        color: #666;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-bottom: 0.5rem;
    }

    /* Bouton spécifique pour les services */
    .btn-service {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-service:hover {
        background: linear-gradient(135deg, #2563EB, #1D4ED8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
    }

    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 4rem;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }
</style>
@endpush