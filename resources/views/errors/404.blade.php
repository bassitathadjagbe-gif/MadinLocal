@extends('layouts.app')

@section('title', 'Page non trouvée')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 style="font-size: 8rem; color: var(--terracotta);">404</h1>
                <h2 class="mb-4">Page non trouvée</h2>
                <p class="text-muted mb-4">
                    La page que vous recherchez n'existe pas ou a été déplacée.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-artisan">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-artisan">
                        <i class="bi bi-house me-1"></i> Accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection