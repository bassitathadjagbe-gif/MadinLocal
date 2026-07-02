@extends('layouts.app')

@section('title', 'Validation des Propositions')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-shield-check me-2"></i>Propositions en attente de validation
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($propositions->count() > 0)
        <div class="row">
            @foreach($propositions as $proposition)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            {{-- En-tête --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $proposition->investisseur->name }}</h5>
                                    <p class="text-muted mb-0 small">
                                        <i class="bi bi-building me-1"></i>{{ $proposition->investisseur->entreprise ?? 'Particulier' }}
                                    </p>
                                </div>
                                <span class="badge bg-warning text-dark">En attente</span>
                            </div>

                            <hr>

                            {{-- Artisan cible --}}
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2">Proposition à :</h6>
                                <div class="d-flex align-items-center p-2 bg-light rounded">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                        <span class="text-primary fw-bold">{{ substr($proposition->artisan->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <strong>{{ $proposition->artisan->user->name }}</strong>
                                        <p class="mb-0 small text-muted">
                                            <i class="bi bi-tools me-1"></i>{{ $proposition->artisan->specialite }}
                                            <span class="mx-1">•</span>
                                            <i class="bi bi-geo-alt me-1"></i>{{ $proposition->artisan->ville }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Détails financiers --}}
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">Montant</small>
                                        <strong class="text-primary">{{ number_format($proposition->montant, 0, ',', ' ') }} FCFA</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">Durée</small>
                                        <strong>{{ $proposition->duree_mois }} mois</strong>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <small class="text-muted d-block">ROI</small>
                                        <strong class="text-success">{{ $proposition->taux_roi }}%</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Message --}}
                            @if($proposition->message)
                                <div class="alert alert-light small mb-3">
                                    <strong>Message de l'investisseur :</strong><br>
                                    {{ $proposition->message }}
                                </div>
                            @endif

                            {{-- Actions --}}
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-sm flex-grow-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalValider{{ $proposition->id }}">
                                    <i class="bi bi-check-circle me-1"></i>Valider
                                </button>

                                <button type="button" class="btn btn-danger btn-sm flex-grow-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalRefuser{{ $proposition->id }}">
                                    <i class="bi bi-x-circle me-1"></i>Refuser
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Valider --}}
                    <div class="modal fade" id="modalValider{{ $proposition->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.propositions.valider', $proposition) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Valider la proposition</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-1"></i>
                                            En validant, cette proposition sera envoyée à l'artisan pour acceptation.
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Commentaire (optionnel)</label>
                                            <textarea name="commentaire" class="form-control" rows="3" placeholder="Votre commentaire..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-lg me-1"></i>Valider et envoyer à l'artisan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Refuser --}}
                    <div class="modal fade" id="modalRefuser{{ $proposition->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.propositions.refuser', $proposition) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Refuser la proposition</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Le motif de refus est obligatoire.
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Motif du refus *</label>
                                            <textarea name="motif_refus" class="form-control" rows="3" required placeholder="Expliquez pourquoi cette proposition est refusée..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-x-lg me-1"></i>Refuser
                                        </button>
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
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucune proposition en attente</h4>
            <p class="text-muted">Toutes les propositions ont été traitées.</p>
        </div>
    @endif
</div>
@endsection