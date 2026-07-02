@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color: var(--primary-color);">
        <i class="bi bi-cart3 me-2"></i>Mon Panier
        @if($nombreArticles > 0)
            <small class="text-muted">({{ $nombreArticles }} article{{ $nombreArticles > 1 ? 's' : '' }})</small>
        @endif
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($panierItems->count() > 0)
        <div class="row">
            {{-- Liste des produits --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        @foreach($panierItems as $item)
                            <div class="row align-items-center mb-4 pb-4 border-bottom">
                                {{-- Image --}}
                                <div class="col-md-2">
                                    <img src="{{ $item->produit->image_principale ?? asset('images/placeholder.png') }}" 
                                         alt="{{ $item->produit->nom }}" 
                                         class="img-fluid rounded-3" 
                                         style="width: 100%; height: 100px; object-fit: cover;">
                                </div>
                                
                                {{-- Infos produit --}}
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-1">{{ $item->produit->nom }}</h6>
                                    <p class="text-muted mb-1 small">
                                        <i class="bi bi-person me-1"></i>{{ $item->produit->artisan->user->name ?? 'Artisan' }}
                                    </p>
                                    <p class="fw-bold mb-0" style="color: var(--secondary-color);">
                                        {{ number_format($item->produit->prix, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>

                                {{-- Quantité --}}
                                <div class="col-md-2">
                                    <form method="POST" action="{{ route('client.panier.update', $item) }}">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label small text-muted">Quantité</label>
                                        <input type="number" name="quantite" value="{{ $item->quantite }}" 
                                               min="1" max="{{ $item->produit->stock }}" 
                                               class="form-control form-control-sm text-center" 
                                               onchange="this.form.submit()">
                                    </form>
                                </div>

                                {{-- Sous-total --}}
                                <div class="col-md-2">
                                    <label class="form-label small text-muted">Sous-total</label>
                                    <p class="fw-bold mb-0 fs-6">
                                        {{ number_format($item->sous_total, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>

                                {{-- Actions --}}
                                <div class="col-md-2">
                                    <div class="d-flex flex-column gap-2">
                                        {{-- Bouton Commander --}}
                                        <form method="POST" action="{{ route('client.panier.commanderUn', $item) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100" 
                                                    onclick="return confirm('Commander ce produit ?')">
                                                <i class="bi bi-bag-check me-1"></i>Commander
                                            </button>
                                        </form>

                                        {{-- Bouton Supprimer --}}
                                        <form method="POST" action="{{ route('client.panier.supprimer', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                                    onclick="return confirm('Retirer ce produit ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions en bas --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                    </a>
                    <form method="POST" action="{{ route('client.panier.vider') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('Vider tout le panier ?')">
                            <i class="bi bi-trash3 me-2"></i>Vider le panier
                        </button>
                    </form>
                </div>
            </div>

            {{-- Résumé --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Résumé</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Livraison</span>
                            <span class="text-success">Gratuite</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5" style="color: var(--secondary-color);">
                                {{ number_format($total, 0, ',', ' ') }} FCFA
                            </strong>
                        </div>

                        <form method="POST" action="{{ route('client.panier.commander') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Commander tous les articles
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Votre panier est vide</h4>
            <p class="text-muted">Ajoutez des produits pour commencer vos achats</p>
            <a href="{{ route('catalogue') }}" class="btn btn-primary mt-3">
                <i class="bi bi-shop me-2"></i>Voir le catalogue
            </a>
        </div>
    @endif
</div>
@endsection