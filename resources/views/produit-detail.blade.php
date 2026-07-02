@extends('layouts.app')

@section('title', $produit->nom . ' - MadinLocal')

@section('content')
<section class="produit-detail-section py-5">
    <div class="container">
        {{-- Fil d'Ariane --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalogue') }}">Catalogue</a></li>
                @if($produit->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalogue', ['category' => $produit->category_id]) }}">
                            {{ $produit->category->nom }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $produit->nom }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- COLONNE GAUCHE : Galerie d'images --}}
            <div class="col-lg-7">
                <div class="galerie-container">
                    {{-- Image principale --}}
                    <div class="image-principale mb-3">
                        @if($produit->image_principale)
                            <img id="mainImage" src="{{ $produit->image_principale }}" 
                                 alt="{{ $produit->nom }}" class="img-fluid rounded shadow-sm">
                        @else
                            <div class="image-placeholder">
                                <i class="bi bi-image"></i>
                                <p>Aucune image</p>
                            </div>
                        @endif
                    </div>

                    {{-- Miniatures --}}
                    @if($produit->images && count($produit->images) > 1)
                        <div class="miniatures row g-2">
                            @foreach($produit->images as $index => $image)
                                <div class="col-3 col-md-2">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Miniature {{ $index + 1 }}"
                                         class="img-thumbnail miniature {{ $index === 0 ? 'active' : '' }}"
                                         onclick="changerImage('{{ asset('storage/' . $image) }}', this)">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- COLONNE DROITE : Informations --}}
            <div class="col-lg-5">
                <div class="info-container">
                    {{-- Badge type amélioré --}}
                    <div class="mb-3">
                        @if($produit->isService())
                            <span class="badge type-badge type-service">
                                <i class="bi bi-clock me-1"></i> Service / Prestation
                            </span>
                        @else
                            <span class="badge type-badge type-produit">
                                <i class="bi bi-box-seam me-1"></i> Produit physique
                            </span>
                        @endif
                        
                        @if($produit->artisan && $produit->artisan->is_verified)
                            <span class="badge bg-success ms-2">
                                <i class="bi bi-patch-check-fill"></i> Artisan vérifié
                            </span>
                        @endif
                    </div>

                    {{-- Titre --}}
                    <h1 class="produit-nom mb-3">{{ $produit->nom }}</h1>

                    {{-- Catégorie --}}
                    <div class="mb-3">
                        <i class="bi bi-tag text-muted"></i>
                        <span class="text-muted">{{ $produit->category->nom ?? 'Non catégorisé' }}</span>
                    </div>

                    {{-- Prix --}}
                    <div class="prix-container mb-4">
                        <span class="prix-label">
                            {{ $produit->isService() ? 'Tarif de la prestation' : 'Prix' }}
                        </span>
                        <div class="prix-value">
                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                        </div>
                    </div>

                    {{-- Stock OU Infos Service --}}
                    @if($produit->isProduit())
                        {{-- Pour les PRODUITS : afficher le stock --}}
                        <div class="mb-4">
                            <i class="bi bi-box-seam text-muted"></i>
                            <span class="{{ $produit->stock > 0 ? 'text-success' : 'text-danger' }}">
                                @if($produit->stock > 10)
                                    En stock ({{ $produit->stock }} disponibles)
                                @elseif($produit->stock > 0)
                                    Plus que {{ $produit->stock }} en stock !
                                @else
                                    Rupture de stock
                                @endif
                            </span>
                        </div>
                    @else
                        {{-- Pour les SERVICES : afficher les infos spécifiques --}}
                        <div class="service-info mb-4">
                            @if($produit->duree_minutes)
                                <div class="info-item mb-2">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span class="ms-2">
                                        <strong>Durée :</strong> {{ $produit->duree_minutes }} minutes
                                    </span>
                                </div>
                            @endif
                            
                            @if($produit->lieu_prestation)
                                <div class="info-item mb-2">
                                    <i class="bi bi-geo-alt text-danger"></i>
                                    <span class="ms-2">
                                        <strong>Lieu :</strong> {{ $produit->lieu_prestation }}
                                    </span>
                                </div>
                            @endif
                            
                            <div class="info-item mb-2">
                                <i class="bi bi-calendar-check text-success"></i>
                                <span class="ms-2">
                                    <strong>Disponibilité :</strong> 
                                    @if($produit->sur_rdv)
                                        Sur rendez-vous uniquement
                                    @else
                                        Disponible
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Description --}}
                    <div class="description-container mb-4">
                        <h5 class="section-title">
                            <i class="bi bi-info-circle"></i> 
                            {{ $produit->isService() ? 'Description de la prestation' : 'Description' }}
                        </h5>
                        <p class="description-text">{{ $produit->description }}</p>
                    </div>

                    {{-- Informations Artisan --}}
                    @if($produit->artisan && $produit->artisan->user)
                        <div class="artisan-card mb-4">
                            <h5 class="section-title">
                                <i class="bi bi-person-circle"></i> 
                                {{ $produit->isService() ? 'Prestataire' : 'Artisan' }}
                            </h5>
                            <div class="artisan-info">
                                <div class="artisan-avatar">
                                    @if($produit->artisan->user->avatar)
                                        <img src="{{ asset('storage/' . $produit->artisan->user->avatar) }}" 
                                             alt="{{ $produit->artisan->user->name }}">
                                    @else
                                        <div class="avatar-placeholder">
                                            {{ strtoupper(substr($produit->artisan->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="artisan-details">
                                    <h6 class="mb-1">{{ $produit->artisan->user->name }}</h6>
                                    <p class="mb-1 text-muted small">
                                        <i class="bi bi-tools"></i> {{ $produit->artisan->specialite ?? 'Artisan' }}
                                    </p>
                                    @if($produit->artisan->ville)
                                        <p class="mb-0 text-muted small">
                                            <i class="bi bi-geo-alt"></i> {{ $produit->artisan->ville }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Boutons d'action --}}
                    <div class="actions-container mt-4">
                        @auth
                            @php
                                $user = auth()->user();
                                $peutCommander = !$user->is_admin 
                                                && $user->role !== 'artisan'
                                                && strtolower(trim($user->role)) === 'client';
                            @endphp
                            
                            @if($peutCommander)
                                @if($produit->isService())
                                    {{-- Pour les SERVICES : Bouton Prendre rendez-vous --}}
                                    <a href="{{ route('client.rendez_vous.create', $produit) }}" 
                                       class="btn btn-service btn-lg w-100 mb-2 fw-bold shadow-sm">
                                        <i class="bi bi-calendar-plus me-2"></i>Prendre rendez-vous
                                    </a>
                                    <p class="text-center text-muted small mb-3">
                                        <i class="bi bi-info-circle me-1"></i>
                                        L'artisan vous contactera pour confirmer le rendez-vous
                                    </p>
                                @else
                                    {{-- Pour les PRODUITS : Bouton Commander --}}
                                    @if($produit->stock > 0)
                                        <a href="{{ route('commande.create', $produit) }}" 
                                           class="btn btn-warning btn-lg w-100 mb-2 fw-bold shadow-sm">
                                            <i class="bi bi-cart-plus me-2"></i>Commander ce produit
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-lg w-100 mb-2 fw-bold shadow-sm" disabled>
                                            <i class="bi bi-x-circle me-2"></i>Rupture de stock
                                        </button>
                                    @endif
                                @endif
                                
                                {{-- Bouton Favoris (commun aux deux) --}}
                                <form action="{{ route('favoris.toggle', $produit) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn {{ $estFavori ? 'btn-danger' : 'btn-outline-danger' }} btn-lg w-100 mb-2 border-2">
                                        <i class="bi {{ $estFavori ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                                        {{ $estFavori ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                                    </button>
                                </form>
                                
                                {{-- Bouton Contacter --}}
                                <a href="{{ route('messages.createFromProduit', $produit) }}" class="btn btn-outline-primary btn-lg w-100 mb-2 border-2">
                                    <i class="bi bi-chat-dots me-2"></i>Contacter l'{{ $produit->isService() ? 'artisan' : 'artisan' }}
                                </a>
                            @elseif($user->role === 'artisan')
                                <div class="alert alert-info mb-2">
                                    <i class="bi bi-info-circle"></i> Vous êtes artisan, vous ne pouvez pas commander.
                                </div>
                            @elseif($user->is_admin)
                                <div class="alert alert-secondary mb-2">
                                    <i class="bi bi-shield-lock"></i> Connecté en tant qu'administrateur.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning text-center mb-2">
                                <i class="bi bi-person-check"></i>
                                <a href="{{ route('login') }}" class="alert-link">Connectez-vous</a> 
                                pour {{ $produit->isService() ? 'prendre rendez-vous' : 'commander' }} ou ajouter aux favoris
                            </div>
                        @endauth

                        {{-- ======================================== --}}
{{-- SECTION ACHAT : Panier ou Commande directe --}}
{{-- ======================================== --}}
@if(auth()->check() && auth()->user()->role === 'client')
    
    @if($produit->type === 'produit')
        {{-- Pour les PRODUITS : Ajouter au panier --}}
        <div class="card bg-light border-0 rounded-3 p-3 mb-3">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
            </h6>
            
            <form method="POST" action="{{ route('client.panier.ajouter', $produit) }}">
                @csrf
                
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small">Quantité</label>
                        <input type="number" 
                               name="quantite" 
                               value="1" 
                               min="1" 
                               max="{{ $produit->stock }}" 
                               class="form-control" 
                               required>
                    </div>
                    
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-cart-plus me-2"></i>
                            Ajouter au panier
                        </button>
                    </div>
                </div>
                
                <small class="text-muted mt-2 d-block">
                    <i class="bi bi-box-seam me-1"></i>Stock disponible : {{ $produit->stock }}
                </small>
            </form>
        </div>
    
    @else
        {{-- Pour les SERVICES : Bouton "Prendre rendez-vous" --}}
        <a href="{{ route('client.rendez_vous.create', $produit) }}" class="btn btn-primary w-100 mb-3">
            <i class="bi bi-calendar-check me-2"></i>Prendre rendez-vous
        </a>
    @endif

@else
    {{-- Si pas connecté --}}
    <a href="{{ route('login') }}" class="btn btn-warning w-100">
        <i class="bi bi-lock me-2"></i>Connectez-vous pour commander
    </a>
@endif


                        
                        {{-- Bouton Retour --}}
                        <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary w-100 border-2">
                            <i class="bi bi-arrow-left me-2"></i>Retour au catalogue
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ÉVALUATIONS --}}
        <div class="evaluations-section mt-5 pt-5">
            <h3 class="section-title-main mb-4">
                <i class="bi bi-star-fill text-warning"></i> Évaluations
                @if($totalEvaluations > 0)
                    <span class="badge bg-warning text-dark ms-2">
                        {{ number_format($noteMoyenne, 1) }} ⭐ ({{ $totalEvaluations }})
                    </span>
                @endif
            </h3>

            @if($evaluations->count() > 0)
                <div class="row g-3">
                    @foreach($evaluations as $eval)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong>{{ $eval->client->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $eval->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        <div>
                                            {!! $eval->etoiles_html !!}
                                        </div>
                                    </div>
                                    @if($eval->commentaire)
                                        <p class="text-muted mb-0">{{ $eval->commentaire }}</p>
                                    @else
                                        <p class="text-muted fst-italic mb-0">Pas de commentaire</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-chat-square-quote" style="font-size: 3rem; color: #ddd;"></i>
                    <p class="text-muted mt-2 mb-0">Aucune évaluation pour ce {{ $produit->isService() ? 'service' : 'produit' }}</p>
                    <p class="text-muted small">Soyez le premier à donner votre avis !</p>
                </div>
            @endif
        </div>

        {{-- Produits/Services similaires --}}
        @if($produitsSimilaires && $produitsSimilaires->count() > 0)
            <div class="produits-similaires mt-5 pt-5">
                <h3 class="section-title-main mb-4">
                    <i class="bi bi-stars"></i> 
                    {{ $produit->isService() ? 'Services similaires' : 'Produits similaires' }}
                </h3>
                <div class="row g-4">
                    @foreach($produitsSimilaires as $similaire)
                        <div class="col-lg-3 col-md-6">
                            <div class="produit-card-similaire {{ $similaire->isService() ? 'service-card' : '' }}">
                                <div class="produit-image-container">
                                    @if($similaire->image_principale)
                                        <img src="{{ $similaire->image_principale }}" 
                                             alt="{{ $similaire->nom }}" class="produit-image">
                                    @else
                                        <div class="produit-image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Badge type --}}
                                    <span class="produit-type-badge {{ $similaire->isService() ? 'badge-service' : 'badge-produit' }}">
                                        <i class="bi {{ $similaire->type_icon }} me-1"></i>
                                        {{ $similaire->isProduit() ? 'Produit' : 'Service' }}
                                    </span>
                                </div>
                                <div class="produit-content">
                                    <h6 class="produit-title">
                                        <a href="{{ route('produit.show', $similaire) }}" class="text-decoration-none">
                                            {{ $similaire->nom }}
                                        </a>
                                    </h6>
                                    <div class="produit-price">
                                        {{ number_format($similaire->prix, 0, ',', ' ') }} FCFA
                                    </div>
                                    @if($similaire->isService())
                                        <span class="badge-rdv mt-2 d-inline-block">
                                            <i class="bi bi-calendar-check me-1"></i>Sur RDV
                                        </span>
                                    @else
                                        <span class="badge-stock mt-2 d-inline-block">
                                            <i class="bi bi-box-seam me-1"></i>Stock: {{ $similaire->stock }}
                                        </span>
                                    @endif
                                    <a href="{{ route('produit.show', $similaire) }}" class="btn btn-sm btn-outline-madin mt-2">
                                        Voir le détail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .produit-detail-section {
        background: #fafafa;
        padding-top: 100px !important;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: var(--secondary-color);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #666;
    }

    /* Galerie */
    .galerie-container {
        background: white;
        padding: 1.5rem;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }

    .image-principale {
        border-radius: 15px;
        overflow: hidden;
        background: #f0f0f0;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-principale img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
    }

    .image-placeholder {
        text-align: center;
        color: #bbb;
        padding: 3rem;
    }

    .image-placeholder i {
        font-size: 5rem;
    }

    .miniature {
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .miniature:hover {
        border-color: var(--secondary-color);
    }

    .miniature.active {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 2px rgba(210, 105, 30, 0.3);
    }

    /* Informations */
    .info-container {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }

    /* Badges type */
    .type-badge {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .type-produit {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
    }

    .type-service {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
    }

    .produit-nom {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 2rem;
        line-height: 1.2;
    }

    .prix-container {
        background: linear-gradient(135deg, #fff8f0, #fff);
        padding: 1.5rem;
        border-radius: 15px;
        border-left: 4px solid var(--secondary-color);
    }

    .prix-label {
        display: block;
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 0.3rem;
    }

    .prix-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    /* Infos service */
    .service-info {
        background: rgba(59, 130, 246, 0.05);
        padding: 1.2rem;
        border-radius: 12px;
        border-left: 3px solid #3B82F6;
    }

    .info-item {
        display: flex;
        align-items: center;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .description-text {
        color: #555;
        line-height: 1.8;
        font-size: 0.95rem;
    }

    /* Artisan card */
    .artisan-card {
        background: #fafafa;
        padding: 1.5rem;
        border-radius: 15px;
        border: 1px solid #f0f0f0;
    }

    .artisan-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .artisan-avatar {
        flex-shrink: 0;
    }

    .artisan-avatar img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        border: 3px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .artisan-details h6 {
        color: var(--primary-color);
        font-weight: 600;
    }

    /* Boutons */
    .btn-madin {
        background: var(--secondary-color);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-madin:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-madin {
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        background: transparent;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-madin:hover {
        background: var(--secondary-color);
        color: white;
    }

    /* Bouton service */
    .btn-service {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-service:hover {
        background: linear-gradient(135deg, #2563EB, #1D4ED8);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
    }

    /* Badges stock/rdv */
    .badge-stock {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-rdv {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        padding: 0.3rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Produits similaires */
    .section-title-main {
        color: var(--primary-color);
        font-weight: 700;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title-main::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--secondary-color);
        border-radius: 2px;
    }

    .produit-card-similaire {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(139, 69, 19, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .service-card {
        border-left: 4px solid #3B82F6;
    }

    .produit-card-similaire:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(139, 69, 19, 0.15);
    }

    .produit-image-container {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .produit-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .produit-card-similaire:hover .produit-image {
        transform: scale(1.05);
    }

    .produit-type-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .badge-produit {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }

    .badge-service {
        background: rgba(59, 130, 246, 0.95);
        color: white;
    }

    .produit-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 3rem;
    }

    .produit-content {
        padding: 1rem;
    }

    .produit-title {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .produit-title a:hover {
        color: var(--secondary-color);
    }

    .produit-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--secondary-color);
    }
</style>
@endpush

@push('scripts')
<script>
    function changerImage(src, element) {
        // Changer l'image principale
        document.getElementById('mainImage').src = src;
        
        // Retirer la classe active de toutes les miniatures
        document.querySelectorAll('.miniature').forEach(mini => {
            mini.classList.remove('active');
        });
        
        // Ajouter la classe active à la miniature cliquée
        element.classList.add('active');
    }
</script>
@endpush