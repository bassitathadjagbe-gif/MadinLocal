@extends('layouts.app')

@section('title', 'Mon Profil')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        <a href="{{ route('client.dashboard') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('client.commandes.index') }}" class="nav-link">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        <a href="{{ route('client.favoris.index') }}" class="nav-link">
            <i class="bi bi-heart"></i>
            <span>Mes Favoris</span>
        </a>
        <a href="{{ route('client.profil.edit') }}" class="nav-link active">
            <i class="bi bi-person-circle"></i>
            <span>Mon Profil</span>
        </a>
    </div>
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Mon Profil</h1>
        <p class="page-subtitle">Gérez vos informations personnelles</p>
    </div>
    <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
            <div class="mb-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                         alt="Avatar" 
                         id="avatarPreview"
                         class="rounded-circle mb-3"
                         style="width: 140px; height: 140px; object-fit: cover; border: 4px solid var(--gold);">
                @else
                    <div id="avatarPreview"
                         class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                         style="width: 140px; height: 140px; background: linear-gradient(135deg, var(--gold), var(--terracotta)); color: white; font-size: 4.5rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
                
                <label for="avatar" class="btn btn-outline-secondary rounded-pill px-4 d-inline-block" style="cursor: pointer;">
                    <i class="bi bi-camera me-1"></i>Changer la photo
                </label>
                <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                <small class="text-muted d-block mt-2">JPG, PNG (max 2 Mo)</small>
            </div>

            <hr>

            <div class="text-start">
                <h5 class="fw-bold mb-3" style="color: var(--indigo);">
                    <i class="bi bi-info-circle me-2 text-warning"></i>Informations
                </h5>
                <p class="mb-2"><strong class="text-muted small">Rôle :</strong> <span class="badge bg-info">Client</span></p>
                <p class="mb-2"><strong class="text-muted small">Email :</strong> <br>{{ $user->email }}</p>
                @if($user->telephone)
                    <p class="mb-0"><strong class="text-muted small">Téléphone :</strong> <br>{{ $user->telephone }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-artisan">
            <form method="POST" action="{{ route('client.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h4 class="fw-bold mb-4" style="color: var(--indigo);">
                    <i class="bi bi-person me-2 text-warning"></i>Informations personnelles
                </h4>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom complet *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}" placeholder="+229 XX XX XX XX">
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

@push('scripts')
<script>
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                if (preview.tagName === 'DIV') {
                    const img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'rounded-circle mb-3';
                    img.style.cssText = 'width: 140px; height: 140px; object-fit: cover; border: 4px solid var(--gold);';
                    preview.replaceWith(img);
                }
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush