@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<section class="produit-form-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-card">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold" style="color: var(--primary-color);">
                                <i class="bi bi-pencil-square me-2"></i>Modifier le produit
                            </h2>
                            <p class="text-muted mb-0">Produit : <strong>{{ $produit->nom }}</strong></p>
                        </div>
                        <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-madin">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>

                    {{-- AFFICHAGE DES ERREURS --}}
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <h5 class="alert-heading">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Veuillez corriger les erreurs suivantes :
                            </h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('artisan.produits.update', $produit) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Informations générales -->
                        <div class="form-section mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-info-circle" style="color: var(--secondary-color);"></i>
                                Informations générales
                            </h5>

                            <div class="row g-3">
                                <!-- Nom -->
                                <div class="col-md-8">
                                    <label for="nom" class="form-label fw-semibold">
                                        Nom du produit <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nom') is-invalid @enderror"
                                           id="nom"
                                           name="nom"
                                           value="{{ old('nom', $produit->nom) }}"
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="col-md-4">
                                    <label for="type" class="form-label fw-semibold">
                                        Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('type') is-invalid @enderror"
                                            id="type"
                                            name="type"
                                            required>
                                        <option value="produit" {{ old('type', $produit->type) === 'produit' ? 'selected' : '' }}>📦 Produit</option>
                                        <option value="service" {{ old('type', $produit->type) === 'service' ? 'selected' : '' }}>🔧 Service</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Catégorie -->
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label fw-semibold">
                                        Catégorie <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id"
                                            name="category_id"
                                            required>
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $produit->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Prix -->
                                <div class="col-md-3">
                                    <label for="prix" class="form-label fw-semibold">
                                        Prix (FCFA) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('prix') is-invalid @enderror"
                                           id="prix"
                                           name="prix"
                                           value="{{ old('prix', $produit->prix) }}"
                                           min="0"
                                           required>
                                    @error('prix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="col-md-3">
                                    <label for="stock" class="form-label fw-semibold">
                                        Stock <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           id="stock"
                                           name="stock"
                                           value="{{ old('stock', $produit->stock) }}"
                                           min="0"
                                           required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">
                                        Description <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="5"
                                              required>{{ old('description', $produit->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- ✅ GESTION DES IMAGES --}}
                        <div class="form-section mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-images" style="color: var(--secondary-color);"></i>
                                Images du produit
                            </h5>
                            <p class="text-muted small">
                                Maximum 5 images au total (existantes + nouvelles). Cochez les images à supprimer.
                            </p>

{{--{{-- Images existantes --}}
@if($produit->images && count($produit->images) > 0)
    <div class="mb-4">
        <label class="form-label fw-semibold">Images actuelles :</label>
        <p class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i> Cochez les images que vous souhaitez supprimer
        </p>
        <div class="row g-3">
            @foreach($produit->images as $index => $image)
                <div class="col-md-3 col-6">
                    <div class="image-existing" id="image-container-{{ $index }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Produit" class="img-fluid">
                        
                        @if($index === 0)
                            <span class="image-badge">📸 Principale</span>
                        @endif
                        
                        {{-- Checkbox visible pour supprimer --}}
                        <button type="button" 
                                class="btn-delete-image" 
                                onclick="toggleDeleteImage({{ $index }}, '{{ $image }}')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                        
                        {{-- Input caché pour envoyer les images à supprimer --}}
                        <input type="hidden" 
                               name="delete_images[]" 
                               id="delete-input-{{ $index }}" 
                               value="">
                        
                        {{-- Badge de suppression --}}
                        <div class="delete-badge" id="delete-badge-{{ $index }}">
                            <i class="bi bi-x-circle"></i> Sera supprimée
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

                            {{-- Upload de nouvelles images --}}
                            <div class="mb-3">
                                <label for="new_images" class="form-label fw-semibold">
                                    Ajouter de nouvelles images
                                </label>
                                <input type="file"
                                       class="form-control @error('new_images') is-invalid @enderror"
                                       id="new_images"
                                       name="new_images[]"
                                       multiple
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted">
                                    Vous pouvez ajouter jusqu'à {{ 5 - count($produit->images ?? []) }} nouvelle(s) image(s)
                                </small>
                                @error('new_images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('new_images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview des nouvelles images --}}
                            <div class="row g-2 mt-2" id="newImagesPreview"></div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-madin flex-grow-1 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                            </button>
                            <a href="{{ route('artisan.produits.index') }}" class="btn btn-outline-madin btn-lg">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .produit-form-section {
        background: #fafafa;
        padding-top: 100px !important;
    }

   .form-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 5px 25px rgba(139, 69, 19, 0.08);
    }


    .form-section {
        background: #fafafa;
        padding: 1.5rem;
        border-radius: 15px;
    }

 .image-existing {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

   .image-existing:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .image-existing img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }
    .btn-delete-image {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(220, 53, 69, 0.95);
        color: white;
        border: none;
        padding: 0.6rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }
    .btn-delete-image:hover {
        background: rgba(220, 53, 69, 1);
        padding: 0.7rem;
    }
     .image-existing.marked-for-deletion img {
        opacity: 0.4;
    }
    .image-existing.marked-for-deletion .btn-delete-image {
        background: rgba(40, 167, 69, 0.95);
    }

    .image-existing.marked-for-deletion .btn-delete-image:hover {
        background: rgba(40, 167, 69, 1);
    }
     /* Badge de suppression */
    .delete-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(220, 53, 69, 0.95);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: none;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
     .image-existing.marked-for-deletion .delete-badge {
        display: flex;
    }

    .image-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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

    .new-image-preview {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
     .new-image-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .new-image-preview .badge-new {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #28a745;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
    }

    .image-checkbox {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(220, 53, 69, 0.9);
        padding: 0.5rem;
        text-align: center;
    }

    .image-checkbox input[type="checkbox"] {
        display: none;
    }

    .image-checkbox label {
        color: white;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .image-checkbox label:hover {
        color: #ffcdd2;
    }

    .image-existing input[type="checkbox"]:checked + label {
        color: #fff;
    }

    .image-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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

    .new-image-preview {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .new-image-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .new-image-preview .badge-new {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #28a745;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction pour toggle la suppression d'image
    function toggleDeleteImage(index, imagePath) {
        const container = document.getElementById(`image-container-${index}`);
        const input = document.getElementById(`delete-input-${index}`);
        
        if (container.classList.contains('marked-for-deletion')) {
            // Désélectionner
            container.classList.remove('marked-for-deletion');
            input.value = '';
        } else {
            // Sélectionner pour suppression
            container.classList.add('marked-for-deletion');
            input.value = imagePath;
        }
    }

    // Preview des nouvelles images
    document.getElementById('new_images').addEventListener('change', function(e) {
        const preview = document.getElementById('newImagesPreview');
        preview.innerHTML = '';

        const files = Array.from(e.target.files);
        const maxImages = {{ 5 - count($produit->images ?? []) }};

        if (files.length > maxImages) {
            alert(`Vous ne pouvez ajouter que ${maxImages} image(s) supplémentaire(s)`);
            this.value = '';
            return;
        }

        files.forEach((file, index) => {
            if (file.size > 2 * 1024 * 1024) {
                alert(`${file.name} dépasse 2 Mo`);
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-6';
                col.innerHTML = `
                    <div class="new-image-preview">
                        <img src="${e.target.result}" alt="Nouvelle image">
                        <span class="badge-new">✨ Nouvelle</span>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush