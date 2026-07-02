@extends('layouts.artisan')
@section('title', 'Commandes')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Commandes reçues</h1>
        <p class="page-subtitle">Gérez les demandes de vos clients</p>
    </div>
    <div class="topbar-actions">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Rechercher...">
        </div>
    </div>
</div>

<!-- Stats rapides -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7; color:#92400E;"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">3</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#DBEAFE; color:#1E40AF;"><i class="bi bi-gear"></i></div>
            <div class="stat-value">5</div>
            <div class="stat-label">En cours</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#D1FAE5; color:#065F46;"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value">47</div>
            <div class="stat-label">Terminées</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEE2E2; color:#991B1B;"><i class="bi bi-x-circle"></i></div>
            <div class="stat-value">2</div>
            <div class="stat-label">Annulées</div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="d-flex gap-2 mb-3 flex-wrap">
    <button class="filter-chip active" style="background:var(--terracotta); color:white; border:none; padding:0.5rem 1.25rem; border-radius:50px; font-size:0.85rem;">Toutes (57)</button>
    <button class="filter-chip" style="background:white; color:var(--indigo); border:1px solid rgba(44,62,80,0.1); padding:0.5rem 1.25rem; border-radius:50px; font-size:0.85rem;">En attente</button>
    <button class="filter-chip" style="background:white; color:var(--indigo); border:1px solid rgba(44,62,80,0.1); padding:0.5rem 1.25rem; border-radius:50px; font-size:0.85rem;">En cours</button>
    <button class="filter-chip" style="background:white; color:var(--indigo); border:1px solid rgba(44,62,80,0.1); padding:0.5rem 1.25rem; border-radius:50px; font-size:0.85rem;">Terminées</button>
</div>

<!-- Liste des commandes -->
<div class="card-artisan p-0 overflow-hidden">
    @php
        $orders = [
            ['id' => '#1250', 'client' => 'Amina Diallo', 'avatar' => 32, 'product' => 'Pagne tissé traditionnel', 'price' => 25000, 'date' => 'Il y a 2 min', 'status' => 'warning', 'statusText' => 'En attente'],
            ['id' => '#1249', 'client' => 'Jean Kouassi', 'avatar' => 15, 'product' => 'Chemise en pagne', 'price' => 44000, 'date' => 'Il y a 1h', 'status' => 'info', 'statusText' => 'En cours'],
            ['id' => '#1248', 'client' => 'Fatou Bello', 'avatar' => 25, 'product' => 'Nappe tissée + 2 coussins', 'price' => 71000, 'date' => 'Il y a 3h', 'status' => 'info', 'statusText' => 'En cours'],
            ['id' => '#1247', 'client' => 'Marc Dubois', 'avatar' => 52, 'product' => 'Écharpe artisanale', 'price' => 12000, 'date' => 'Hier', 'status' => 'success', 'statusText' => 'Terminée'],
            ['id' => '#1246', 'client' => 'Sarah Mensah', 'avatar' => 45, 'product' => 'Sac en coton tissé', 'price' => 28000, 'date' => 'Hier', 'status' => 'success', 'statusText' => 'Terminée'],
        ];
    @endphp

    @foreach($orders as $order)
    <div class="p-3" style="border-bottom:1px solid rgba(44,62,80,0.08); transition:background 0.2s;" onmouseover="this.style.background='var(--ivory)'" onmouseout="this.style.background='transparent'">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <img src="https://i.pravatar.cc/50?img={{ $order['avatar'] }}" style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
            <div style="flex:1; min-width:200px;">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <strong style="color:var(--indigo);">{{ $order['client'] }}</strong>
                    <small class="text-muted">{{ $order['id'] }}</small>
                    <span class="badge-status badge-{{ $order['status'] }}">{{ $order['statusText'] }}</span>
                </div>
                <p class="small text-muted mb-0">{{ $order['product'] }} • {{ $order['date'] }}</p>
            </div>
            <div class="text-end">
                <strong style="color:var(--terracotta); font-size:1.1rem;">{{ number_format($order['price'], 0, ',', ' ') }} F</strong>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-artisan" style="padding:0.5rem 1rem; font-size:0.85rem;"><i class="bi bi-eye"></i></button>
                @if($order['status'] == 'warning')
                <button class="btn" style="background:#D1FAE5; color:#065F46; padding:0.5rem 1rem; font-size:0.85rem;"><i class="bi bi-check"></i></button>
                <button class="btn" style="background:#FEE2E2; color:#991B1B; padding:0.5rem 1rem; font-size:0.85rem;"><i class="bi bi-x"></i></button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
