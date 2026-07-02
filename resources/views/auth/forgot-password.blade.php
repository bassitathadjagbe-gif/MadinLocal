@extends('layouts.guest')

@section('title', 'Mot de passe oublié')

@section('content')
<section class="py-5" style="padding-top: 120px !important; background: #fafafa; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-key-fill text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold" style="color: var(--primary-color);">Mot de passe oublié ?</h3>
                            <p class="text-muted small">Entrez votre email pour recevoir un lien de réinitialisation.</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 ps-0" value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-madin w-100 py-3 fw-bold mb-3">
                                <i class="bi bi-send me-2"></i>Envoyer le lien
                            </button>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none small">
                                    <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
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