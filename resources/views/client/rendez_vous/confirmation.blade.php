@extends('layouts.app')

@section('title', 'Rendez-vous confirmé')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-calendar-check-fill" style="font-size: 5rem; color: #10B981;"></i>
                    </div>
                    <h2 class="fw-bold mb-3" style="color: var(--primary-color);">Rendez-vous enregistré !</h2>
                    <p class="text-muted mb-4">Votre demande a été envoyée à l'artisan. Vous recevrez une confirmation sous peu.</p>

                    <div class="bg-light rounded-3 p-4 mb-4 text-start">
                        <div class="row g-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Service</small>
                                <strong>{{ $rdv->service->nom }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Artisan</small>
                                <strong>{{ $rdv->artisan->user->name }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Date</small>
                                <strong>{{ $rdv->date_rdv->format('d/m/Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Heure</small>
                                <strong>{{ $rdv->heure_rdv }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Lieu</small>
                                <strong>{{ $rdv->lieu }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Montant</small>
                                <strong style="color: var(--secondary-color);">
                                    {{ number_format($rdv->montant, 0, ',', ' ') }} FCFA
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info text-start">
                        <i class="bi bi-info-circle me-2"></i>
                        L'artisan va vous contacter au <strong>{{ $rdv->telephone_contact }}</strong> pour confirmer le rendez-vous.
                    </div>

                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-house me-2"></i>Accueil
                        </a>
                        <a href="{{ route('client.rendez_vous.index') }}" class="btn btn-madin rounded-pill px-4">
                            <i class="bi bi-calendar me-2"></i>Voir mes rendez-vous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection