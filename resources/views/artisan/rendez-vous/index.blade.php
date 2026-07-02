@extends('layouts.app')

@section('title', 'Mes Rendez-vous')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        
        <a href="{{ route('artisan.produits.index') }}" class="nav-link {{ request()->routeIs('artisan.produits.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Mes Produits</span>
        </a>
        <a href="{{ route('artisan.commandes.index') }}" class="nav-link {{ request()->routeIs('artisan.commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        <a href="{{ route('artisan.propositions.index') }}" class="nav-link {{ request()->routeIs('artisan.propositions.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            <span>Propositions</span>
        </a>
        <a href="{{ route('artisan.rendez_vous.index') }}" class="nav-link {{ request()->routeIs('artisan.rendez_vous.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Rendez-vous</span>
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
            <h1 class="page-title">Mes Rendez-vous</h1>
            <p class="page-subtitle">Gérez vos rendez-vous clients</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('artisan.dashboard') }}" class="btn-outline-artisan">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    {{-- ✅ STATISTIQUES --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(44, 62, 80, 0.1); color: var(--indigo);">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <p class="stat-value">{{ $stats['total'] ?? 0 }}</p>
                <p class="stat-label">Total RDV</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(201, 169, 97, 0.2); color: var(--gold);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="stat-value">{{ $stats['en_attente'] ?? 0 }}</p>
                <p class="stat-label">En attente</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #3B82F6;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <p class="stat-value">{{ $stats['confirmes'] ?? 0 }}</p>
                <p class="stat-label">Confirmés</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #10B981;">
                    <i class="bi bi-check2-all"></i>
                </div>
                <p class="stat-value">{{ $stats['termines'] ?? 0 }}</p>
                <p class="stat-label">Terminés</p>
            </div>
        </div>
    </div>

    {{-- ✅ RENDEZ-VOUS D'AUJOURD'HUI --}}
    @if(isset($rendezVousAujourdhui) && $rendezVousAujourdhui->count() > 0)
        <div class="alert border-0 shadow-sm mb-4" style="background: #DBEAFE; border-left: 4px solid #3B82F6;">
            <h5 class="fw-bold mb-3" style="color: #1E40AF;">
                <i class="bi bi-calendar-day me-2"></i>Rendez-vous aujourd'hui ({{ $rendezVousAujourdhui->count() }})
            </h5>
            <div class="row g-2">
                @foreach($rendezVousAujourdhui as $rdv)
                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $rdv->client->name ?? 'Client' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $rdv->heure_rdv }}
                                        • {{ $rdv->duree_minutes }} min
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-box-seam me-1"></i>{{ $rdv->service->nom ?? 'Service' }}
                                    </small>
                                    @if($rdv->lieu)
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt me-1"></i>{{ $rdv->lieu }}
                                        </small>
                                    @endif
                                </div>
                                <span class="badge-status badge-info">{{ ucfirst($rdv->statut) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ✅ LISTE COMPLÈTE --}}
    <div class="card-artisan">
        <h4 class="serif fw-bold mb-4" style="color: var(--indigo);">
            <i class="bi bi-calendar-check me-2"></i>Tous les rendez-vous
        </h4>

        @if(isset($rendezVous) && $rendezVous->count() > 0)
            <div class="table-responsive">
                <table class="table table-artisan mb-0">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Lieu</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rendezVous as $rdv)
                            <tr>
                                <td>
                                    <strong>{{ $rdv->client->name ?? 'Client' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-telephone me-1"></i>{{ $rdv->telephone_contact }}
                                    </small>
                                </td>
                                <td>
                                    <small>{{ $rdv->service->nom ?? 'Service' }}</small>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <strong>{{ $rdv->heure_rdv }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $rdv->duree_minutes }} min</small>
                                </td>
                                <td>
                                    <small>{{ $rdv->lieu ?? '-' }}</small>
                                </td>
                                <td>
                                    <strong style="color: var(--terracotta);">
                                        {{ number_format($rdv->montant, 0, ',', ' ') }} F
                                    </strong>
                                </td>
                                <td>
                                    @switch($rdv->statut)
                                        @case('en_attente')
                                            <span class="badge-status badge-warning">En attente</span>
                                            @break
                                        @case('confirme')
                                            <span class="badge-status badge-info">Confirmé</span>
                                            @break
                                        @case('termine')
                                            <span class="badge-status badge-success">Terminé</span>
                                            @break
                                        @case('annule')
                                            <span class="badge-status badge-danger">Annulé</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $rendezVous->links() }}</div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">Aucun rendez-vous</h4>
                <p class="text-muted">Vous n'avez pas encore reçu de demande de rendez-vous.</p>
            </div>
        @endif
    </div>
@endsection