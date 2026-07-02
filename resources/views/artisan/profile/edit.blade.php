@extends('layouts.app')

@section('title', 'Mon Profil')

@section('sidebar-menu')
    <div class="nav-section">
        <div class="nav-section-title">Mon Espace</div>
        <a href="{{ route('artisan.dashboard') }}" class="nav-link {{ request()->routeIs('artisan.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="{{ route('artisan.produits.index') }}" class="nav-link {{ request()->routeIs('artisan.produits.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Mes Produits</span>
        </a>
        <a href="{{ route('artisan.commandes.index') }}" class="nav-link {{ request()->routeIs('artisan.commandes.*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i>
            <span>Mes Commandes</span>
        </a>
        <a href="{{ route('artisan.profil.edit') }}" class="nav-link {{ request()->routeIs('artisan.profil.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Mon Profil</span>
        </a>
    </div>
@endsection

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Mon Profil</h1>
        <p class="page-subtitle">Gérez vos informations personnelles et professionnelles</p>
    </div>
    <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm" style="background: #D1FAE5; color: #065F46;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-3 shadow-sm" style="background: #FEE2E2; color: #991B1B;">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    {{-- COLONNE GAUCHE : AVATAR ET INFOS --}}
    <div class="col-lg-4">
        <div class="profile-card text-center">
            {{-- Avatar --}}
            <div class="avatar-container">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                         alt="Avatar" 
                         id="avatarPreview"
                         class="avatar-img">
                @else
                    <div id="avatarPreview" class="avatar-default">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
            </div>
            
            <label for="avatar" class="btn-upload d-inline-block mb-3">
                <i class="bi bi-camera me-1"></i> Changer la photo
            </label>
            <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
            <p class="text-muted small mb-4">JPG, PNG ou GIF (max 2 Mo)</p>

            <hr class="my-4" style="border-color: rgba(44, 62, 80, 0.1);">

            <div class="text-start">
                <h5 class="fw-bold mb-3" style="color: #2C3E50;">
                    <i class="bi bi-info-circle me-2 text-warning"></i>Informations
                </h5>
                <p class="mb-2"><strong class="text-muted small d-block">Rôle :</strong> <span class="badge bg-warning text-dark">{{ $user->role }}</span></p>
                <p class="mb-2"><strong class="text-muted small d-block">Email :</strong> <br>{{ $user->email }}</p>
                @if($artisan->ville)
                    <p class="mb-2"><strong class="text-muted small d-block">Ville :</strong> <br>{{ $artisan->ville }}</p>
                @endif
                @if($artisan->specialite)
                    <p class="mb-0"><strong class="text-muted small d-block">Spécialité :</strong> <br>{{ $artisan->specialite }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE : FORMULAIRE --}}
    <div class="col-lg-8">
        <div class="profile-card">
            <form method="POST" action="{{ route('artisan.profil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h4 class="fw-bold mb-4" style="color: #2C3E50;">
                    <i class="bi bi-person me-2 text-warning"></i>Informations personnelles
                </h4>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Nom complet *</label>
                        <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Email *</label>
                        <input type="email" name="email" class="form-control-custom" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Téléphone</label>
                        <input type="text" name="telephone" class="form-control-custom" value="{{ old('telephone', $artisan->telephone) }}" placeholder="+229 XX XX XX XX">
                    </div>
                   
                </div>

                <hr class="my-4" style="border-color: rgba(44, 62, 80, 0.1);">

                <h4 class="fw-bold mb-4" style="color: #2C3E50;">
                    <i class="bi bi-tools me-2 text-warning"></i>Informations professionnelles
                </h4>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Spécialité</label>
                        <input type="text" name="specialite" class="form-control-custom" value="{{ old('specialite', $artisan->specialite) }}" placeholder="Ex: Couture, Menuiserie...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Ville</label>
                        <input type="text" name="ville" class="form-control-custom" value="{{ old('ville', $artisan->ville) }}" placeholder="Ex: Cotonou, Porto-Novo...">
                    </div>
                    <div class="col-12">
                        <label class="form-label-custom">Description</label>
                        <textarea name="description" class="form-control-custom" rows="4" placeholder="Présentez-vous en quelques mots...">{{ old('description', $artisan->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn-save-custom flex-grow-1">
                        <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                    </button>
                    <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Annuler
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* CSS dédié à la page Profil pour garantir un rendu parfait */
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
        border: none;
        height: 100%;
    }

    .form-label-custom {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2C3E50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control-custom {
        background: #FAF7F2;
        border: 1.5px solid rgba(44, 62, 80, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
        width: 100%;
        color: #2C3E50;
    }

    .form-control-custom:focus {
        background: white;
        border-color: #A0522D;
        box-shadow: 0 0 0 4px rgba(160, 82, 45, 0.1);
        outline: none;
    }

    .btn-save-custom {
        background: linear-gradient(135deg, #2C3E50, #A0522D);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-save-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(160, 82, 45, 0.3);
        color: white;
    }

    .avatar-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: 0 auto 1.5rem;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #C9A961;
        box-shadow: 0 10px 30px rgba(160, 82, 45, 0.2);
    }

    .avatar-default {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, #C9A961, #A0522D);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        border: 4px solid #C9A961;
        box-shadow: 0 10px 30px rgba(160, 82, 45, 0.2);
    }

    .btn-upload {
        background: #FAF7F2;
        color: #2C3E50;
        border: 1px dashed #A0522D;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-upload:hover {
        background: #A0522D;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script pour prévisualiser l'image quand on en choisit une nouvelle
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                
                // Si c'est une div (avatar par défaut), on la remplace par une img
                if (preview.tagName === 'DIV') {
                    const img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'avatar-img';
                    preview.replaceWith(img);
                }
                
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush