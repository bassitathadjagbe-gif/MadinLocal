@extends('layouts.app')

@section('title', 'Mes Produits')

@section('content')
<section class="produits-section py-5">
    <div class="container">
       <!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h1 class="fw-bold" style="color: var(--primary-color);">
            <i class="bi bi-box-seam me-2"></i>Mes Produits
        </h1>
        <p class="text-muted mb-0">Gérez vos produits et services</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        {{-- ✅ Bouton Retour au Dashboard --}}
        <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        {{-- Bouton Ajouter un produit --}}
        <a href="{{ route('artisan.produits.create') }}" class="btn btn-madin btn-lg">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un produit
        </a>
    </div>
</div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Liste des produits -->
        @if($produits->count() > 0)
            <div class="row g-4">
                @foreach($produits as $produit)
                    <div class="col-lg-4 col-md-6">
                        <div class="produit-card">
                            <!-- Image -->
                            <div class="produit-image-container">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" alt="{{ $produit->nom }}" class="produit-image">
                                @else
                                    <div class="produit-image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="produit-badges">
                                    @if($produit->is_validated)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Validé
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split"></i> En attente
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Contenu -->
                            <div class="produit-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="produit-title mb-0">{{ $produit->nom }}</h5>
                                    <span class="produit-type-badge">
                                        {{ $produit->type === 'produit' ? '📦 Produit' : '🔧 Service' }}
                                    </span>
                                </div>

                                <p class="produit-category text-muted small mb-2">
                                    <i class="bi bi-tag"></i> {{ $produit->category->nom ?? 'Non catégorisé' }}
                                </p>

                                <p class="produit-description text-muted small mb-3">
                                    {{ Str::limit($produit->description, 100) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="produit-price">
                                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <span class="produit-stock text-muted small">
                                        @if($produit->type === 'service')
                                            <i class="bi bi-infinity"></i> Illimité
                                        @else
                                            Stock: {{ $produit->stock }}
                                        @endif
                                    </span>
                                </div>

                                <!-- Actions -->
                                <div class="produit-actions">
                                    <a href="{{ route('artisan.produits.edit', $produit) }}" class="btn btn-sm btn-outline-madin">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('artisan.produits.destroy', $produit) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $produits->links() }}
            </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 5rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">Aucun produit pour le moment</h4>
                <p class="text-muted">Commencez par ajouter votre premier produit !</p>
                <a href="{{ route('artisan.produits.create') }}" class="btn btn-madin btn-lg mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter mon premier produit
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .produits-section {
        background: #fafafa;
        padding-top: 100px !important;
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
        transform: translateY(-5px);
        box-shadow: 0 10px 35px rgba(139, 69, 19, 0.15);
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

    .produit-badges {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .produit-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .produit-title {
        color: var(--primary-color);
        font-weight: 600;
    }

    .produit-type-badge {
        background: var(--light-bg);
        color: var(--primary-color);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .produit-description {
        line-height: 1.6;
        flex-grow: 1;
    }

    .produit-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .produit-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }

    .produit-actions .btn {
        flex: 1;
    }

    .btn-outline-madin {
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-madin:hover {
        background: var(--secondary-color);
        color: white;
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }
</style>
@endpush