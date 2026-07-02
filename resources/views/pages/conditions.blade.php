@extends('layouts.app')

@section('title', 'Conditions d\'Utilisation - MadinLocal')

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Conditions d'Utilisation</h1>
        <p class="page-subtitle">Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('accueil') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
    </a>
</div>

<div class="card-artisan" style="max-width: 900px;">
    <div class="legal-content">

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-file-earmark-text me-2 text-warning"></i>1. Objet
        </h3>
        <p class="text-muted mb-4">
            Les présentes conditions d'utilisation (ci-après « CGU ») ont pour objet de définir les modalités et conditions dans lesquelles la plateforme <strong>MadinLocal</strong> (ci-après « la Plateforme ») met à disposition de ses utilisateurs ses services, et les conditions selon lesquelles les utilisateurs accèdent et utilisent ces services.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-people me-2 text-warning"></i>2. Définitions
        </h3>
        <ul class="text-muted mb-4">
            <li><strong>Plateforme</strong> : désigne le site web MadinLocal accessible à l'adresse madinlocal.com</li>
            <li><strong>Artisan</strong> : désigne tout utilisateur professionnel proposant des produits ou services artisanaux sur la Plateforme</li>
            <li><strong>Client</strong> : désigne tout utilisateur passant commande auprès d'un Artisan via la Plateforme</li>
            <li><strong>Investisseur</strong> : désigne tout utilisateur souhaitant financer des projets artisanaux</li>
            <li><strong>Contenu</strong> : désigne l'ensemble des éléments (textes, images, produits) publiés sur la Plateforme</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-person-check me-2 text-warning"></i>3. Accès et Inscription
        </h3>
        <p class="text-muted mb-4">
            L'accès à la Plateforme est ouvert à toute personne physique ou morale disposant de la capacité juridique. L'inscription est gratuite et nécessite la fourniture d'informations exactes et complètes. Chaque utilisateur est responsable de la confidentialité de ses identifiants de connexion.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-cart-check me-2 text-warning"></i>4. Commandes et Transactions
        </h3>
        <p class="text-muted mb-4">
            Les commandes passées via la Plateforme constituent un contrat de vente entre le Client et l'Artisan. MadinLocal agit en tant qu'intermédiaire technique et ne saurait être tenu responsable de la qualité des produits ou services proposés par les Artisans. Les prix affichés sont en FCFA et incluent les taxes applicables.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-shield-check me-2 text-warning"></i>5. Validation des Produits
        </h3>
        <p class="text-muted mb-4">
            Tout produit soumis par un Artisan doit être validé par un administrateur de la Plateforme avant d'être visible publiquement. MadinLocal se réserve le droit de refuser tout produit ne respectant pas les standards de qualité ou la législation en vigueur.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-chat-dots me-2 text-warning"></i>6. Messagerie et Communication
        </h3>
        <p class="text-muted mb-4">
            La messagerie interne de la Plateforme est destinée exclusivement aux échanges professionnels entre Clients, Artisans et Investisseurs. Tout message à caractère injurieux, diffamatoire ou illicite entraînera la suspension immédiate du compte concerné.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-star me-2 text-warning"></i>7. Évaluations et Avis
        </h3>
        <p class="text-muted mb-4">
            Les évaluations laissées par les Clients doivent refléter une expérience réelle. Les faux avis, les avis diffamatoires ou les tentatives de manipulation des notes sont strictement interdits et pourront entraîner des sanctions.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>8. Responsabilité
        </h3>
        <p class="text-muted mb-4">
            MadinLocal ne saurait être tenu responsable des dommages directs ou indirects résultant de l'utilisation de la Plateforme. La responsabilité de MadinLocal est limitée au montant des frais éventuellement perçus pour l'utilisation du service.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-arrow-repeat me-2 text-warning"></i>9. Modification des CGU
        </h3>
        <p class="text-muted mb-4">
            MadinLocal se réserve le droit de modifier les présentes CGU à tout moment. Les utilisateurs seront informés de toute modification substantielle par notification sur la Plateforme. L'utilisation continue de la Plateforme après modification vaut acceptation des nouvelles CGU.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-geo-alt me-2 text-warning"></i>10. Droit Applicable
        </h3>
        <p class="text-muted mb-0">
            Les présentes CGU sont soumises au droit applicable. En cas de litige, les tribunaux compétents seront ceux du lieu du siège social de MadinLocal.
        </p>

    </div>
</div>
@endsection

@push('styles')
<style>
    .legal-content h3 {
        padding-top: 1rem;
        border-top: 1px solid rgba(44, 62, 80, 0.08);
        margin-top: 1.5rem;
    }
    .legal-content h3:first-child {
        border-top: none;
        margin-top: 0;
        padding-top: 0;
    }
    .legal-content ul {
        padding-left: 1.5rem;
    }
    .legal-content ul li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush