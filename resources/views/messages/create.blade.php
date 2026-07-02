@extends('layouts.app')

@section('title', 'Contacter ' . $artisan->name)

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa;">
    <div class="container">
        <div class="row justify-content-center">
           <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">
                <i class="bi bi-chat-dots me-2"></i>Contacter l'artisan
            </h3>
            <div class="d-flex gap-2">
                {{-- ✅ Bouton Retour au Dashboard --}}
                <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                </a>
                {{-- Bouton Retour au produit --}}
                <a href="{{ route('produit.show', $produit) }}" class="btn btn-outline-madin btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour au produit
                </a>
            </div>
        </div>
    </div>
                    <div class="card-body p-4">
                        {{-- Info produit --}}
                        <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-3">
                            @if($produit->image_principale)
                                <img src="{{ $produit->image_principale }}" 
                                     style="width: 80px; height: 80px; object-fit: cover;" 
                                     class="rounded">
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $produit->nom }}</h6>
                                <p class="text-muted small mb-1">
                                    <i class="bi bi-person"></i> {{ $artisan->name }}
                                </p>
                                <h6 class="fw-bold text-primary mb-0">
                                    {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                </h6>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('messages.store', $artisan->id) }}">
                            @csrf
                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                            <div class="mb-3">
    <label class="form-label fw-semibold">Sujet</label>
    <input type="text" name="sujet" class="form-control" 
           value="Question à propos de : {{ $produit->nom }}" required>
</div>

                            <div class="mb-3">
                              <label class="form-label fw-semibold">Votre message</label>
                                <textarea name="contenu" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-madin btn-lg flex-grow-1">
                                    <i class="bi bi-send me-2"></i>Envoyer le message
                                </button>
                                <a href="{{ route('produit.show', $produit) }}" class="btn btn-outline-secondary btn-lg">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection