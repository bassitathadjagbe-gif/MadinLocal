@extends('layouts.app')

@section('title', 'Paiement échoué')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" 
                             style="width: 120px; height: 120px;">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 5rem;"></i>
                        </div>
                    </div>

                    <h2 class="fw-bold mb-3 text-danger">Paiement échoué</h2>
                    <p class="text-muted mb-4">
                        Votre paiement n'a pas pu être traité. Aucun montant n'a été débité.
                    </p>

                    <div class="bg-light rounded-3 p-4 mb-4 text-start">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Détails
                        </h6>
                        <p class="mb-2"><strong>Référence :</strong> {{ $paiement->reference }}</p>
                        <p class="mb-2"><strong>Montant :</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                        <p class="mb-0"><strong>Méthode :</strong> {{ ucfirst(str_replace('_', ' ', $paiement->methode)) }}</p>
                    </div>

                    <div class="alert alert-warning text-start">
                        <strong>Causes possibles :</strong>
                        <ul class="mb-0 mt-2">
                            <li>Numéro de téléphone incorrect</li>
                            <li>Solde insuffisant</li>
                            <li>Problème réseau avec l'opérateur</li>
                            <li>Transaction refusée par l'opérateur</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('client.paiement.show', $commande) }}" class="btn btn-madin rounded-pill px-4">
                            <i class="bi bi-arrow-repeat me-2"></i>Réessayer
                        </a>
                        <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-bag me-2"></i>Mes commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection