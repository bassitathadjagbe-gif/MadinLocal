@extends('layouts.app')

@section('title', 'Commandes Reçues')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--primary-color);">
            <i class="bi bi-bag-check me-2"></i>Commandes Reçues
        </h2>
    </div>

    @if($commandes->count() > 0)
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Client</th>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $commande->client->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $commande->client->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $commande->produit->nom }}</strong>
                                    </td>
                                    <td>{{ $commande->quantite }}</td>
                                    <td>
                                        <strong style="color: var(--secondary-color);">
                                            {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $commande->statut_badge_class }} fs-6">
                                            {{ $commande->statut_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- Voir détails --}}
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailsModal{{ $commande->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- Changer statut --}}
                                            @if($commande->statut === 'en_attente')
                                                <form method="POST" action="{{ route('artisan.commandes.accepter', $commande) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Accepter">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                            @elseif($commande->statut === 'acceptee')
                                                <form method="POST" action="{{ route('artisan.commandes.terminer', $commande) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-info" title="Marquer comme terminée">
                                                        <i class="bi bi-check2-all"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal détails --}}
                                <div class="modal fade" id="detailsModal{{ $commande->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Détails de la commande #{{ $commande->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <strong>Client :</strong> {{ $commande->client->name }}
                                                    <br>
                                                    <small class="text-muted">{{ $commande->client->email }}</small>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Produit :</strong> {{ $commande->produit->nom }}
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Quantité :</strong> {{ $commande->quantite }}
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Total :</strong> 
                                                    <span style="color: var(--secondary-color);">
                                                        {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Statut :</strong> 
                                                    <span class="badge {{ $commande->statut_badge_class }}">
                                                        {{ $commande->statut_label }}
                                                    </span>
                                                </div>
                                                @if($commande->notes)
                                                    <div class="mb-3">
                                                        <strong>Notes du client :</strong>
                                                        <p class="mb-0">{{ $commande->notes }}</p>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-bag-x" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucune commande</h4>
            <p class="text-muted">Vous n'avez pas encore reçu de commandes</p>
        </div>
    @endif
</div>
@endsection