@extends('layouts.app')

@section('title', 'Accès refusé')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 style="font-size: 8rem; color: #EF4444;">403</h1>
                <h2 class="mb-4">Accès non autorisé</h2>
                <p class="text-muted mb-4">
                    Vous n'avez pas les permissions nécessaires pour accéder à cette page.
                </p>
                <a href="{{ route('home') }}" class="btn btn-artisan">
                    <i class="bi bi-house me-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
@endsection