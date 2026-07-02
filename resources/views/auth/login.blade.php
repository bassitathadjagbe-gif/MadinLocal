@extends('layouts.guest')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-10"> {{-- Réduit de col-lg-6 à col-lg-5 --}}
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-2" style="color: var(--indigo, #2C3E50);">Connexion</h2>
                        <p class="text-muted mb-0">Heureux de vous revoir !</p>
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

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--indigo, #2C3E50);">
                                <i class="bi bi-envelope me-2"></i>Adresse email
                            </label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-3" 
                                   value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: var(--indigo, #2C3E50);">
                                <i class="bi bi-lock me-2"></i>Mot de passe
                            </label>
                            <input type="password" name="password" class="form-control form-control-lg rounded-3" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--terracotta, #A0522D);">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 rounded-3 fw-semibold" 
                                style="background: linear-gradient(135deg, var(--indigo, #2C3E50), var(--terracotta, #A0522D)); color: white;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>

                        {{-- OU CONNEXION SOCIALE --}}
<div class="text-center my-4">
    <p class="text-muted mb-3">ou continuer avec</p>
    <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary btn-lg w-100 rounded-3">
        <i class="bi bi-google me-2" style="color: #DB4437;"></i>
        Se connecter avec Google
    </a>
</div>

<hr class="my-4">
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Pas encore de compte ? 
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: var(--terracotta, #A0522D);">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .auth-section {
        background: linear-gradient(135deg, rgba(139, 69, 19, 0.05) 0%, rgba(255, 140, 0, 0.05) 100%);
        padding-top: 100px !important;
    }

    .auth-card {
        border-radius: 25px;
        background: white;
    }

    .auth-brand-side {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        position: relative;
        overflow: hidden;
    }

    .auth-brand-side::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .input-group-text {
        color: var(--secondary-color);
        border-color: #e0e0e0;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border-color: #e0e0e0;
    }

    .form-control:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.2rem rgba(210, 105, 30, 0.15);
    }

    .form-check-input:checked {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
@endpush