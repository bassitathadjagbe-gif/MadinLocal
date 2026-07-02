@extends('layouts.app')

@section('sidebar-menu')
<div class="nav-section">
    <div class="nav-section-title">Principal</div>
    <a href="/client/dashboard" class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Tableau de bord</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Mes achats</div>
    <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-madin">
       <i class="bi bi-bag me-2"></i>Mes Commandes
    </a>
    <a href="/catalogue" class="nav-link">
        <i class="bi bi-search"></i>
        <span>Explorer</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Communication</div>
    <a href="{{ route('messages.index') }}" class="btn btn-outline-madin">
    <i class="bi bi-chat-dots me-2"></i>Mes Messages
    @if(auth()->user()->non_lus_count > 0)
        <span class="badge bg-danger ms-2">{{ auth()->user()->non_lus_count }}</span>
    @endif
</a>
</div>
@endsection
