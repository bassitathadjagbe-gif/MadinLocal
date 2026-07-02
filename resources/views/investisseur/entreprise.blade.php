@extends('layouts.app')

@section('title', 'Mon Entreprise')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace Investisseur</div>
        <a href="{{ route('investisseur.dashboard') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('investisseur.opportunites') }}" class="nav-link">
            <i class="bi bi-graph-up"></i>
            <span>Mes Opportunités</span>
        </a>
        <a href="{{ route('investisseur.entreprise') }}" class="nav-link active">
            <i class="bi bi-building"></i>
            <span>Mon Entreprise</span>
        </a>
    </div>
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Mon Entreprise</h1>
        <p class="page-subtitle">Gérez votre profil investisseur</p>
    </div>
    <a href="{{ route('investisseur.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-artisan text-center">
            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                 style="width: 120px; height: 120px; background: linear-gradient(135deg, #C9A961, #A0522D); color: white; font-size: 3.5rem;">
                <i class="bi bi-building"></i>
            </div>
            <h4 class="fw-bold mb-2">{{ $profil->entreprise ?? 'Mon Entreprise' }}</h4>
            <p class="text-muted small mb-3">{{ $profil->type_investissement ?? 'Type non défini' }}</p>
            
            @if($profil->is_approved)
                <span class="badge bg-success">✓ Profil approuvé</span>
            @else
                <span class="badge bg-warning text-dark">⏳ En attente d'approbation</span>
            @endif

            <hr class="my-4">

            <div class="text-start">
                <h6 class="fw-bold mb-3" style="color: #2C3E50;">
                    <i class="bi bi-info-circle me-2 text-warning"></i>Informations
                </h6>
                <p class="mb-2"><strong class="text-muted small d-block">Budget min :</strong> {{ number_format($profil->budget_min ?? 0, 0, ',', ' ') }} FCFA</p>
                <p class="mb-2"><strong class="text-muted small d-block">Budget max :</strong> {{ number_format($profil->budget_max ?? 0, 0, ',', ' ') }} FCFA</p>
                <p class="mb-0"><strong class="text-muted small d-block">Membre depuis :</strong> {{ \Carbon\Carbon::parse($profil->created_at)->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-artisan">
            <form method="POST" action="{{ route('investisseur.entreprise.update') }}">
                @csrf
                @method('PUT')

                <h4 class="fw-bold mb-4" style="color: #2C3E50;">
                    <i class="bi bi-building me-2 text-warning"></i>Informations de l'entreprise
                </h4>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom de l'entreprise *</label>
                        <input type="text" name="entreprise" class="form-control" value="{{ old('entreprise', $profil->entreprise) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Type d'investissement *</label>
                        <select name="type_investissement" class="form-select" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="Capital" {{ $profil->type_investissement === 'Capital' ? 'selected' : '' }}>Capital</option>
                            <option value="Matériel" {{ $profil->type_investissement === 'Matériel' ? 'selected' : '' }}>Matériel</option>
                            <option value="Formation" {{ $profil->type_investissement === 'Formation' ? 'selected' : '' }}>Formation</option>
                            <option value="Mixte" {{ $profil->type_investissement === 'Mixte' ? 'selected' : '' }}>Mixte</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Budget minimum (FCFA)</label>
                        <input type="number" name="budget_min" class="form-control" value="{{ old('budget_min', $profil->budget_min) }}" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Budget maximum (FCFA)</label>
                        <input type="number" name="budget_max" class="form-control" value="{{ old('budget_max', $profil->budget_max) }}" min="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description de votre projet d'investissement</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Décrivez votre vision, vos objectifs d'investissement, les secteurs qui vous intéressent...">{{ old('description', $profil->description) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2">
                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection