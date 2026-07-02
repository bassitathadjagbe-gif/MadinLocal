@extends('layouts.app')

@section('title', 'Dashboard Artisan')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        
        <a href="{{ route('artisan.produits.index') }}" class="nav-link {{ request()->routeIs('artisan.produits.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Mes Produits/Services</span>
        </a>
        
        <a href="{{ route('artisan.commandes.index') }}" class="nav-link {{ request()->routeIs('artisan.commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        
        <a href="{{ route('artisan.rendez_vous.index') }}" class="nav-link {{ request()->routeIs('artisan.rendez_vous.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Mes Rendez-vous</span>
        </a>
        
        <a href="{{ route('artisan.propositions.index') }}" class="nav-link {{ request()->routeIs('artisan.propositions.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            <span>Propositions</span>
            @if(isset($propositionsRecues) && $propositionsRecues > 0)
                <span class="badge bg-danger rounded-pill ms-auto">{{ $propositionsRecues }}</span>
            @endif
        </a>
        
        <a href="{{ route('artisan.profil.edit') }}" class="nav-link {{ request()->routeIs('artisan.profil.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Mon Profil</span>
        </a>
    </div>

    
@endsection

@section('content')
    <div class="topbar">
        <div>
            <h1 class="page-title">Tableau de bord</h1>
            <p class="page-subtitle">Bienvenue, <strong>{{ auth()->user()->name }}</strong> 👋</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('artisan.produits.create') }}" class="btn-artisan">
                <i class="bi bi-plus-circle"></i> Ajouter un produit
            </a>
        </div>
    </div>

    {{-- ✅ ALERTE : Propositions reçues --}}
    @if(isset($propositionsRecues) && $propositionsRecues > 0)
        <div class="alert border-0 shadow-sm mb-4 d-flex align-items-center" 
             style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-left: 4px solid #F59E0B;">
            <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem; color: #F59E0B;"></i>
            <div class="flex-grow-1">
                <strong style="color: #92400E;">💰 {{ $propositionsRecues }} proposition(s) d'investissement en attente !</strong>
                <p class="mb-0 small mt-1" style="color: #92400E;">
                    Des investisseurs souhaitent financer vos projets. Examinez-les rapidement.
                </p>
            </div>
            <a href="{{ route('artisan.propositions.index') }}" class="btn btn-warning btn-sm ms-3">
                <i class="bi bi-eye me-1"></i>Voir
            </a>
        </div>
    @endif

    {{-- ✅ STATISTIQUES - 5 CARTES BIEN ALIGNÉES --}}
    <div class="row g-3 mb-4">
        {{-- Carte 1 : Produits --}}
        <div class="col col-lg col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(44, 62, 80, 0.1); color: var(--indigo);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <p class="stat-value">{{ $totalProduits ?? 0 }}</p>
                <p class="stat-label">Produits</p>
                @if(isset($produitsEnAttente) && $produitsEnAttente > 0)
                    <small class="text-warning"><i class="bi bi-hourglass-split"></i> {{ $produitsEnAttente }} en attente</small>
                @endif
            </div>
        </div>

        {{-- Carte 2 : Commandes --}}
        <div class="col col-lg col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(201, 169, 97, 0.2); color: var(--gold);">
                    <i class="bi bi-bag"></i>
                </div>
                <p class="stat-value">{{ $totalCommandes ?? 0 }}</p>
                <p class="stat-label">Commandes</p>
                @if(isset($commandesEnAttente) && $commandesEnAttente > 0)
                    <small class="text-danger"><i class="bi bi-exclamation-circle"></i> {{ $commandesEnAttente }} à traiter</small>
                @endif
            </div>
        </div>

        {{-- Carte 3 : Chiffre d'affaires --}}
        <div class="col col-lg col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <p class="stat-value">{{ number_format($chiffreAffaires ?? 0, 0, ',', ' ') }}</p>
                <p class="stat-label">Chiffre d'affaires (F)</p>
            </div>
        </div>

        {{-- Carte 4 : Messages --}}
        <div class="col col-lg col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>
                <p class="stat-value">{{ $messagesNonLus ?? 0 }}</p>
                <p class="stat-label">Messages non lus</p>
            </div>
        </div>

        {{-- Carte 5 : Propositions --}}
        <div class="col col-lg col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.15); color: #EF4444;">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <p class="stat-value">{{ $propositionsRecues ?? 0 }}</p>
                <p class="stat-label">Propositions</p>
                @if(isset($propositionsRecues) && $propositionsRecues > 0)
                    <small class="text-danger"><i class="bi bi-bell-fill"></i> {{ $propositionsRecues }} à examiner</small>
                @else
                    <small class="text-muted"><i class="bi bi-check-circle"></i> Aucune</small>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- COMMANDES RÉCENTES --}}
        <div class="col-lg-7">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-clock-history me-2"></i>Commandes récentes
                    </h4>
                    <a href="{{ route('artisan.commandes.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($commandesRecentes) && $commandesRecentes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-artisan mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesRecentes as $commande)
                                    <tr>
                                        <td>
                                            <strong>{{ $commande->produit->nom ?? 'Supprimé' }}</strong>
                                            <br><small class="text-muted">Qté: {{ $commande->quantite }}</small>
                                        </td>
                                        <td>
                                            <small><i class="bi bi-person me-1"></i>{{ $commande->client->name ?? 'Client' }}</small>
                                        </td>
                                        <td>
                                            <strong style="color: var(--terracotta);">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</strong>
                                        </td>
                                        <td>
                                            @switch($commande->statut)
                                                @case('en_attente')
                                                    <span class="badge-status badge-warning">En attente</span>
                                                    @break
                                                @case('acceptee')
                                                    <span class="badge-status badge-info">Acceptée</span>
                                                    @break
                                                @case('terminee')
                                                    <span class="badge-status badge-success">Terminée</span>
                                                    @break
                                                @case('refusee')
                                                    <span class="badge-status badge-danger">Refusée</span>
                                                    @break
                                                @default
                                                    <span class="badge-status badge-secondary">{{ $commande->statut }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($commande->statut === 'en_attente')
                                                <div class="d-flex gap-1">
                                                    <form method="POST" action="{{ route('artisan.commandes.accepter', $commande) }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-2" 
                                                                title="Accepter"
                                                                onclick="return confirm('Accepter cette commande ?')">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('artisan.commandes.refuser', $commande) }}" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-2" 
                                                                title="Refuser"
                                                                onclick="return confirm('Refuser cette commande ?')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="badge bg-{{ 
                                                    $commande->statut === 'acceptee' ? 'info' : 
                                                    ($commande->statut === 'terminee' ? 'success' : 
                                                    ($commande->statut === 'refusee' ? 'danger' : 'secondary'))
                                                }}">
                                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-2 mb-0">Aucune commande reçue</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- PRODUITS RÉCENTS --}}
        <div class="col-lg-5">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-box-seam me-2"></i>Mes Produits
                    </h4>
                    <a href="{{ route('artisan.produits.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($produitsRecents) && $produitsRecents->count() > 0)
                    @foreach($produitsRecents as $produit)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: var(--ivory-dark); border-radius: 12px;" class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">{{ Str::limit($produit->nom, 25) }}</h6>
                                    <small class="text-muted">{{ number_format($produit->prix, 0, ',', ' ') }} F</small>
                                </div>
                            </div>
                            <div>
                                @if($produit->is_validated)
                                    <span class="badge-status badge-success">Validé</span>
                                @else
                                    <span class="badge-status badge-warning">En attente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-box" style="font-size: 2.5rem; color: #ddd;"></i>
                        <p class="text-muted mt-2 mb-3 small">Aucun produit</p>
                        <a href="{{ route('artisan.produits.create') }}" class="btn-artisan btn-sm">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ NOUVELLE SECTION : Propositions récentes --}}
    @if(isset($propositionsRecentes) && $propositionsRecentes->count() > 0)
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="card-artisan">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                            <i class="bi bi-cash-coin me-2" style="color: #EF4444;"></i>Propositions d'investissement récentes
                        </h4>
                        <a href="{{ route('artisan.propositions.index') }}" class="btn-outline-artisan btn-sm">
                            Voir tout <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row g-3">
                        @foreach($propositionsRecentes->take(3) as $proposition)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 h-100" style="background: #FAFAFA;">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <span class="text-primary fw-bold">{{ substr($proposition->investisseur->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <strong class="small">{{ $proposition->investisseur->name }}</strong>
                                            <br><small class="text-muted">{{ $proposition->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span class="text-muted">Montant :</span>
                                            <strong style="color: #EF4444;">{{ number_format($proposition->montant, 0, ',', ' ') }} F</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span class="text-muted">Durée :</span>
                                            <strong>{{ $proposition->duree_mois }} mois</strong>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span class="text-muted">ROI :</span>
                                            <strong class="text-success">{{ $proposition->taux_roi }}%</strong>
                                        </div>
                                    </div>
                                    <a href="{{ route('artisan.propositions.index') }}" class="btn btn-sm btn-danger w-100 mt-3 rounded-pill">
                                        <i class="bi bi-eye me-1"></i>Examiner
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection