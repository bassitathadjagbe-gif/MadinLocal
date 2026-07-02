@extends('layouts.app')

@section('title', 'Mon Entreprise')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace Investisseur</div>
        <a href="{{ route('investisseur.dashboard') }}" class="nav-link {{ request()->routeIs('investisseur.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('investisseur.opportunites') }}" class="nav-link {{ request()->routeIs('investisseur.opportunites') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>
            <span>Mes Opportunités</span>
        </a>
        <a href="{{ route('investisseur.entreprise') }}" class="nav-link {{ request()->routeIs('investisseur.entreprise') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Mon Entreprise</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="topbar">
        <div>
            <h1 class="page-title">Mon Entreprise</h1>
            <p class="page-subtitle">Gérez votre profil investisseur</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('investisseur.dashboard') }}" class="btn-outline-artisan">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-artisan">
                <h4 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-building me-2"></i>Informations de l'entreprise
                </h4>

                <form method="POST" action="{{ route('investisseur.entreprise.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom de l'entreprise *</label>
                        <input type="text" name="entreprise" class="form-control" 
                               value="{{ $profilInvestisseur->entreprise ?? '' }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Budget minimum (FCFA) *</label>
                            <input type="number" name="budget_min" class="form-control" 
                                   value="{{ $profilInvestisseur->budget_min ?? '' }}" 
                                   required min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Budget maximum (FCFA) *</label>
                            <input type="number" name="budget_max" class="form-control" 
                                   value="{{ $profilInvestisseur->budget_max ?? '' }}" 
                                   required min="0">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Description (optionnel)</label>
                        <textarea name="description" class="form-control" rows="4" 
                                  placeholder="Décrivez votre entreprise, vos objectifs d'investissement...">{{ $profilInvestisseur->description ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="btn-artisan">
                        <i class="bi bi-check-circle me-1"></i>Enregistrer
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-3" style="color: var(--indigo);">
                    <i class="bi bi-info-circle me-2"></i>Statut du compte
                </h5>

                @if($profilInvestisseur && $profilInvestisseur->is_approved)
                    <div class="alert alert-success border-0 rounded-3 mb-0">
                        <i class="bi bi-patch-check-fill me-2 fs-4"></i>
                        <div>
                            <strong>Compte approuvé</strong>
                            <p class="mb-0 small mt-1">Vous pouvez investir librement.</p>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning border-0 rounded-3 mb-0">
                        <i class="bi bi-hourglass-split me-2 fs-4"></i>
                        <div>
                            <strong>En attente d'approbation</strong>
                            <p class="mb-0 small mt-1">Un administrateur examinera votre profil.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection