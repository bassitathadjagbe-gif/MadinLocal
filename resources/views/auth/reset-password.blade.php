@extends('layouts.guest')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<section class="py-5" style="padding-top: 120px !important; background: #fafafa; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-shield-lock-fill text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold" style="color: var(--primary-color);">Nouveau mot de passe</h3>
                            <p class="text-muted small">Choisissez un mot de passe sécurisé.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Adresse email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $email) }}" required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <small class="text-muted">Minimum 8 caractères</small>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-madin w-100 py-3 fw-bold">
                                <i class="bi bi-check-circle me-2"></i>Réinitialiser le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection