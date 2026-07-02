@extends('layouts.app')

@section('sidebar-menu')
<div class="nav-section">
    <div class="nav-section-title">Principal</div>
    <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Tableau de bord</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Gestion</div>
    <a href="/admin/utilisateurs" class="nav-link {{ request()->is('admin/utilisateurs*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i>
        <span>Utilisateurs</span>
        <span class="badge-count">248</span>
    </a>
    <a href="/admin/produits" class="nav-link {{ request()->is('admin/moderation*') ? 'active' : '' }}">
        <i class="bi bi-shield-check"></i>
        <span>Modération</span>
        <span class="badge-count">7</span>
    </a>
    <a href="/admin/categories" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
        <i class="bi bi-tags-fill"></i>
        <span>Catégories</span>
    </a>
</div>

<div class="nav-section">
    <div class="nav-section-title">Communication</div>
    <a href="/admin/messages" class="nav-link {{ request()->is('admin/messages') ? 'active' : '' }}">
        <i class="bi bi-chat-dots-fill"></i>
        <span>Messages</span>
        <span class="badge-count">3</span>
    </a>
    <a href="/admin/statistiques" class="nav-link {{ request()->is('admin/statistiques') ? 'active' : '' }}">
        <i class="bi bi-graph-up"></i>
        <span>Statistiques</span>
    </a>
</div>

@endsection
