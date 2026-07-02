@extends('layouts.artisan')
@section('title', 'Mon Profil')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Mon profil</h1>
        <p class="page-subtitle">Gérez vos informations personnelles et votre boutique</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-artisan text-center">
            <div style="position:relative; display:inline-block;">
                <img src="https://i.pravatar.cc/200?img=12" style="width:130px; height:130px; border-radius:30px; border:4px solid var(--gold); object-fit:cover;">
                <button style="position:absolute; bottom:-5px; right:-5px; width:40px; height:40px; border-radius:50%; background:var(--terracotta); color:white; border:3px solid white; cursor:pointer;"><i class="bi bi-camera"></i></button>
            </div>
            <h3 class="serif mt-3 mb-1">Kouadio Jean</h3>
            <p class="text-muted mb-2">Atelier Kpodji</p>
            <span class="badge-status badge-success">✓ Artisan vérifié</span>
            <div class="divider-ornament mx-auto my-3"></div>
            <div class="row g-2 text-start">
                <div class="col-6">
                    <small class="text-muted">Note moyenne</small>
                    <div><strong style="color:var(--gold);">★★★★★</strong> 4.9</div>
                </div>
                <div class="col-6">
                    <small class="text-muted">Membre depuis</small>
                    <div><strong>Jan 2023</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-artisan mb-3">
            <h4 class="serif mb-3">Informations personnelles</h4>
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-artisan">Prénom</label>
                        <input type="text" class="form-control-artisan" value="Kouadio">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Nom</label>
                        <input type="text" class="form-control-artisan" value="Jean">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Email</label>
                        <input type="email" class="form-control-artisan" value="contact@kpodji.bj">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Téléphone</label>
                        <input type="tel" class="form-control-artisan" value="+229 97 00 00 00">
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Adresse</label>
                        <input type="text" class="form-control-artisan" value="Quartier Zongo, Cotonou">
                    </div>
                </div>
            </form>
        </div>

        <div class="card-artisan mb-3">
            <h4 class="serif mb-3">Informations de la boutique</h4>
            <form>
                <div class="mb-3">
                    <label class="form-label-artisan">Nom de la boutique</label>
                    <input type="text" class="form-control-artisan" value="Atelier Kpodji">
                </div>
                <div class="mb-3">
                    <label class="form-label-artisan">Description</label>
                    <textarea class="form-control-artisan" rows="4">Fondé en 2015, notre atelier perpétue la tradition du tissage traditionnel béninois.</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-artisan">Catégorie principale</label>
                        <select class="form-select-artisan">
                            <option selected>Textile</option>
                            <option>Bois sculpté</option>
                            <option>Argile</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Année d'expérience</label>
                        <input type="number" class="form-control-artisan" value="10">
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button class="btn btn-outline-artisan">Annuler</button>
            <button class="btn btn-artisan"><i class="bi bi-check-circle"></i> Enregistrer</button>
        </div>
    </div>
</div>

@endsection
