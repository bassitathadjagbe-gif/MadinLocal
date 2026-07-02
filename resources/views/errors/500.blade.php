@extends('layouts.app')

@section('title', 'Erreur serveur')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 style="font-size: 8rem; color: #6B7280;">500</h1>
                <h2 class="mb-4">Erreur serveur</h2>
                <p class="text-muted mb-4">
                    Une erreur inattendue s'est produite. Veuillez réessayer plus tard.
                </p>
                <a href="{{ route('home') }}" class="btn btn-artisan">
                    <i class="bi bi-house me-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
@endsection