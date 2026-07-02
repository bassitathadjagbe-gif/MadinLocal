@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    <div class="topbar">
        <div>
            <h1 class="page-title">Administration</h1>
            <p class="page-subtitle">Bienvenue, <strong>{{ auth()->user()->name }}</strong> 👋</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.produits.index') }}" class="btn btn-sm btn-artisan">
                <i class="bi bi-box-seam"></i> Validation Produits
            </a>
            <a href="{{ route('admin.artisans.index') }}" class="btn btn-sm btn-artisan">
                <i class="bi bi-tools"></i> Validation Artisans
            </a>
            <a href="{{ route('admin.propositions.index') }}" class="btn btn-sm btn-artisan">
                <i class="bi bi-cash-stack"></i> Validation Propositions
            </a>
        </div>
    </div>

    {{-- ✅ 1. STATISTIQUES COMPLÈTES --}}
    <div class="row g-4 mb-4">
        {{-- Utilisateurs --}}
        <div class="col-md-3">
            <div class="stat-card-old">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-old" style="background: rgba(44, 62, 80, 0.1);">
                        <i class="bi bi-people" style="color: var(--indigo);"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">{{ $stats['total_users'] ?? 0 }}</h3>
                        <small class="text-muted">Utilisateurs</small>
                        <br>
                        <small class="text-muted">{{ $stats['total_artisans'] ?? 0 }} artisans</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produits --}}
        <div class="col-md-3">
            <div class="stat-card-old">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-old" style="background: rgba(201, 169, 97, 0.2);">
                        <i class="bi bi-box-seam" style="color: var(--gold);"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">{{ $stats['total_produits'] ?? 0 }}</h3>
                        <small class="text-muted">Produits</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Commandes --}}
        <div class="col-md-3">
            <div class="stat-card-old">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-old" style="background: rgba(16, 185, 129, 0.15);">
                        <i class="bi bi-bag-check" style="color: #10B981;"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">{{ $stats['total_commandes'] ?? 0 }}</h3>
                        <small class="text-muted">Commandes</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chiffre d'affaires --}}
        <div class="col-md-3">
            <div class="stat-card-old">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-old" style="background: rgba(239, 68, 68, 0.15);">
                        <i class="bi bi-cash-stack" style="color: #EF4444;"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['total_revenus'] ?? 0, 0, ',', ' ') }}</h3>
                        <small class="text-muted">CA total (FCFA)</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produits à valider --}}
        <div class="col-md-4">
            <div class="stat-card-old" style="border-left: 4px solid var(--gold);">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $stats['produits_en_attente'] ?? 0 }}</h3>
                        <small class="text-muted">Produits à valider</small>
                    </div>
                    <a href="{{ route('admin.produits.index') }}" class="btn btn-sm btn-artisan">
                        Voir <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Artisans à valider --}}
        <div class="col-md-4">
            <div class="stat-card-old" style="border-left: 4px solid var(--indigo);">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $stats['artisans_en_attente'] ?? 0 }}</h3>
                        <small class="text-muted">Artisans à valider</small>
                    </div>
                    <a href="{{ route('admin.artisans.index') }}" class="btn btn-sm btn-artisan">
                        Voir <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Propositions en attente --}}
        <div class="col-md-4">
            <div class="stat-card-old" style="border-left: 4px solid #10B981;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-0 fw-bold">{{ $stats['propositions_en_attente'] ?? 0 }}</h3>
                        <small class="text-muted">Propositions à valider</small>
                    </div>
                    <a href="{{ route('admin.propositions.index') }}" class="btn btn-sm btn-artisan">
                        Voir <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ 2. SECTIONS DE VALIDATION RAPIDE --}}
    <div class="row g-4 mb-4">
        {{-- PRODUITS EN ATTENTE --}}
        <div class="col-lg-6">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-box-seam me-2" style="color: var(--gold);"></i>Produits en attente
                    </h4>
                    <a href="{{ route('admin.produits.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($produitsEnAttente) && $produitsEnAttente->count() > 0)
                    @foreach($produitsEnAttente->take(3) as $produit)
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                @if($produit->image_principale)
                                    <img src="{{ $produit->image_principale }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: var(--ivory-dark); border-radius: 12px;" class="d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ Str::limit($produit->nom, 25) }}</h6>
                                    <small class="text-muted">
                                        {{ $produit->artisan->user->name ?? 'Artisan' }}
                                        <br>
                                        <strong style="color: var(--terracotta);">{{ number_format($produit->prix, 0, ',', ' ') }} F</strong>
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('admin.produits.valider', $produit) }}" class="d-inline">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill" onclick="return confirm('Valider ce produit ?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        <p class="text-muted mt-2 mb-0 small">Tous les produits sont validés</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ARTISANS EN ATTENTE --}}
        <div class="col-lg-6">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-tools me-2" style="color: var(--indigo);"></i>Artisans en attente
                    </h4>
                    <a href="{{ route('admin.artisans.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($artisansEnAttente) && $artisansEnAttente->count() > 0)
                    @foreach($artisansEnAttente->take(3) as $artisan)
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--indigo); color: white; font-weight: 700;">
                                    {{ strtoupper(substr($artisan->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $artisan->user->name }}</h6>
                                    <small class="text-muted">
                                        <i class="bi bi-tools me-1"></i>{{ $artisan->specialite ?? 'Artisan' }}
                                        <br>
                                        <i class="bi bi-geo-alt me-1"></i>{{ $artisan->ville ?? '-' }}
                                    </small>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.artisans.valider', $artisan) }}" class="d-inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success rounded-pill" onclick="return confirm('Valider cet artisan ?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        <p class="text-muted mt-2 mb-0 small">Tous les artisans sont validés</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- PROPOSITIONS EN ATTENTE --}}
        <div class="col-12">
            <div class="card-artisan">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="serif fw-bold mb-0" style="color: var(--indigo);">
                        <i class="bi bi-cash-stack me-2" style="color: #10B981;"></i>Propositions d'investissement en attente
                    </h4>
                    <a href="{{ route('admin.propositions.index') }}" class="btn-outline-artisan btn-sm">
                        Voir tout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(isset($propositionsEnAttente) && $propositionsEnAttente->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-artisan mb-0">
                            <thead>
                                <tr>
                                    <th>Investisseur</th>
                                    <th>Artisan</th>
                                    <th>Montant</th>
                                    <th>Durée</th>
                                    <th>ROI</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($propositionsEnAttente->take(5) as $prop)
                                    <tr>
                                        <td><strong>{{ $prop->investisseur->name ?? '-' }}</strong><br><small class="text-muted">{{ $prop->investisseur->email ?? '' }}</small></td>
                                        <td><small>{{ $prop->artisan->user->name ?? '-' }}</small><br><small class="text-muted">{{ $prop->artisan->specialite ?? '' }}</small></td>
                                        <td><strong style="color: var(--terracotta);">{{ number_format($prop->montant, 0, ',', ' ') }} F</strong></td>
                                        <td>{{ $prop->duree_mois }} mois</td>
                                        <td><span class="text-success fw-bold">{{ $prop->taux_roi }}%</span></td>
                                        <td><small>{{ $prop->created_at->format('d/m/Y') }}</small></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <form method="POST" action="{{ route('admin.propositions.valider', $prop) }}" class="d-inline">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Valider cette proposition ?')">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalRejetProp{{ $prop->id }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modalRejetProp{{ $prop->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('admin.propositions.refuser', $prop) }}">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Refuser la proposition</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Motif du refus</label>
                                                            <textarea name="motif_refus" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger">Refuser</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        <p class="text-muted mt-2 mb-0 small">Toutes les propositions sont traitées</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ✅ 3. UTILISATEURS RÉCENTS --}}
        <div class="col-12">
            <div class="card-artisan">
                <h4 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-people me-2"></i>Utilisateurs récents
                </h4>

                @if(isset($usersRecents) && $usersRecents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-artisan mb-0">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usersRecents->take(10) as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: var(--terracotta); color: white; font-weight: 700;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <strong>{{ $user->name }}</strong>
                                            </div>
                                        </td>
                                        <td><small>{{ $user->email }}</small></td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'investisseur' ? 'info' : ($user->role === 'artisan' ? 'warning' : 'secondary')) }} text-dark">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td><small>{{ $user->created_at->format('d/m/Y H:i') }}</small></td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-secondary">Inactif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">Aucun utilisateur récent</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ✅ 4. GRAPHIQUES STATISTIQUES (PLACÉS EN BAS) --}}
    <div class="row g-4 mt-2">
        <div class="col-12">
            <h4 class="serif fw-bold mb-4" style="color: var(--indigo);">
                <i class="bi bi-bar-chart-line me-2"></i>Analyse et Statistiques
            </h4>
        </div>

        {{-- Commandes par mois --}}
        <div class="col-lg-6">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-graph-up me-2"></i>Évolution des commandes
                </h5>
                <canvas id="commandesChart" height="250"></canvas>
            </div>
        </div>

        {{-- Revenus par mois --}}
        <div class="col-lg-6">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-cash-stack me-2"></i>Évolution des revenus
                </h5>
                <canvas id="revenusChart" height="250"></canvas>
            </div>
        </div>

        {{-- Utilisateurs par rôle --}}
        <div class="col-lg-4">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-people me-2"></i>Répartition des utilisateurs
                </h5>
                <canvas id="usersRoleChart" height="250"></canvas>
            </div>
        </div>

        {{-- Statut des commandes --}}
        <div class="col-lg-4">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-pie-chart me-2"></i>Statut des commandes
                </h5>
                <canvas id="commandesStatutChart" height="250"></canvas>
            </div>
        </div>

        {{-- Produits validés --}}
        <div class="col-lg-4">
            <div class="card-artisan">
                <h5 class="serif fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-box-seam me-2"></i>Produits
                </h5>
                <canvas id="produitsChart" height="250"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stat-card-old {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.2s;
    }
    .stat-card-old:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .stat-icon-old {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#666';

    // Graphique Commandes par mois
    const commandesCtx = document.getElementById('commandesChart').getContext('2d');
    new Chart(commandesCtx, {
        type: 'line',
        data: {
            labels: @json($moisLabels ?? []),
            datasets: [{
                label: 'Commandes',
                data: @json($commandesData ?? []),
                borderColor: '#C9A961',
                backgroundColor: 'rgba(201, 169, 97, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    // Graphique Revenus par mois
    const revenusCtx = document.getElementById('revenusChart').getContext('2d');
    new Chart(revenusCtx, {
        type: 'bar',
        data: {
            labels: @json($moisLabels ?? []),
            datasets: [{
                label: 'Revenus (FCFA)',
                data: @json($revenusData ?? []),
                backgroundColor: '#EF4444',
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Graphique Utilisateurs par rôle
    const usersRoleCtx = document.getElementById('usersRoleChart').getContext('2d');
    new Chart(usersRoleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Artisans', 'Investisseurs', 'Clients', 'Admins'],
            datasets: [{
                data: [{{ $usersParRole['artisan'] ?? 0 }}, {{ $usersParRole['investisseur'] ?? 0 }}, {{ $usersParRole['client'] ?? 0 }}, {{ $usersParRole['admin'] ?? 0 }}],
                backgroundColor: ['#C9A961', '#3B82F6', '#10B981', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } } } }
    });

    // Graphique Statut des commandes
    const statutCtx = document.getElementById('commandesStatutChart').getContext('2d');
    new Chart(statutCtx, {
        type: 'pie',
        data: {
            labels: ['En attente', 'Acceptée', 'Terminée', 'Refusée'],
            datasets: [{
                data: [{{ $commandesParStatut['en_attente'] ?? 0 }}, {{ $commandesParStatut['acceptee'] ?? 0 }}, {{ $commandesParStatut['terminee'] ?? 0 }}, {{ $commandesParStatut['refusee'] ?? 0 }}],
                backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } } } }
    });

    // Graphique Produits validés
    const produitsCtx = document.getElementById('produitsChart').getContext('2d');
    new Chart(produitsCtx, {
        type: 'bar',
        data: {
            labels: ['Validés', 'En attente'],
            datasets: [{
                data: [{{ $produitsStats['valides'] ?? 0 }}, {{ $produitsStats['en_attente'] ?? 0 }}],
                backgroundColor: ['#10B981', '#F59E0B'],
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
</script>
@endpush