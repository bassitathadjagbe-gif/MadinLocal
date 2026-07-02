@extends('layouts.guest')
@section('title', 'Inscription')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 90px);
        display: flex;
        align-items: center;
        padding: 3rem 0;
    }

    .auth-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(44, 62, 80, 0.15);
        max-width: 600px;
        margin: 0 auto;
        padding: 3rem;
    }

    .auth-card h2 {
        font-size: 2rem;
        color: var(--indigo);
        margin-bottom: 0.5rem;
    }

    .role-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin: 1.5rem 0;
    }

    .role-card {
        padding: 1.25rem 1rem;
        border: 2px solid rgba(44, 62, 80, 0.1);
        border-radius: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .role-card:hover {
        border-color: var(--terracotta);
        transform: translateY(-3px);
    }

    .role-card.selected {
        border-color: var(--terracotta);
        background: linear-gradient(135deg, rgba(160, 82, 45, 0.05), rgba(201, 169, 97, 0.05));
    }

    .role-card i {
        font-size: 2rem;
        color: var(--terracotta);
        margin-bottom: 0.5rem;
    }

    .role-card h6 {
        margin: 0;
        color: var(--indigo);
        font-size: 0.9rem;
    }

    .role-card small {
        color: var(--muted);
        font-size: 0.75rem;
    }

    .input-group-artisan {
        position: relative;
        margin-bottom: 1rem;
    }

    .input-group-artisan i {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
    }

    .input-group-artisan input, .input-group-artisan select {
        width: 100%;
        padding: 0.85rem 1rem 0.85rem 3rem;
        border: 1.5px solid rgba(44, 62, 80, 0.12);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
        background: white;
    }

    .input-group-artisan input:focus, .input-group-artisan select:focus {
        outline: none;
        border-color: var(--terracotta);
        box-shadow: 0 0 0 4px rgba(160, 82, 45, 0.1);
    }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        color: var(--muted);
        font-size: 0.9rem;
    }

    .auth-footer a {
        color: var(--terracotta);
        font-weight: 600;
        text-decoration: none;
    }

    /* Avatar Upload */
    .avatar-upload-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem;
        background: #fafafa;
        border-radius: 15px;
        border: 2px dashed #e0e0e0;
        transition: all 0.3s ease;
    }

    .avatar-upload-container:hover {
        border-color: var(--secondary-color);
        background: #fff8f0;
    }

    .avatar-preview {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid white;
        box-shadow: 0 4px 15px rgba(210, 105, 30, 0.2);
    }

    .avatar-preview i {
        font-size: 2.5rem;
        color: white;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')

<div class="auth-wrapper">
    <div class="container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <h2 class="serif">Créer un compte</h2>
                <p class="text-muted">Rejoignez la communauté MadinLocal</p>
            </div>

            <label class="form-label-artisan text-center d-block">Je suis :</label>
            <div class="role-selector">
                <div class="role-card selected" onclick="selectRole(this)">
                    <i class="bi bi-person-fill"></i>
                    <h6>Client</h6>
                    <small>Je découvre</small>
                </div>
                <div class="role-card" onclick="selectRole(this)">
                    <i class="bi bi-tools"></i>
                    <h6>Artisan</h6>
                    <small>Je vends</small>
                </div>
                <div class="role-card" onclick="selectRole(this)">
                    <i class="bi bi-briefcase-fill"></i>
                    <h6>Investisseur</h6>
                    <small>Je finance</small>
                </div>
            </div>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="input-group-artisan">
                            <i class="bi bi-person"></i>
                            <input type="text" name="first_name" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-artisan">
                            <i class="bi bi-person"></i>
                            <input type="text" name="last_name" placeholder="Nom" required>
                        </div>
                    </div>
                </div>

                <div class="input-group-artisan">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" placeholder="Adresse email" required>
                </div>

                <div class="input-group-artisan">
                    <i class="bi bi-telephone"></i>
                    <input type="tel" name="phone" placeholder="Téléphone (+229...)" required>
                </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Role
                            </label>

                            <select name="role"
                                    class="form-select">
                                  <option value="client" selected>Client</option>                                  
                                  <option value="artisan">Artisan</option>
                                  <option value="investisseur">investisseur</option>  
                            </select>
                        </div>

                    <!-- Avatar / Photo de profil -->
<div class="mb-4">
    <label class="form-label fw-semibold d-block">
        <i class="bi bi-camera me-2" style="color: var(--secondary-color);"></i>
        Photo de profil <span class="text-muted small">(optionnel)</span>
    </label>
    
    <div class="avatar-upload-container">
        <div class="avatar-preview" id="avatarPreview">
            <i class="bi bi-person-fill" id="avatarPlaceholder"></i>
            <img id="avatarImage" src="" alt="Preview" style="display: none;">
        </div>
        <div class="avatar-upload-info">
            <label for="avatar" class="btn btn-outline-madin btn-sm mb-2">
                <i class="bi bi-upload me-2"></i>Choisir une photo
            </label>
            <input type="file" 
                   class="d-none" 
                   id="avatar" 
                   name="avatar" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   onchange="previewAvatar(this)">
            <small class="text-muted d-block">
                <i class="bi bi-info-circle"></i> JPG, PNG ou WebP. Max 2 Mo.
            </small>
        </div>
    </div>
    @error('avatar')
        <div class="text-danger small mt-2">
            <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
    @enderror

</div>

                <div class="input-group-artisan">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <div class="input-group-artisan">
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                </div>

                <label class="d-flex align-items-start gap-2 mb-3" style="font-size:0.85rem; cursor:pointer; color:var(--muted);">
                    <input type="checkbox" class="mt-1" name="terms" required>
                    <span>J'accepte les <a href="/conditions" style="color:var(--terracotta);">conditions d'utilisation</a> et la <a href="confidentialite" style="color:var(--terracotta);">politique de confidentialité</a></span>
                </label>

                <button type="submit" class="btn btn-artisan w-100" style="justify-content:center; padding:1rem;">
                    <span>Créer mon compte</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                Déjà un compte ? <a href="/connexion">Se connecter</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function selectRole(el) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }
    // ... ton JS existant ...

    function previewAvatar(input) {
        const file = input.files[0];
        if (file) {
            // Vérifier la taille (max 2 Mo)
            if (file.size > 2 * 1024 * 1024) {
                alert('L\'image ne doit pas dépasser 2 Mo');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatarImage');
                const placeholder = document.getElementById('avatarPlaceholder');
                img.src = e.target.result;
                img.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
