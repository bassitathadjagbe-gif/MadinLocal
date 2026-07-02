@extends('layouts.client')
@section('title', 'Mes Commandes')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Mes commandes</h1>
        <p class="page-subtitle">Suivez toutes vos commandes en cours et passées</p>
    </div>
</div>

<div class="d-flex gap-2 mb-4 flex-wrap">
    <button class="filter-chip active" style="background:var(--terracotta); color:white; border:none; padding:0.5rem 1.25rem; border-radius:50px;">Toutes (15)</button>
    <button class="filter-chip" style="background:white; padding:0.5rem 1.25rem; border-radius:50px; border:1px solid rgba(44,62,80,0.1);">En cours (3)</button>
    <button class="filter-chip" style="background:white; padding:0.5rem 1.25rem; border-radius:50px; border:1px solid rgba(44,62,80,0.1);">Livrées (11)</button>
    <button class="filter-chip" style="background:white; padding:0.5rem 1.25rem; border-radius:50px; border:1px solid rgba(44,62,80,0.1);">À évaluer (2)</button>
</div>

<div class="card-artisan p-0 overflow-hidden">
    @php
        $orders = [
            ['product' => 'Pagne tissé traditionnel', 'artisan' => 'Atelier Kpodji', 'price' => 25000, 'date' => '15 juin 2026', 'status' => 'warning', 'statusText' => 'En préparation'],
            ['product' => 'Collier perles ethnique', 'artisan' => 'Bijoux Akossiwa', 'price' => 15000, 'date' => '12 juin 2026', 'status' => 'info', 'statusText' => 'En livraison'],
            ['product' => 'Sac en cuir fait main', 'artisan' => "Cuir d'Afrique", 'price' => 35000, 'date' => '5 juin 2026', 'status' => 'success', 'statusText' => 'Livrée'],
            ['product' => 'Chemise en pagne', 'artisan' => 'Couture Fifa', 'price' => 22000, 'date' => '28 mai 2026', 'status' => 'success', 'statusText' => 'Livrée'],
            ['product' => 'Poterie décorative', 'artisan' => 'Atelier Terre', 'price' => 18000, 'date' => '20 mai 2026', 'status' => 'success', 'statusText' => 'Livrée'],
        ];
    @endphp

    @foreach($orders as $order)
    <div class="p-3" style="border-bottom:1px solid rgba(44,62,80,0.08);">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div style="width:70px; height:70px; background:var(--ivory-dark); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-box-seam" style="font-size:2rem; color:var(--terracotta);"></i>
            </div>
            <div style="flex:1; min-width:200px;">
                <strong style="color:var(--indigo); font-size:1.05rem;">{{ $order['product'] }}</strong>
                <p class="small text-muted mb-0">Par {{ $order['artisan'] }} • {{ $order['date'] }}</p>
            </div>
            <div class="text-end">
                <strong style="color:var(--terracotta); font-size:1.1rem;">{{ number_format($order['price'], 0, ',', ' ') }} F</strong>
                <div class="mt-1"><span class="badge-status badge-{{ $order['status'] }}">{{ $order['statusText'] }}</span></div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-artisan" style="padding:0.5rem 1rem; font-size:0.85rem;"><i class="bi bi-eye"></i> Détails</button>
                @if($order['status'] == 'success')
                <a href="/client/evaluer/1" class="btn btn-gold" style="padding:0.5rem 1rem; font-size:0.85rem;"><i class="bi bi-star"></i> Évaluer</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
