@extends('layouts.app')

@section('sidebar-menu')
<div class="nav-section">
    <div class="nav-section-title">Principal</div>
    <a href="/investisseur/dashboard" class="nav-link {{ request()->is('investisseur/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Tableau de bord</span>
    </a>
    <a href="/investisseur/partenariat" class="nav-link {{ request()->is('investisseur/partenariat') ? 'active' : '' }}">
        <i class="bi bi-handshake"></i>
        <span>Devenir partenaire</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Opportunités</div>
    <a href="/catalogue" class="nav-link">
        <i class="bi bi-search"></i>
        <span>Explorer les artisans</span>
    </a>
</div>
@endsection
