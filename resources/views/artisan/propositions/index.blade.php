@extends('layouts.app')

@section('title', 'Propositions d\'investissement')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="bi bi-cash-stack me-2"></i>Propositions d'investissement
        </h2>
        <a href="{{ route('artisan.propositions.historique') }}" class="btn btn-outline-primary">
            <i class="bi bi-clock-history me-1"></i>Voir l'historique
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($propositions->count() > 0)
        <div class="row">
            @foreach($propositions as $proposition)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                        <span class="text-primary fw-bold">
                                            {{ substr($proposition->investisseur->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <strong>{{ $proposition->investisseur->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $proposition->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                <span class="badge bg-success">Validée par l'admin</span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            {{-- Détails financiers --}}
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">Montant</small>
                                        <strong class="text-primary fs-5">
                                            {{ number_format($proposition->montant, 0, ',', ' ') }} FCFA
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">Durée</small>
                                        <strong class="fs-5">{{ $proposition->duree_mois }} mois</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">ROI</small>
                                        <strong class="text-success fs-5">{{ $proposition->taux_roi }}%</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Remboursement total --}}
                            <div class="alert alert-light mb-3">
                                <small class="text-muted d-block">Montant total à rembourser :</small>
                                <strong class="fs-5 text-dark">
                                    {{ number_format($proposition->montant_remboursement, 0, ',', ' ') }} FCFA
                                </strong>
                                <small class="text-muted d-block">
                                    (soit {{ number_format($proposition->montant_remboursement / $proposition->duree_mois, 0, ',', ' ') }} FCFA/mois)
                                </small>
                            </div>

                            {{-- Message de l'investisseur --}}
                            @if($proposition->message)
                                <div class="border-start border-primary border-3 ps-3 mb-3">
                                    <small class="text-muted d-block">Message de l'investisseur :</small>
                                    <p class="mb-0 fst-italic">"{{ $proposition->message }}"</p>
                                </div>
                            @endif

                            {{-- Commentaire de l'admin --}}
                            @if($proposition->commentaire_admin)
                                <div class="border-start border-success border-3 ps-3">
                                    <small class="text-muted d-block">
                                        <i class="bi bi-shield-check me-1"></i>Note de l'admin :
                                    </small>
                                    <p class="mb-0 small">{{ $proposition->commentaire_admin }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            <div class="d-flex gap-2">
                                {{-- Bouton Accepter --}}
                                <form method="POST" action="{{ route('artisan.propositions.accepter', $proposition) }}" class="flex-grow-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success w-100" 
                                            onclick="return confirm('Acceptez-vous cette proposition ? Vous vous engagez à rembourser {{ number_format($proposition->montant_remboursement, 0, ',', ' ') }} FCFA sur {{ $proposition->duree_mois }} mois.')">
                                        <i class="bi bi-check-circle me-1"></i>Accepter
                                    </button>
                                </form>

                                {{-- Bouton Refuser --}}
                                <button type="button" class="btn btn-outline-danger flex-grow-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalRefuser{{ $proposition->id }}">
                                    <i class="bi bi-x-circle me-1"></i>Refuser
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Refuser --}}
                    <div class="modal fade" id="modalRefuser{{ $proposition->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('artisan.propositions.refuser', $proposition) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Refuser la proposition</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Vous êtes sur le point de refuser cette proposition.
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Motif du refus (optionnel)</label>
                                            <textarea name="motif_refus" class="form-control" rows="3" 
                                                      placeholder="Expliquez pourquoi vous refusez cette proposition..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger">Confirmer le refus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $propositions->links() }}
        </div>
    @else
        <div class="text-center py-5 bg-white rounded shadow-sm">
            <i class="bi bi-inbox" style="font-size: 5rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucune proposition en attente</h4>
            <p class="text-muted">
                Vous n'avez pas de proposition d'investissement à traiter pour le moment.<br>
                Les propositions validées par l'administrateur apparaîtront ici.
            </p>
            <a href="{{ route('artisan.dashboard') }}" class="btn btn-primary mt-2">
                <i class="bi bi-house me-1"></i>Retour au tableau de bord
            </a>
        </div>
    @endif
</div>
@endsection