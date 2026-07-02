@extends('layouts.app')

@section('title', 'Mes Opportunités')

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
            <h1 class="page-title">Mes Opportunités d'investissement</h1>
            <p class="page-subtitle">Historique de toutes vos propositions</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('investisseur.dashboard') }}" class="btn-outline-artisan">
                <i class="bi bi-arrow-left"></i> Retour au dashboard
            </a>
        </div>
    </div>

    @if($opportunites->count() > 0)
        <div class="card-artisan">
            <div class="table-responsive">
                <table class="table table-artisan mb-0">
                    <thead>
                        <tr>
                            <th>Artisan</th>
                            <th>Spécialité</th>
                            <th>Montant</th>
                            <th>Durée</th>
                            <th>ROI</th>
                            <th>Statut Admin</th>
                            <th>Statut Final</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($opportunites as $opp)
                            <tr>
                                <td>
                                    <strong>{{ $opp->artisan->user->name ?? 'Artisan' }}</strong>
                                </td>
                                <td>
                                    <small>{{ $opp->artisan->specialite ?? 'Artisanat' }}</small>
                                </td>
                                <td>
                                    <strong style="color: var(--terracotta);">
                                        {{ number_format($opp->montant, 0, ',', ' ') }} F
                                    </strong>
                                </td>
                                <td>{{ $opp->duree_mois }} mois</td>
                                <td>
                                    <span class="text-success fw-bold">{{ $opp->taux_roi }}%</span>
                                </td>
                                <td>
                                    @switch($opp->statut_admin)
                                        @case('en_attente')
                                            <span class="badge-status badge-warning">En attente</span>
                                            @break
                                        @case('validee')
                                            <span class="badge-status badge-success">Validée</span>
                                            @break
                                        @case('refusee')
                                            <span class="badge-status badge-danger">Refusée</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($opp->statut)
                                        @case('en_attente')
                                            <span class="badge-status badge-secondary">En attente</span>
                                            @break
                                        @case('acceptee')
                                            <span class="badge-status badge-success">Acceptée</span>
                                            @break
                                        @case('refusee')
                                            <span class="badge-status badge-danger">Refusée</span>
                                            @break
                                        @case('en_cours')
                                            <span class="badge-status badge-info">En cours</span>
                                            @break
                                        @case('terminee')
                                            <span class="badge-status badge-success">Terminée</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <small>{{ $opp->created_at->format('d/m/Y') }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $opportunites->links() }}
        </div>
    @else
        <div class="card-artisan text-center py-5">
            <i class="bi bi-piggy-bank" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucune opportunité</h4>
            <p class="text-muted">Vous n'avez pas encore fait de proposition d'investissement.</p>
            <a href="{{ route('investisseur.dashboard') }}" class="btn-artisan mt-2">
                <i class="bi bi-arrow-left"></i> Retour au dashboard
            </a>
        </div>
    @endif
@endsection