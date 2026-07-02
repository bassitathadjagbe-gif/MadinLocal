@extends('layouts.app')

@section('title', 'Commander ' . $produit->nom)

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h3 class="fw-bold" style="color: var(--primary-color);">
                            <i class="bi bi-cart-check me-2"></i>Passer commande
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Résumé du produit -->
                        <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-3">
                            @if($produit->image_principale)
                                <img src="{{ $produit->image_principale }}" style="width: 100px; height: 100px; object-fit: cover;" class="rounded">
                            @endif
                            <div>
                                <h5 class="mb-1">{{ $produit->nom }}</h5>
                                <p class="text-muted small mb-1">Vendu par {{ $produit->artisan->user->name }}</p>
                                <h6 class="fw-bold text-primary mb-0">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA / unité</h6>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('commande.store', $produit) }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Quantité</label>
                                <input type="number" name="quantite" class="form-control form-control-lg" 
                                       value="1" min="1" max="{{ $produit->stock }}" required>
                                <small class="text-muted">Stock disponible : {{ $produit->stock }}</small>
                            </div>

                            <div class="mb-3">
                              <label class="form-label fw-semibold">Message pour l'artisan (optionnel)</label>
                              <textarea name="message_client" class="form-control" rows="3" 
                                placeholder="Ex: Je le veux en bleu, livraison à Cotonou..."></textarea>
                           </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-madin btn-lg flex-grow-1">
                                    <i class="bi bi-check-circle me-2"></i>Confirmer la commande
                                </button>
                                <a href="{{ route('produit.show', $produit) }}" class="btn btn-outline-secondary btn-lg">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection