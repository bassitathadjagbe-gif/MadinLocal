@extends('layouts.app')

@section('title', 'Politique de Confidentialité - MadinLocal')

@section('content')
<div class="topbar">
    <div>
        <h1 class="page-title">Politique de Confidentialité</h1>
        <p class="page-subtitle">Dernière mise à jour : {{ now()->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('accueil') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
    </a>
</div>

<div class="card-artisan" style="max-width: 900px;">
    <div class="legal-content">

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-shield-lock me-2 text-warning"></i>1. Introduction
        </h3>
        <p class="text-muted mb-4">
            Chez <strong>MadinLocal</strong>, la protection de vos données personnelles est une priorité. Cette politique de confidentialité explique comment nous collectons, utilisons, partageons et protégeons vos informations lorsque vous utilisez notre plateforme.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-collection me-2 text-warning"></i>2. Données Collectées
        </h3>
        <p class="text-muted mb-2">Nous collectons les types de données suivants :</p>
        <ul class="text-muted mb-4">
            <li><strong>Données d'identification</strong> : nom, prénom, adresse email, numéro de téléphone</li>
            <li><strong>Données professionnelles</strong> : spécialité, ville, description de l'activité (pour les Artisans)</li>
            <li><strong>Données d'entreprise</strong> : nom d'entreprise, budget d'investissement (pour les Investisseurs)</li>
            <li><strong>Données transactionnelles</strong> : historique des commandes, montants, statuts</li>
            <li><strong>Données de communication</strong> : messages échangés via la messagerie interne</li>
            <li><strong>Données de navigation</strong> : adresse IP, type de navigateur, pages visitées</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-gear me-2 text-warning"></i>3. Utilisation des Données
        </h3>
        <p class="text-muted mb-2">Vos données sont utilisées pour :</p>
        <ul class="text-muted mb-4">
            <li>Fournir et améliorer nos services</li>
            <li>Traiter vos commandes et transactions</li>
            <li>Faciliter la communication entre utilisateurs</li>
            <li>Personnaliser votre expérience sur la plateforme</li>
            <li>Assurer la sécurité de votre compte</li>
            <li>Respecter nos obligations légales</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-share me-2 text-warning"></i>4. Partage des Données
        </h3>
        <p class="text-muted mb-4">
            Nous ne vendons jamais vos données personnelles. Vos données peuvent être partagées avec :
        </p>
        <ul class="text-muted mb-4">
            <li><strong>Les Artisans</strong> : lorsque vous passez commande (nom, message de commande)</li>
            <li><strong>Les Clients</strong> : lorsque vous êtes Artisan (nom, produits)</li>
            <li><strong>Les autorités</strong> : en cas d'obligation légale ou de demande judiciaire</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-lock me-2 text-warning"></i>5. Sécurité des Données
        </h3>
        <p class="text-muted mb-4">
            Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données :
        </p>
        <ul class="text-muted mb-4">
            <li><strong>Chiffrement des mots de passe</strong> : vos mots de passe sont hachés avec bcrypt</li>
            <li><strong>Protection CSRF</strong> : tous les formulaires sont protégés contre les attaques CSRF</li>
            <li><strong>Sessions sécurisées</strong> : gestion sécurisée des sessions utilisateur</li>
            <li><strong>Contrôle d'accès</strong> : système de rôles et permissions (Client, Artisan, Admin, Investisseur)</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-cookie me-2 text-warning"></i>6. Cookies
        </h3>
        <p class="text-muted mb-4">
            La Plateforme utilise des cookies essentiels au fonctionnement du service (cookies de session, cookies CSRF). Aucun cookie publicitaire tiers n'est utilisé. Vous pouvez configurer votre navigateur pour refuser les cookies, mais certaines fonctionnalités pourraient ne pas fonctionner correctement.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-person-lock me-2 text-warning"></i>7. Vos Droits
        </h3>
        <p class="text-muted mb-2">Conformément à la réglementation en vigueur, vous disposez des droits suivants :</p>
        <ul class="text-muted mb-4">
            <li><strong>Droit d'accès</strong> : consulter vos données personnelles</li>
            <li><strong>Droit de rectification</strong> : corriger vos données inexactes</li>
            <li><strong>Droit à l'effacement</strong> : demander la suppression de vos données</li>
            <li><strong>Droit à la portabilité</strong> : récupérer vos données dans un format structuré</li>
            <li><strong>Droit d'opposition</strong> : vous opposer au traitement de vos données</li>
        </ul>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-clock-history me-2 text-warning"></i>8. Conservation des Données
        </h3>
        <p class="text-muted mb-4">
            Vos données sont conservées pendant toute la durée de votre inscription sur la Plateforme. Après la suppression de votre compte, vos données sont conservées pendant une durée maximale de 12 mois pour des raisons légales et comptables, puis définitivement supprimées.
        </p>

        <h3 class="serif fw-bold mb-3" style="color: var(--indigo);">
            <i class="bi bi-envelope me-2 text-warning"></i>9. Contact
        </h3>
        <p class="text-muted mb-0">
            Pour toute question relative à cette politique de confidentialité ou pour exercer vos droits, vous pouvez nous contacter :
        </p>
        <ul class="text-muted mb-0">
            <li>Email : <strong>contact@madinlocal.com</strong></li>
            <li>Via notre page <a href="{{ route('contact.index') }}" style="color: var(--terracotta);">Contact</a></li>
        </ul>

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