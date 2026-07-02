@extends('layouts.app')

@section('title', 'Paiement de la commande')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- En-tête sécurisé --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-10 text-success px-4 py-2 rounded-pill">
                    <i class="bi bi-shield-lock-fill fs-5"></i>
                    <strong>Paiement 100% sécurisé</strong>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Récapitulatif de la commande --}}
                <div class="card-header bg-gradient text-white p-4" style="background: linear-gradient(135deg, #2C3E50, #A0522D) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold">Finaliser votre commande</h4>
                            <p class="mb-0 opacity-75">Commande #{{ $commande->id }}</p>
                        </div>
                        <div class="text-end">
                            <small class="opacity-75 d-block">Montant à payer</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Détails du produit --}}
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            @php
                                $image = $commande->produit->image_principale ?? 'https://via.placeholder.com/80';
                            @endphp
                            <img src="{{ $image }}" alt="{{ $commande->produit->nom }}" 
                                 class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $commande->produit->nom }}</h6>
                                <p class="mb-1 text-muted small mb-0">
                                    <i class="bi bi-person me-1"></i>{{ $commande->artisan->user->name }}
                                </p>
                                <p class="mb-0 text-muted small">
                                    Quantité : <strong>{{ $commande->quantite }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('client.paiement.process', $commande) }}" id="paymentForm">
                        @csrf

                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-credit-card-2-front me-2"></i>Choisissez votre mode de paiement
                        </h5>

                        {{-- Méthodes de paiement --}}
                        <div class="row g-3 mb-4">
                            {{-- Mobile Money --}}
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="methode" id="methode_mobile" value="mobile_money" checked>
                                <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="methode_mobile">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-phone fs-2 text-primary"></i>
                                        <div>
                                            <strong class="d-block">Mobile Money</strong>
                                            <small class="text-muted">MTN, Moov, Celtiis</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- Carte Bancaire --}}
                            <div class="col-md-6">
                                <input type="radio" class="btn-check" name="methode" id="methode_carte" value="carte_bancaire">
                                <label class="btn btn-outline-primary w-100 p-3 text-start h-100" for="methode_carte">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-credit-card fs-2 text-primary"></i>
                                        <div>
                                            <strong class="d-block">Carte Bancaire</strong>
                                            <small class="text-muted">Visa, Mastercard</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- Paiement à la livraison --}}
                            <div class="col-12">
                                <input type="radio" class="btn-check" name="methode" id="methode_livraison" value="paiement_livraison">
                                <label class="btn btn-outline-primary w-100 p-3 text-start" for="methode_livraison">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-cash-stack fs-2 text-primary"></i>
                                        <div>
                                            <strong class="d-block">Paiement à la livraison</strong>
                                            <small class="text-muted">Payez en espèces à la réception</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Champs Mobile Money --}}
                        <div id="mobileMoneyFields">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Opérateur *</label>
                                <select name="operateur" class="form-select form-select-lg">
                                    <option value="MTN">🟡 MTN Mobile Money</option>
                                    <option value="Moov">🔵 Moov Money</option>
                                    <option value="Celtiis">🔴 Celtiis Cash</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Numéro de téléphone *</label>
                                <input type="tel" name="numero_telephone" class="form-control form-control-lg" 
                                       value="{{ old('numero_telephone', auth()->user()->telephone ?? '') }}"
                                       placeholder="+229 XX XX XX XX" required>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Un SMS de confirmation vous sera envoyé sur ce numéro
                                </small>
                            </div>
                        </div>

                        {{-- Champs Carte Bancaire (masqués par défaut) --}}
                        <div id="carteFields" style="display: none;">
                            <div class="alert alert-info">
                                <i class="bi bi-shield-check me-2"></i>
                                Vous serez redirigé vers notre partenaire bancaire sécurisé pour saisir vos informations.
                            </div>
                        </div>

                        {{-- Champs Paiement à la livraison --}}
                        <div id="livraisonFields" style="display: none;">
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle me-2"></i>
                                Vous paierez en espèces à la livraison. Prévoyez la monnaie.
                            </div>
                        </div>

                        {{-- Résumé des frais --}}
                        <div class="bg-light rounded-3 p-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Sous-total</span>
                                <strong>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Frais de transaction</span>
                                <strong class="text-success">Gratuit</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="fs-5">Total à payer</strong>
                                <strong class="fs-4" style="color: var(--secondary-color);">
                                    {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                </strong>
                            </div>
                        </div>

                        {{-- Bouton de paiement --}}
                        <button type="submit" class="btn btn-lg w-100 fw-bold text-white shadow-sm" 
                                style="background: linear-gradient(135deg, #10B981, #059669); padding: 1rem;">
                            <i class="bi bi-lock-fill me-2"></i>
                            Payer {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                        </button>

                        <p class="text-center text-muted small mt-3 mb-0">
                            <i class="bi bi-shield-lock me-1"></i>
                            Transaction sécurisée et cryptée
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Gestion de l'affichage des champs selon la méthode
    document.querySelectorAll('input[name="methode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('mobileMoneyFields').style.display = 'none';
            document.getElementById('carteFields').style.display = 'none';
            document.getElementById('livraisonFields').style.display = 'none';

            if (this.value === 'mobile_money') {
                document.getElementById('mobileMoneyFields').style.display = 'block';
            } else if (this.value === 'carte_bancaire') {
                document.getElementById('carteFields').style.display = 'block';
            } else if (this.value === 'paiement_livraison') {
                document.getElementById('livraisonFields').style.display = 'block';
            }
        });
    });
</script>
@endpush
@endsection