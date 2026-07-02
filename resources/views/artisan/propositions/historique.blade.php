@extends('layouts.app')

@section('title', 'Historique des propositions')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2"></i>Historique des propositions
        </h2>
        <a href="{{ route('artisan.propositions.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-1"></i>Retour
        </a>
    </div>

    @if($propositions->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Investisseur</th>
                            <th>Montant</th>
                            <th>Durée</th>
                            <th>ROI</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($propositions as $proposition)
                            <tr>
                                <td>
                                    <strong>{{ $proposition->investisseur->name }}</strong>
                                </td>
                                <td>{{ number_format($proposition->montant, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $proposition->duree_mois }} mois</td>
                                <td><span class="text-success fw-bold">{{ $proposition->taux_roi }}%</span></td>
                                <td>
                                    @switch($proposition->statut)
                                        @case('acceptee')
                                            <span class="badge bg-success">Acceptée</span>
                                            @break
                                        @case('refusee')
                                            <span class="badge bg-danger">Refusée</span>
                                            @break
                                        @case('en_cours')
                                            <span class="badge bg-info">En cours</span>
                                            @break
                                        @case('terminee')
                                            <span class="badge bg-secondary">Terminée</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $proposition->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $propositions->links() }}</div>
    @else
        <div class="text-center py-5 bg-white rounded shadow-sm">
            <i class="bi bi-clock-history" style="font-size: 5rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucun historique</h4>
            <p class="text-muted">Vous n'avez pas encore traité de proposition.</p>
        </div>
    @endif
</div>
@endsection