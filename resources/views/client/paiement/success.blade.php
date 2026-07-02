@extends('layouts.app')

@section('title', 'Paiement réussi')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    {{-- Animation de succès --}}
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" 
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                    </div>

                    <h2 class="fw-bold mb-3" style="color: #10B981;">Paiement réussi !</h2>
                    <p class="text-muted mb-4">
                        Votre paiement de <strong>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong> a été effectué avec succès.
                    </p>

                    {{-- Détails de la transaction --}}
                    <div class="bg-light rounded-3 p-4 mb-4 text-start">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-receipt me-2"></i>Reçu de transaction
                        </h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Référence</small>
                                <strong class="text-break">{{ $paiement->reference }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">N° Transaction</small>
                                <strong>{{ $paiement->numero_transaction }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Méthode</small>
                                <strong>{{ ucfirst(str_replace('_', ' ', $paiement->methode)) }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Date</small>
                                <strong>{{ now()->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Montant</small>
                                <strong style="color: var(--secondary-color);">
                                    {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                </strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Statut</small>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Confirmé
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info text-start">
                        <i class="bi bi-info-circle me-2"></i>
                        L'artisan a été notifié et va préparer votre commande. Vous recevrez une notification dès qu'elle sera expédiée.
                    </div>

                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('client.commandes.index') }}" class="btn btn-madin rounded-pill px-4">
                            <i class="bi bi-bag me-2"></i>Voir mes commandes
                        </a>
                        <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-house me-2"></i>Accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection