@extends('layouts.app')

@section('title', 'Mes Opportunités')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace Investisseur</div>
        <a href="{{ route('investisseur.dashboard') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('investisseur.opportunites') }}" class="nav-link active">
            <i class="bi bi-graph-up"></i>
            <span>Mes Opportunités</span>
        </a>
        <a href="{{ route('investisseur.entreprise') }}" class="nav-link">
            <i class="bi bi-building"></i>
            <span>Mon Entreprise</span>
        </a>
    </div>
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Mes Opportunités</h1>
        <p class="page-subtitle">Suivez toutes vos propositions d'investissement</p>
    </div>
    <a href="{{ route('investisseur.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
</div>

{{-- STATISTIQUES RAPIDES --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(201, 169, 97, 0.2); color: var(--gold);">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <p class="stat-value">{{ $mesOpportunites->where('statut', 'en_attente')->count() }}</p>
            <p class="stat-label">En attente</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                <i class="bi bi-check-circle"></i>
            </div>
            <p class="stat-value">{{ $mesOpportunites->where('statut', 'acceptee')->count() }}</p>
            <p class="stat-label">Acceptées</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
                <i class="bi bi-x-circle"></i>
            </div>
            <p class="stat-value">{{ $mesOpportunites->where('statut', 'refusee')->count() }}</p>
            <p class="stat-label">Refusées</p>
        </div>
    </div>
</div>

{{-- LISTE DES OPPORTUNITÉS --}}
<div class="card-artisan">
    <h4 class="serif fw-bold mb-4" style="color: var(--indigo);">
        <i class="bi bi-list-ul me-2"></i>Toutes mes propositions
    </h4>

    @if($mesOpportunites->count() > 0)
        <div class="table-responsive">
            <table class="table table-artisan mb-0">
                <thead>
                    <tr>
                        <th>Artisan</th>
                        <th>Spécialité</th>
                        <th>Type</th>
                        <th>Montant proposé</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesOpportunites as $opp)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 35px; height: 35px; background: linear-gradient(135deg, #C9A961, #A0522D); color: white; font-weight: 700; flex-shrink: 0; font-size: 0.9rem;">
                                        {{ strtoupper(substr($opp->artisan_name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $opp->artisan_name }}</strong>
                                </div>
                            </td>
                            <td>
                                <small>{{ $opp->specialite ?? 'Artisanat' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $opp->type }}</span>
                            </td>
                            <td>
                                <strong style="color: var(--terracotta);">
                                    {{ number_format($opp->montant_propose ?? 0, 0, ',', ' ') }} F
                                </strong>
                            </td>
                            <td>
                                @if($opp->statut === 'en_attente')
                                    <span class="badge-status badge-warning">En attente</span>
                                @elseif($opp->statut === 'acceptee')
                                    <span class="badge-status badge-success">Acceptée</span>
                                @else
                                    <span class="badge-status badge-danger">Refusée</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($opp->created_at)->format('d/m/Y') }}
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
            <p class="text-muted mt-3 mb-0">Vous n'avez pas encore fait de proposition d'investissement</p>
            <a href="{{ route('investisseur.dashboard') }}" class="btn btn-dark rounded-pill px-4 mt-3">
                <i class="bi bi-search me-2"></i>Découvrir des artisans
            </a>
        </div>
    @endif
</div>
@endsection