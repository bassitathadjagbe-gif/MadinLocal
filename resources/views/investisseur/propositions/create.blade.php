@extends('layouts.app')

@section('title', 'Faire une proposition')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-hand-thumbs-up me-2"></i>Faire une proposition à {{ $artisan->user->name }}
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('investisseur.propositions.store') }}">
                        @csrf
                        <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">

                        {{-- Infos de l'artisan --}}
                        <div class="alert alert-light mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <span class="text-primary fw-bold">{{ substr($artisan->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <strong>{{ $artisan->user->name }}</strong>
                                    <p class="mb-0 small text-muted">
                                        <i class="bi bi-tools me-1"></i>{{ $artisan->specialite }}
                                        <span class="mx-1">•</span>
                                        <i class="bi bi-geo-alt me-1"></i>{{ $artisan->ville }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Formulaire --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Montant proposé (FCFA) *</label>
                            <input type="number" name="montant" class="form-control form-control-lg" 
                                   required min="10000" placeholder="Ex: 500000">
                            <small class="text-muted">Montant minimum : 10 000 FCFA</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Durée de remboursement *</label>
                            <select name="duree_mois" class="form-select form-select-lg" required>
                                <option value="">Choisir la durée...</option>
                                <option value="3">3 mois</option>
                                <option value="6">6 mois</option>
                                <option value="12">12 mois</option>
                                <option value="24">24 mois</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Taux de retour proposé (%) *</label>
                            <input type="number" name="taux_roi" class="form-control form-control-lg" 
                                   required min="5" max="30" step="0.5" placeholder="Ex: 15">
                            <small class="text-muted">
                                Ex: 15% = Pour 500 000 FCFA investis, l'artisan remboursera 575 000 FCFA
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Message à l'artisan (optionnel)</label>
                            <textarea name="message" class="form-control" rows="4" 
                                      placeholder="Présentez-vous et expliquez votre proposition..."></textarea>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('investisseur.dashboard') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                                <i class="bi bi-send me-2"></i>Envoyer la proposition
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection