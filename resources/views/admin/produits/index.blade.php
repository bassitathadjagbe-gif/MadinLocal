@extends('layouts.app')

@section('title', 'Validation des produits')

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa; min-height: 100vh;">
    <div class="container">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-check2-square me-2"></i>Validation des produits
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Onglets --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <ul class="nav nav-pills justify-content-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'en_attente' ? 'active' : '' }}" 
                           href="{{ route('admin.produits.index', ['filter' => 'en_attente']) }}">
                            <i class="bi bi-hourglass-split me-1"></i>
                            En attente <span class="badge bg-warning text-dark ms-1">{{ $enAttente }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'valides' ? 'active' : '' }}" 
                           href="{{ route('admin.produits.index', ['filter' => 'valides']) }}">
                            <i class="bi bi-check-circle me-1"></i>
                            Validés <span class="badge bg-success ms-1">{{ $valides }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'rejetes' ? 'active' : '' }}" 
                           href="{{ route('admin.produits.index', ['filter' => 'rejetes']) }}">
                            <i class="bi bi-x-circle me-1"></i>
                            Rejetés <span class="badge bg-danger ms-1">{{ $rejetes }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Liste des produits --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                @if($produits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Aperçu</th>
                                    <th>Nom</th>
                                    <th>Artisan</th>
                                    <th>Catégorie</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $produit)
                                    <tr>
                                        <td>
                                            @if($produit->image_principale)
                                                <img src="{{ $produit->image_principale }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover;" 
                                                     class="rounded">
                                            @else
                                                <div style="width: 60px; height: 60px; background: #f0f0f0;" 
                                                     class="rounded d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $produit->nom }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $produit->type === 'produit' ? '📦 Produit' : '🔧 Service' }}</small>
                                        </td>
                                        <td>
                                            <small>
                                                <i class="bi bi-person"></i>
                                                {{ $produit->artisan->user->name ?? 'Inconnu' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $produit->category->nom ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">
                                                {{ number_format($produit->prix, 0, ',', ' ') }} F
                                            </strong>
                                        </td>
                                        <td>
                                            @if($produit->is_validated)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Validé
                                                </span>
                                            @elseif($produit->is_rejected)
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle"></i> Rejeté
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-hourglass-split"></i> En attente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $produit->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
<td>
    <div class="btn-group">
        {{-- Validation --}}
        @if(!$produit->is_validated && !$produit->is_rejected)
            <form method="POST" action="{{ route('admin.produits.validate', $produit) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success" title="Valider">
                    <i class="bi bi-check-lg"></i>
                </button>
            </form>
        @elseif($produit->is_validated)
            <form method="POST" action="{{ route('admin.produits.reject', $produit) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning" title="Dévalider">
                    <i class="bi bi-x-lg"></i>
                </button>
            </form>
        @endif

        {{-- Voir --}}
        <a href="{{ route('admin.produits.show', $produit) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-eye me-1"></i>Voir
        </a>

        {{-- Supprimer --}}
        <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}" 
              class="d-inline"
              onsubmit="return confirm('⚠️ Supprimer définitivement ce produit ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $produits->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 5rem; color: #ddd;"></i>
                        <h4 class="mt-3 text-muted">Aucun produit dans cette catégorie</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection