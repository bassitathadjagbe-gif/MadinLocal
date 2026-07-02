@extends('layouts.app')

@section('title', 'Commande #' . $commande->id)

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour aux commandes
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Commande #{{ $commande->id }}</h3>
                <span class="badge {{ $commande->statut_badge_class }} fs-6">
                    {{ $commande->statut_label }}
                </span>
            </div>
        </div>
        <div class="card-body p-4">
            {{-- Informations générales --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Produit</h6>
                    <p class="fw-bold mb-0">{{ $commande->produit->nom }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Artisan</h6>
                    <p class="fw-bold mb-0">{{ $commande->artisan->user->name }}</p>
                </div>
                <div class="col-md-6 mt-3">
                    <h6 class="text-muted mb-2">Quantité</h6>
                    <p class="fw-bold mb-0">{{ $commande->quantite }}</p>
                </div>
                <div class="col-md-6 mt-3">
                    <h6 class="text-muted mb-2">Total</h6>
                    <p class="fw-bold mb-0" style="color: var(--secondary-color);">
                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                    </p>
                </div>
            </div>

            {{-- Notes du client --}}
            @if($commande->notes)
                <div class="mb-4">
                    <h6 class="text-muted mb-2">Notes</h6>
                    <p class="mb-0">{{ $commande->notes }}</p>
                </div>
            @endif

            {{-- Date de commande --}}
            <div class="mb-4">
                <h6 class="text-muted mb-2">Date de commande</h6>
                <p class="mb-0">{{ $commande->created_at->format('d/m/Y à H:i') }}</p>
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-2">
                <a href="{{ route('produit.show', $commande->produit) }}" class="btn btn-outline-primary">
                    <i class="bi bi-box-seam me-2"></i>Voir le produit
                </a>
                
                @if($commande->statut === 'acceptee')
                    <a href="{{ route('client.paiement.show', $commande) }}" class="btn btn-success">
                        <i class="bi bi-credit-card me-2"></i>Payer
                    </a>
                @endif
                
                @if($commande->statut === 'terminee' && !$commande->est_evaluee)
                    <a href="{{ route('evaluations.create', $commande) }}" class="btn btn-warning">
                        <i class="bi bi-star-fill me-2"></i>Évaluer
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection