@extends('layouts.app')

@section('title', 'Détails du produit')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--primary-color);">
                <i class="bi bi-box-seam me-2"></i>Détails du produit
            </h2>
            <p class="text-muted mb-0">{{ $produit->nom }}</p>
        </div>
        <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row g-4">
{{-- Image du produit --}}
<div class="col-lg-5">
    <div class="card shadow-sm border-0 rounded-4">
        @if($produit->image_principale)
            <img src="{{ $produit->image_principale }}" 
                 alt="{{ $produit->nom }}" 
                 class="img-fluid rounded-4" 
                 style="max-height: 400px; object-fit: cover; width: 100%;"
                 onerror="this.src='https://via.placeholder.com/600x400?text=Image+non+disponible'">
        @else
            <div class="d-flex align-items-center justify-content-center bg-light rounded-4" style="height: 400px;">
                <div class="text-center">
                    <i class="bi bi-image" style="font-size: 4rem; color: #ddd;"></i>
                    <p class="text-muted mt-2">Aucune image disponible</p>
                </div>
            </div>
        @endif
    </div>
</div>

        {{-- Informations --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3">{{ $produit->nom }}</h3>

                    {{-- Statut --}}
                    <div class="mb-3">
                        @if($produit->is_validated)
                            <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>Validé</span>
                        @elseif($produit->is_rejected)
                            <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>Rejeté</span>
                        @else
                            <span class="badge bg-warning fs-6"><i class="bi bi-hourglass-split me-1"></i>En attente</span>
                        @endif
                    </div>

                    {{-- Prix --}}
                    <div class="mb-3">
                        <strong class="text-muted">Prix :</strong>
                        <h4 class="fw-bold mb-0" style="color: var(--terracotta);">
                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                        </h4>
                    </div>

                    {{-- Catégorie --}}
                    <div class="mb-3">
                        <strong class="text-muted">Catégorie :</strong>
                        <p class="mb-0">{{ $produit->category->nom ?? 'Non définie' }}</p>
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <strong class="text-muted">Type :</strong>
                        <p class="mb-0">{{ ucfirst($produit->type) }}</p>
                    </div>

                    {{-- Stock --}}
                    <div class="mb-3">
                        <strong class="text-muted">Stock :</strong>
                        <p class="mb-0">{{ $produit->stock }} unités</p>
                    </div>

                    {{-- Artisan --}}
                    <div class="mb-3">
                        <strong class="text-muted">Artisan :</strong>
                        <p class="mb-0">
                            <i class="bi bi-person me-1"></i>{{ $produit->artisan->user->name ?? 'Inconnu' }}
                            @if($produit->artisan)
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-building me-1"></i>{{ $produit->artisan->nom_entreprise ?? 'N/A' }}
                                    @if($produit->artisan->ville)
                                        - <i class="bi bi-geo-alt me-1"></i>{{ $produit->artisan->ville }}
                                    @endif
                                </small>
                            @endif
                        </p>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <strong class="text-muted">Description :</strong>
                        <p class="mb-0">{{ $produit->description }}</p>
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <strong class="text-muted">Ajouté le :</strong>
                        <p class="mb-0">{{ $produit->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    {{-- Actions --}}
                    @if(!$produit->is_validated && !$produit->is_rejected)
                        <hr>
                        <div class="d-flex gap-2 flex-wrap">
                            <form method="POST" action="{{ route('admin.produits.validate', $produit) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    <i class="bi bi-check-circle me-2"></i>Valider
                                </button>
                            </form>

                            <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-2"></i>Rejeter
                            </button>
                        </div>

                        {{-- Modal de rejet --}}
                        <div class="modal fade" id="rejectModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.produits.reject', $produit) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rejeter le produit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Raison du rejet *</label>
                                                <textarea name="raison_rejet" class="form-control" rows="4" required placeholder="Expliquez pourquoi ce produit est rejeté..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection