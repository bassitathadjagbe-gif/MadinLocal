@extends('layouts.app')

@section('title', 'Validation des Artisans')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-tools me-2"></i>Artisans en attente de validation
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($artisans->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Artisan</th>
                            <th>Spécialité</th>
                            <th>Ville</th>
                            <th>Date d'inscription</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($artisans as $artisan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <span class="text-primary fw-bold">{{ substr($artisan->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <strong>{{ $artisan->user->name }}</strong><br>
                                            <small class="text-muted">{{ $artisan->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $artisan->specialite }}</td>
                                <td><i class="bi bi-geo-alt me-1"></i>{{ $artisan->ville }}</td>
                                <td>{{ $artisan->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.artisans.valider', $artisan) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" 
                                                onclick="return confirm('Valider cet artisan ? Il sera visible par les investisseurs.')">
                                            <i class="bi bi-check-lg me-1"></i>Valider
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $artisans->links() }}</div>
    @else
        <div class="text-center py-5 bg-white rounded shadow-sm">
            <i class="bi bi-check-circle" style="font-size: 4rem; color: #28a745;"></i>
            <h4 class="mt-3">Tous les artisans sont validés !</h4>
            <p class="text-muted">Aucun compte artisan en attente de vérification.</p>
        </div>
    @endif
</div>
@endsection