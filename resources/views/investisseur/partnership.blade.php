@extends('layouts.investor')
@section('title', 'Devenir partenaire')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Devenir partenaire</h1>
        <p class="page-subtitle">Rejoignez l'aventure MadinLocal en tant qu'investisseur</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-artisan">
            <h4 class="serif mb-3">Formulaire de partenariat</h4>
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-artisan">Nom complet *</label>
                        <input type="text" class="form-control-artisan" placeholder="Votre nom">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Entreprise / Organisation</label>
                        <input type="text" class="form-control-artisan" placeholder="Nom de votre entreprise">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Email *</label>
                        <input type="email" class="form-control-artisan" placeholder="email@exemple.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Téléphone *</label>
                        <input type="tel" class="form-control-artisan" placeholder="+229...">
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Type de partenariat souhaité *</label>
                        <select class="form-select-artisan">
                            <option>Sélectionner...</option>
                            <option>Investissement financier</option>
                            <option>Partenariat stratégique</option>
                            <option>Sponsoring d'artisans</option>
                            <option>Autre</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Budget indicatif</label>
                        <select class="form-select-artisan">
                            <option>Sélectionner une fourchette</option>
                            <option>500 000 - 1 000 000 F</option>
                            <option>1 000 000 - 5 000 000 F</option>
                            <option>5 000 000 - 10 000 000 F</option>
                            <option>Plus de 10 000 000 F</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Votre message *</label>
                        <textarea class="form-control-artisan" rows="5" placeholder="Décrivez votre projet, vos motivations..."></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-artisan mt-3"><i class="bi bi-send"></i> Envoyer ma demande</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-artisan mb-3" style="background:linear-gradient(135deg, var(--indigo), var(--terracotta)); color:white;">
            <h4 class="serif mb-3">💡 Pourquoi investir ?</h4>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle-fill" style="color:var(--gold);"></i> Impact social direct</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill" style="color:var(--gold);"></i> Secteur en croissance</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill" style="color:var(--gold);"></i> Valorisation culturelle</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill" style="color:var(--gold);"></i> Réseau d'artisans vérifiés</li>
            </ul>
        </div>

        <div class="card-artisan">
            <h5 class="serif mb-3">📞 Contact direct</h5>
            <p class="text-muted small">Vous préférez échanger directement ?</p>
            <ul class="list-unstyled" style="color:var(--muted);">
                <li class="mb-2"><i class="bi bi-telephone" style="color:var(--terracotta);"></i> +229 90 00 00 00</li>
                <li class="mb-2"><i class="bi bi-envelope" style="color:var(--terracotta);"></i> contact@madinlocal.bj</li>
            </ul>
        </div>
    </div>
</div>

@endsection
