@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<section class="profile-section py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne gauche : Infos principales -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card">
                    <!-- Avatar -->
                    <div class="profile-avatar-container">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="profile-avatar">
                        @else
                            <div class="profile-avatar-placeholder">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- Infos -->
                    <div class="profile-info text-center">
                        <h3 class="fw-bold mb-1">{{ $artisan->nom_entreprise }}</h3>
                        <p class="text-muted mb-2">
                            <i class="bi bi-tools"></i> {{ $artisan->specialite }}
                        </p>
                        <div class="mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <i class="bi bi-star-fill {{ $i < floor($artisan->average_rating) ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="text-muted small">({{ number_format($artisan->average_rating, 1) }})</span>
                        </div>

                        @if($artisan->is_verified)
                            <span class="badge bg-success mb-3">
                                <i class="bi bi-patch-check-fill"></i> Artisan vérifié
                            </span>
                        @else
                            <span class="badge bg-warning text-dark mb-3">
                                <i class="bi bi-hourglass-split"></i> En attente de validation
                            </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="profile-actions">
                        <a href="{{ route('artisan.profile.edit') }}" class="btn btn-madin w-100 mb-2">
                            <i class="bi bi-pencil-square me-2"></i>Modifier mon profil
                        </a>
                        <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-madin w-100">
                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                        </a>
                    </div>
                </div>

                <!-- Contact -->
                <div class="profile-card mt-3">
                    <h5 class="mb-3">
                        <i class="bi bi-person-lines-fill" style="color: var(--secondary-color);"></i>
                        Informations de contact
                    </h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-envelope text-muted me-2"></i>
                            <strong>Email :</strong> {{ Auth::user()->email }}
                        </li>
                        @if(Auth::user()->phone)
                            <li class="mb-2">
                                <i class="bi bi-telephone text-muted me-2"></i>
                                <strong>Téléphone :</strong> {{ Auth::user()->phone }}
                            </li>
                        @endif
                        @if($artisan->adresse)
                            <li class="mb-2">
                                <i class="bi bi-geo-alt text-muted me-2"></i>
                                <strong>Adresse :</strong> {{ $artisan->adresse }}
                            </li>
                        @endif
                        @if($artisan->ville)
                            <li class="mb-2">
                                <i class="bi bi-building text-muted me-2"></i>
                                <strong>Ville :</strong> {{ $artisan->ville }}
                            </li>
                        @endif
                        <li>
                            <i class="bi bi-calendar-check text-muted me-2"></i>
                            <strong>Expérience :</strong> {{ $artisan->experience_annees }} an(s)
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Colonne droite : Présentation + Portfolio -->
            <div class="col-lg-8">
                <!-- Présentation -->
                <div class="profile-card mb-4">
                    <h5 class="mb-3">
                        <i class="bi bi-info-circle" style="color: var(--secondary-color);"></i>
                        Présentation
                    </h5>
                    <p class="text-muted">{{ $artisan->bio ?? 'Aucune présentation pour le moment.' }}</p>
                </div>

                <!-- Portfolio -->
                <div class="profile-card">
                    <h5 class="mb-3">
                        <i class="bi bi-images" style="color: var(--secondary-color);"></i>
                        Portfolio
                        <span class="badge bg-secondary ms-2">
                            {{ count($artisan->portfolio_images ?? []) }} image(s)
                        </span>
                    </h5>

                    @if(count($artisan->portfolio_images ?? []) > 0)
                        <div class="row g-3">
                            @foreach($artisan->portfolio_images as $image)
                                <div class="col-md-4 col-6">
                                    <div class="portfolio-item">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Portfolio" class="img-fluid rounded">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="bi bi-images" style="font-size: 4rem; color: #ddd;"></i>
                            <p class="text-muted mt-3 mb-0">Aucune image dans le portfolio</p>
                            <a href="{{ route('artisan.profile.edit') }}" class="btn btn-madin btn-sm mt-3">
                                <i class="bi bi-plus-circle me-2"></i>Ajouter des images
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .profile-section {
        background: #fafafa;
        padding-top: 100px !important;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }

    .profile-avatar-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--light-bg);
        box-shadow: 0 5px 20px rgba(210, 105, 30, 0.2);
    }

    .profile-avatar-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 700;
        border: 5px solid var(--light-bg);
        box-shadow: 0 5px 20px rgba(210, 105, 30, 0.2);
    }

    .profile-info h3 {
        color: var(--primary-color);
    }

    .portfolio-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .portfolio-item:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
    }

    .portfolio-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .btn-outline-madin {
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-madin:hover {
        background: var(--secondary-color);
        color: white;
    }
</style>
@endpush