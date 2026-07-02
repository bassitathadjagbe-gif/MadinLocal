@extends('layouts.app')

@section('title', 'Ajouter un produit ou service')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="bi bi-plus-circle me-2"></i>
                        Ajouter un {{ isset($produit) ? 'produit' : 'nouveau produit ou service' }}
                    </h2>

                    <form method="POST" 
                          action="{{ isset($produit) ? route('artisan.produits.update', $produit) : route('artisan.produits.store') }}" 
                          enctype="multipart/form-data" 
                          id="produitForm">
                        @csrf
                        @if(isset($produit))
                            @method('PUT')
                        @endif

                        {{-- ===== TYPE (PRODUIT OU SERVICE) ===== --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Type d'offre *</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="type" id="type_produit" value="produit" 
                                           {{ (!isset($produit) || $produit->type === 'produit') ? 'checked' : '' }} required>
                                    <label class="btn btn-outline-success w-100 p-3" for="type_produit">
                                        <i class="bi bi-box-seam d-block mb-2" style="font-size: 2rem;"></i>
                                        <strong>Produit physique</strong>
                                        <small class="d-block text-muted">Objet à vendre (sculpture, vêtement...)</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="type" id="type_service" value="service" 
                                           {{ (isset($produit) && $produit->type === 'service') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 p-3" for="type_service">
                                        <i class="bi bi-clock d-block mb-2" style="font-size: 2rem;"></i>
                                        <strong>Service / Prestation</strong>
                                        <small class="d-block text-muted">Coiffure, soin, consultation...</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ===== CHAMPS COMMUNS ===== --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom *</label>
                            <input type="text" name="nom" class="form-control" required 
                                   placeholder="{{ isset($produit) && $produit->type === 'service' ? 'Ex: Tresses africaines' : 'Ex: Masque traditionnel' }}"
                                   value="{{ old('nom', $produit->nom ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catégorie *</label>
                           <select name="categorie_id" class="form-control" required>
    @foreach($categories as $categorie)
        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
    @endforeach
    <option value="autre">Autre (préciser dans la description)</option>
</select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description *</label>
                            <textarea name="description" class="form-control" rows="4" required 
                                      placeholder="Décrivez votre {{ isset($produit) && $produit->type === 'service' ? 'prestation' : 'produit' }} en détail...">{{ old('description', $produit->description ?? '') }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Prix (FCFA) *</label>
                                <input type="number" name="prix" class="form-control" min="0" required 
                                       value="{{ old('prix', $produit->prix ?? '') }}"
                                       placeholder="Ex: 15000">
                            </div>

                            {{-- STOCK (seulement pour produits) --}}
                            <div class="col-md-6 champ-produit">
                                <label class="form-label fw-bold">Stock disponible *</label>
                                <input type="number" name="stock" class="form-control" min="0" 
                                       value="{{ old('stock', $produit->stock ?? 1) }}"
                                       placeholder="Ex: 5">
                                <small class="text-muted">Quantité disponible en stock</small>
                            </div>
                        </div>

                        {{-- ===== CHAMPS SPÉCIFIQUES AUX SERVICES ===== --}}
                        <div class="champ-service" style="display: none;">
                            <hr class="my-4">
                            <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                                <i class="bi bi-info-circle me-2"></i>Informations sur la prestation
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Durée de la prestation</label>
                                    <div class="input-group">
                                        <input type="number" name="duree_minutes" class="form-control" min="0" 
                                               value="{{ old('duree_minutes', $produit->duree_minutes ?? '') }}"
                                               placeholder="Ex: 60">
                                        <span class="input-group-text">minutes</span>
                                    </div>
                                    <small class="text-muted">Durée estimée de la prestation</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lieu de prestation</label>
                                    <input type="text" name="lieu_prestation" class="form-control" 
                                           value="{{ old('lieu_prestation', $produit->lieu_prestation ?? '') }}"
                                           placeholder="Ex: Salon de coiffure, Cotonou">
                                    <small class="text-muted">Où se déroule la prestation ?</small>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="sur_rdv" id="sur_rdv" value="1"
                                           {{ old('sur_rdv', $produit->sur_rdv ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sur_rdv">
                                        <strong>Sur rendez-vous uniquement</strong>
                                        <small class="d-block text-muted">Le client doit prendre rendez-vous avant</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ===== IMAGES ===== --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Images</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted">Vous pouvez sélectionner plusieurs images (JPG, PNG, max 5MB chacune)</small>
                        </div>

                        {{-- ===== PUBLICATION ===== --}}
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1"
                                   {{ old('is_published', $produit->is_published ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                <strong>Publier immédiatement</strong>
                                <small class="d-block text-muted">Le produit/service sera visible après validation par l'admin</small>
                            </label>
                        </div>

                        {{-- ===== BOUTONS ===== --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-madin px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ isset($produit) ? 'Mettre à jour' : 'Enregistrer' }}
                            </button>
                            <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Gestion de l'affichage conditionnel
    document.addEventListener('DOMContentLoaded', function() {
        const typeProduit = document.getElementById('type_produit');
        const typeService = document.getElementById('type_service');
        const champsProduit = document.querySelectorAll('.champ-produit');
        const champsService = document.querySelectorAll('.champ-service');

        function toggleChamps() {
            if (typeService.checked) {
                // Mode SERVICE : masquer stock, afficher durée/lieu/rdv
                champsProduit.forEach(el => el.style.display = 'none');
                champsService.forEach(el => el.style.display = 'block');
                
                // Rendre stock optionnel
                const stockInput = document.querySelector('input[name="stock"]');
                if (stockInput) {
                    stockInput.required = false;
                    stockInput.value = 0;
                }
            } else {
                // Mode PRODUIT : afficher stock, masquer durée/lieu/rdv
                champsProduit.forEach(el => el.style.display = 'block');
                champsService.forEach(el => el.style.display = 'none');
                
                // Rendre stock obligatoire
                const stockInput = document.querySelector('input[name="stock"]');
                if (stockInput) {
                    stockInput.required = true;
                }
            }
        }

        // Événements
        typeProduit.addEventListener('change', toggleChamps);
        typeService.addEventListener('change', toggleChamps);

        // Initialisation au chargement
        toggleChamps();
    });
</script>
@endpush
@endsection