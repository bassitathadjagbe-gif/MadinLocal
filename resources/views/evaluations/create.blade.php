@extends('layouts.app')

@section('title', 'Évaluer la commande')

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">
                                <i class="bi bi-star-fill text-warning me-2"></i>Évaluer votre commande
                            </h3>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        {{-- Résumé de la commande --}}
                        <div class="d-flex gap-3 mb-4 p-3 bg-light rounded-3">
                            @if($commande->produit && $commande->produit->image_principale)
                                <img src="{{ $commande->produit->image_principale }}" 
                                     style="width: 80px; height: 80px; object-fit: cover;" 
                                     class="rounded">
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1">{{ $commande->produit->nom ?? 'Produit supprimé' }}</h6>
                                <p class="text-muted small mb-1">
                                    <i class="bi bi-person"></i> {{ $commande->artisan->user->name ?? 'Artisan' }}
                                </p>
                                <p class="text-muted small mb-0">
                                    Quantité : {{ $commande->quantite }} | 
                                    Total : <strong>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</strong>
                                </p>
                            </div>
                        </div>

                        {{-- Messages d'erreur --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('evaluations.store', $commande) }}">
                            @csrf

                            {{-- Note avec étoiles cliquables --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Votre note *</label>
                                <div class="rating-stars mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star rating-star" 
                                           data-value="{{ $i }}" 
                                           style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="note" id="noteInput" value="{{ old('note', 5) }}" required>
                                <p class="text-muted small mb-0" id="noteText">Cliquez sur les étoiles pour noter</p>
                            </div>

                            {{-- Commentaire --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Commentaire (optionnel)</label>
                                <textarea name="commentaire" 
                                          class="form-control" 
                                          rows="4" 
                                          placeholder="Partagez votre expérience avec cet artisan...">{{ old('commentaire') }}</textarea>
                                <small class="text-muted">Maximum 1000 caractères</small>
                            </div>

                            {{-- Boutons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning btn-lg flex-grow-1 fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Publier mon évaluation
                                </button>
                                <a href="{{ route('client.commandes.index') }}" class="btn btn-outline-secondary btn-lg">
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

@push('styles')
<style>
    .rating-star {
        transition: all 0.2s ease;
    }
    
    .rating-star:hover {
        transform: scale(1.2);
    }
    
    .rating-star.active {
        color: #ffc107 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    const stars = document.querySelectorAll('.rating-star');
    const noteInput = document.getElementById('noteInput');
    const noteText = document.getElementById('noteText');
    
    const textes = {
        1: '😞 Très insatisfait',
        2: '😕 Insatisfait',
        3: '😐 Correct',
        4: '😊 Satisfait',
        5: '🤩 Très satisfait'
    };

    function updateStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.classList.add('active');
                star.classList.remove('bi-star');
                star.classList.add('bi-star-fill');
            } else {
                star.classList.remove('active');
                star.classList.remove('bi-star-fill');
                star.classList.add('bi-star');
            }
        });
        noteText.textContent = textes[value] || '';
    }

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            noteInput.value = value;
            updateStars(value);
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            updateStars(value);
        });
    });

    document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
        updateStars(parseInt(noteInput.value));
    });

    // Initialisation
    updateStars(parseInt(noteInput.value) || 5);
</script>
@endpush