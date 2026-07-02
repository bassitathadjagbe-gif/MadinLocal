@extends('layouts.client')
@section('title', 'Commander')

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Passer commande</h1>
        <p class="page-subtitle">Finalisez votre achat en toute sécurité</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-artisan mb-3">
            <h4 class="serif mb-3">Produit commandé</h4>
            <div class="d-flex gap-3 align-items-center p-3" style="background:var(--ivory); border-radius:16px;">
                <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=200" style="width:100px; height:100px; border-radius:12px; object-fit:cover;">
                <div style="flex:1;">
                    <h5 class="serif mb-1">Pagne tissé traditionnel</h5>
                    <p class="small text-muted mb-1">Par Atelier Kpodji • Cotonou</p>
                    <strong style="color:var(--terracotta); font-size:1.25rem;">25 000 F CFA</strong>
                </div>
            </div>
        </div>

        <div class="card-artisan mb-3">
            <h4 class="serif mb-3">Vos informations</h4>
            <form>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-artisan">Nom complet *</label>
                        <input type="text" class="form-control-artisan" value="Amina Diallo">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-artisan">Téléphone *</label>
                        <input type="tel" class="form-control-artisan" value="+229 95 00 00 00">
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Adresse de livraison</label>
                        <input type="text" class="form-control-artisan" placeholder="Quartier, ville...">
                    </div>
                    <div class="col-12">
                        <label class="form-label-artisan">Message pour l'artisan (optionnel)</label>
                        <textarea class="form-control-artisan" rows="3" placeholder="Précisions sur votre commande, personnalisation..."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-artisan">
            <h4 class="serif mb-3">Mode de paiement</h4>
            <div class="d-flex flex-column gap-2">
                <label class="d-flex align-items-center gap-3 p-3" style="border:2px solid var(--terracotta); border-radius:12px; background:rgba(160,82,45,0.02); cursor:pointer;">
                    <input type="radio" name="payment" checked>
                    <i class="bi bi-phone" style="font-size:1.5rem; color:var(--terracotta);"></i>
                    <div style="flex:1;">
                        <strong>Mobile Money</strong>
                        <p class="small text-muted mb-0">MTN, Moov, Celtiis</p>
                    </div>
                </label>
                <label class="d-flex align-items-center gap-3 p-3" style="border:2px solid rgba(44,62,80,0.1); border-radius:12px; cursor:pointer;">
                    <input type="radio" name="payment">
                    <i class="bi bi-cash-stack" style="font-size:1.5rem; color:var(--terracotta);"></i>
                    <div style="flex:1;">
                        <strong>Paiement à la livraison</strong>
                        <p class="small text-muted mb-0">Espèces lors de la réception</p>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-artisan" style="position:sticky; top:100px;">
            <h4 class="serif mb-3">Récapitulatif</h4>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Sous-total</span>
                <strong>25 000 F</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Livraison</span>
                <strong>2 000 F</strong>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <strong style="font-size:1.1rem;">Total</strong>
                <strong style="color:var(--terracotta); font-size:1.5rem;">27 000 F</strong>
            </div>
            <button class="btn btn-artisan w-100" style="justify-content:center; padding:1rem;">
                <i class="bi bi-lock-fill"></i>
                <span>Confirmer la commande</span>
            </button>
            <p class="small text-muted text-center mt-2 mb-0">
                <i class="bi bi-shield-check"></i> Paiement 100% sécurisé
            </p>
        </div>
    </div>
</div>

@endsection
