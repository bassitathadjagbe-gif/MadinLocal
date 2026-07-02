@extends('layouts.app')

@section('sidebar-menu')
<div class="nav-section">
    <div class="nav-section-title">Principal</div>
    <a href="/artisan/dashboard" class="nav-link {{ request()->is('artisan/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Tableau de bord</span>
    </a>
    <a href="/artisan/profil" class="nav-link {{ request()->is('artisan/profil') ? 'active' : '' }}">
        <i class="bi bi-person-fill"></i>
        <span>Mon profil</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Boutique</div>
    <a href="/artisan/produits" class="nav-link {{ request()->is('artisan/produits*') ? 'active' : '' }}">
        <i class="bi bi-box-seam-fill"></i>
        <span>Mes produits</span>
        <span class="badge-count">12</span>
    </a>
    
    <a href="/artisan/produits/ajouter" class="nav-link {{ request()->is('artisan/produits/ajouter') ? 'active' : '' }}">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Ajouter un produit</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Activité</div>
    <a href="{{ route('artisan.commandes.index') }}" class="btn btn-outline-madin">
       <i class="bi bi-inbox me-2"></i>Commandes Reçues
    </a>
    <a href="/artisan/messages" class="nav-link {{ request()->is('artisan/messages') ? 'active' : '' }}">
        <i class="bi bi-chat-dots-fill"></i>
        <span>Messages</span>
        <span class="badge-count">5</span>
    </a>
</div>
@endsection
