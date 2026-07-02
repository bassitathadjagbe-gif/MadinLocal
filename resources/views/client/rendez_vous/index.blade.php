@extends('layouts.app')

@section('title', 'Mes rendez-vous')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--primary-color);">
            <i class="bi bi-calendar3 me-2"></i>Mes rendez-vous
        </h2>
        <a href="{{ route('catalogue') }}" class="btn btn-outline-madin">
            <i class="bi bi-plus-circle me-2"></i>Prendre un RDV
        </a>
    </div>

    @if($rdvs->count() > 0)
        <div class="row g-4">
            @foreach($rdvs as $rdv)
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge {{ $rdv->statut_badge_class }} fs-6">
                                    {{ $rdv->statut_label }}
                                </span>
                                <small class="text-muted">#{{ $rdv->id }}</small>
                            </div>

                            <h5 class="fw-bold">{{ $rdv->service->nom }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-person me-1"></i>{{ $rdv->artisan->user->name }}
                            </p>

                            <div class="border-top pt-3">
                                <p class="mb-2">
                                    <i class="bi bi-calendar me-2 text-primary"></i>
                                    <strong>{{ $rdv->date_rdv->format('d/m/Y') }}</strong> à <strong>{{ $rdv->heure_rdv }}</strong>
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-geo-alt me-2 text-danger"></i>
                                    {{ $rdv->lieu }}
                                </p>
                                <p class="mb-0">
                                    <i class="bi bi-cash me-2 text-success"></i>
                                    <strong style="color: var(--secondary-color);">
                                        {{ number_format($rdv->montant, 0, ',', ' ') }} FCFA
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $rdvs->links() }}</div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucun rendez-vous</h4>
            <p class="text-muted">Vous n'avez pas encore pris de rendez-vous</p>
            <a href="{{ route('catalogue') }}" class="btn btn-madin mt-3">
                <i class="bi bi-search me-2"></i>Trouver un service
            </a>
        </div>
    @endif
</div>
@endsection