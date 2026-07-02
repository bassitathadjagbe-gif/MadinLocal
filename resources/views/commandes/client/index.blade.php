@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa;">
    <div class="container">
        {{-- Header avec boutons --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="fw-bold mb-0" style="color: var(--primary-color);">
                <i class="bi bi-bag me-2"></i>Mes Commandes & Rendez-vous
            </h2>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a href="{{ route('catalogue') }}" class="btn btn-outline-madin">
                    <i class="bi bi-grid me-2"></i>Voir le catalogue
                </a>
                <a href="{{ route('client.rendez_vous.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar3 me-2"></i>Mes Rendez-vous
                    @php
                        $nbRdvAttente = \App\Models\RendezVous::where('client_id', auth()->id())->where('statut', 'en_attente')->count();
                    @endphp
                    @if($nbRdvAttente > 0)
                        <span class="badge bg-danger ms-1">{{ $nbRdvAttente }}</span>
                    @endif
                </a>
            </div>
        </div>

        @if($commandes->count() > 0)
            <div class="row g-4">
                @foreach($commandes as $commande)
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 rounded-4 h-100 {{ $commande->produit->isService() ? 'border-start border-4 border-primary' : '' }}">
                            <div class="card-body">
                                {{-- En-tête avec badges --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge {{ $commande->statut_badge_class }} fs-6">
                                            {{ $commande->statut_label }}
                                        </span>
                                        
                                        {{-- Badge type --}}
                                        @if($commande->produit->isService())
                                            <span class="badge bg-info fs-6">
                                                <i class="bi bi-clock me-1"></i>Service
                                            </span>
                                        @else
                                            <span class="badge bg-success fs-6">
                                                <i class="bi bi-box-seam me-1"></i>Produit
                                            </span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $commande->created_at->format('d/m/Y') }}</small>
                                </div>
                                
                                {{-- Nom du produit/service --}}
                                <h5 class="fw-bold">
                                    @if($commande->produit->isService())
                                        <i class="bi bi-clock text-primary me-1"></i>
                                    @else
                                        <i class="bi bi-box-seam text-success me-1"></i>
                                    @endif
                                    {{ $commande->produit->nom }}
                                </h5>
                                
                                {{-- Artisan --}}
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-person"></i> {{ $commande->artisan->user->name }}
                                </p>
                                
                                {{-- Infos spécifiques au service (rendez-vous) --}}
                                @if($commande->produit->isService())
                                    @php
                                        $rdv = \App\Models\RendezVous::where('service_id', $commande->produit_id)
                                            ->where('client_id', auth()->id())
                                            ->first();
                                    @endphp
                                    
                                    @if($rdv)
                                        <div class="alert alert-info small mb-3">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <strong>RDV :</strong> {{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }} à {{ $rdv->heure_rdv }}
                                            <br>
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <strong>Lieu :</strong> {{ $rdv->lieu }}
                                            <span class="badge {{ $rdv->statut_badge_class }} ms-2">{{ $rdv->statut_label }}</span>
                                        </div>
                                    @endif
                                @endif
                                
                                {{-- Montant et quantité --}}
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <div>
                                        @if($commande->produit->isProduit())
                                            <small class="text-muted">Quantité: {{ $commande->quantite }}</small>
                                        @else
                                            <small class="text-muted">
                                                @if($commande->produit->duree_minutes)
                                                    <i class="bi bi-clock me-1"></i>{{ $commande->produit->duree_minutes }} min
                                                @endif
                                            </small>
                                        @endif
                                        <h5 class="fw-bold text-primary mb-0">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</h5>
                                    </div>
                                    
                                    <div class="d-flex gap-2 flex-wrap">
                                        {{-- Bouton Voir --}}
                                        <a href="{{ route('produit.show', $commande->produit) }}" class="btn btn-sm btn-outline-madin">
                                            <i class="bi bi-eye me-1"></i>Voir
                                        </a>

                                        {{-- BOUTON PAYER (pour produits uniquement) --}}
                                        @if($commande->produit->isProduit())
                                            @if($commande->statut === 'acceptee')
                                                <a href="{{ route('client.paiement.show', $commande) }}" class="btn btn-sm btn-success">
                                                    <i class="bi bi-credit-card me-1"></i>Payer
                                                </a>
                                            @elseif($commande->statut === 'payee')
                                                <span class="btn btn-sm btn-success disabled">
                                                    <i class="bi bi-check-circle me-1"></i>Payée
                                                </span>
                                            @endif
                                        @else
                                            {{-- Pour les services : bouton détails RDV --}}
                                            @if(isset($rdv))
                                                <a href="{{ route('client.rendez_vous.index') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-calendar-check me-1"></i>Détails RDV
                                                </a>
                                            @endif
                                        @endif
                                        
                                        {{-- Bouton Évaluer --}}
                                        @if($commande->statut === 'terminee' && !$commande->est_evaluee)
                                            <a href="{{ route('evaluations.create', $commande) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-star-fill me-1"></i>Évaluer
                                            </a>
                                        @elseif(isset($commande->est_evaluee) && $commande->est_evaluee)
                                            <span class="btn btn-sm btn-success disabled">
                                                <i class="bi bi-check-circle me-1"></i>Évalué
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $commandes->links() }}</div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-bag-x" style="font-size: 4rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">Aucune commande pour le moment</h4>
                <p class="text-muted">Vous n'avez pas encore passé de commande</p>
                <a href="{{ route('catalogue') }}" class="btn btn-madin mt-3">Découvrir le catalogue</a>
            </div>
        @endif
    </div>
</section>
@endsection