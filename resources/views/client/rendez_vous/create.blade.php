@extends('layouts.app')

@section('title', 'Prendre rendez-vous')

@section('content')
<div class="container py-5" style="padding-top: 120px !important;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- En-tête --}}
            <div class="mb-4">
                <a href="{{ route('produit.show', $service) }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i>Retour au service
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="bi bi-calendar-plus me-2"></i>Prendre rendez-vous
                    </h2>

                    {{-- Info du service --}}
                    <div class="alert alert-info rounded-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $service->nom }}</strong>
                                <br>
                                <small>Par {{ $service->artisan->user->name }}</small>
                            </div>
                            <div class="text-end">
                                <strong class="fs-5" style="color: var(--secondary-color);">
                                    {{ number_format($service->prix, 0, ',', ' ') }} FCFA
                                </strong>
                                @if($service->duree_minutes)
                                    <br><small class="text-muted">⏱️ {{ $service->duree_minutes }} min</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('client.rendez_vous.store', $service) }}">
                        @csrf

                        {{-- Date --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Date du rendez-vous *</label>
                            <input type="date" name="date_rdv" class="form-control form-control-lg" 
                                   value="{{ old('date_rdv') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- Heure --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Heure du rendez-vous *</label>
                            <input type="time" name="heure_rdv" class="form-control form-control-lg" 
                                   value="{{ old('heure_rdv') }}" required>
                        </div>

                        {{-- Lieu --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Lieu de la prestation *</label>
                            <select name="lieu" class="form-select form-select-lg" required>
                                <option value="">-- Choisir --</option>
                                <option value="Chez l'artisan" {{ old('lieu') == "Chez l'artisan" ? 'selected' : '' }}>
                                    🏪 Chez l'artisan ({{ $service->lieu_prestation ?? 'Adresse à confirmer' }})
                                </option>
                                <option value="À domicile" {{ old('lieu') == "À domicile" ? 'selected' : '' }}>
                                    🏠 À mon domicile (déplacement possible)
                                </option>
                                <option value="Autre" {{ old('lieu') == "Autre" ? 'selected' : '' }}>
                                    📍 Autre lieu (à préciser dans les notes)
                                </option>
                            </select>
                        </div>

                        {{-- Téléphone --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Téléphone de contact *</label>
                            <input type="tel" name="telephone_contact" class="form-control form-control-lg" 
                                   value="{{ old('telephone_contact', auth()->user()->telephone ?? '') }}" 
                                   placeholder="+229 XX XX XX XX" required>
                        </div>

                        {{-- Notes --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Notes supplémentaires</label>
                            <textarea name="notes" class="form-control" rows="3" 
                                      placeholder="Précisez vos attentes, préférences, etc.">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-madin px-4 btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Confirmer le rendez-vous
                            </button>
                            <a href="{{ route('produit.show', $service) }}" class="btn btn-outline-secondary px-4 btn-lg">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection