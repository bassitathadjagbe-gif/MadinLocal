@extends('layouts.guest')

@section('title', 'Contactez-nous - MadinLocal')

@section('content')
{{-- ===== HERO SECTION ===== --}}
<div class="contact-hero position-relative overflow-hidden rounded-4 mb-5" style="background: linear-gradient(135deg, #2C3E50 0%, #A0522D 100%); padding: 4rem 3rem; color: white;">
    <div class="position-absolute top-0 end-0 opacity-10" style="font-size: 15rem; transform: translate(20%, -20%);">
        <i class="bi bi-envelope-paper-heart"></i>
    </div>
    <div class="position-relative z-2">
        <span class="badge bg-white text-dark mb-3 px-3 py-2 rounded-pill">
            <i class="bi bi-headset me-1"></i> Support dédié
        </span>
        <h1 class="fw-bold mb-3" style="font-family: 'Fraunces', serif; font-size: 3rem;">Une question ? Parlons-en.</h1>
        <p class="lead mb-0 opacity-90" style="max-width: 600px;">
            Notre équipe est à votre écoute pour toute question sur la plateforme, vos commandes, ou votre statut d'artisan.
        </p>
    </div>
</div>

{{-- ===== 3 CARTES D'INFOS ===== --}}
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="contact-info-card text-center p-4 h-100">
            <div class="contact-icon-wrapper mb-3 mx-auto">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <h5 class="fw-bold mb-2" style="font-family: 'Fraunces', serif; color: #2C3E50;">Notre Adresse</h5>
            <p class="text-muted small mb-0">123 Rue de l'Artisanat<br>Baie-Mahault, Guadeloupe 97122</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="contact-info-card text-center p-4 h-100">
            <div class="contact-icon-wrapper mb-3 mx-auto">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <h5 class="fw-bold mb-2" style="font-family: 'Fraunces', serif; color: #2C3E50;">Email</h5>
            <p class="text-muted small mb-0">contact@madinlocal.com<br>support@madinlocal.com</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="contact-info-card text-center p-4 h-100">
            <div class="contact-icon-wrapper mb-3 mx-auto">
                <i class="bi bi-telephone-fill"></i>
            </div>
            <h5 class="fw-bold mb-2" style="font-family: 'Fraunces', serif; color: #2C3E50;">Téléphone</h5>
            <p class="text-muted small mb-0">+590 5 90 00 00 00<br>Lun-Ven : 9h - 18h</p>
        </div>
    </div>
</div>

{{-- ===== FORMULAIRE + FAQ ===== --}}
<div class="row g-4">
    {{-- FORMULAIRE --}}
    <div class="col-lg-7">
        <div class="contact-form-card p-4 p-md-5">
            <div class="mb-4">
                <span class="badge-custom bg-warning text-dark">Formulaire</span>
                <h2 class="fw-bold mb-1" style="font-family: 'Fraunces', serif; color: #2C3E50;">Envoyez-nous un message</h2>
                <p class="text-muted small mb-0">Nous vous répondrons dans les 24h ouvrées.</p>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Nom complet <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text-custom"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="nom" class="form-control-custom" value="{{ old('nom') }}" placeholder="Votre nom" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text-custom"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control-custom" value="{{ old('email') }}" placeholder="votre@email.com" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label-custom">Sujet <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text-custom"><i class="bi bi-tag text-muted"></i></span>
                            <input type="text" name="sujet" class="form-control-custom" value="{{ old('sujet') }}" placeholder="Objet de votre demande" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label-custom">Votre message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control-custom" rows="6" placeholder="Décrivez votre demande en détail..." required>{{ old('message') }}</textarea>
                        <small class="text-muted">Minimum 10 caractères</small>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-submit-custom">
                            <i class="bi bi-send-fill me-2"></i>Envoyer le message
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- FAQ --}}
    <div class="col-lg-5">
        <div class="contact-form-card p-4 p-md-5">
            <div class="mb-4">
                <span class="badge-custom bg-info text-dark">FAQ</span>
                <h2 class="fw-bold mb-1" style="font-family: 'Fraunces', serif; color: #2C3E50;">Questions fréquentes</h2>
                <p class="text-muted small mb-0">Les réponses aux questions les plus posées.</p>
            </div>

            <div class="accordion faq-accordion" id="faqAccordion">
                <div class="accordion-item-custom">
                    <h2 class="accordion-header">
                        <button class="accordion-button-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <i class="bi bi-question-circle-fill text-warning me-2"></i>
                            Comment devenir artisan sur MadinLocal ?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body-custom">
                            Cliquez sur "Inscription" en haut à droite, choisissez le rôle "Artisan", remplissez votre profil et soumettez vos documents. Notre équipe validera votre compte sous 48h.
                        </div>
                    </div>
                </div>

                <div class="accordion-item-custom">
                    <h2 class="accordion-header">
                        <button class="accordion-button-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <i class="bi bi-question-circle-fill text-warning me-2"></i>
                            Quels sont les délais de livraison ?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body-custom">
                            Les délais varient selon l'artisan et le produit. En moyenne, comptez 3 à 7 jours ouvrés en Guadeloupe. Chaque artisan précise ses délais sur sa fiche produit.
                        </div>
                    </div>
                </div>

                <div class="accordion-item-custom">
                    <h2 class="accordion-header">
                        <button class="accordion-button-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <i class="bi bi-question-circle-fill text-warning me-2"></i>
                            Comment contacter un artisan ?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body-custom">
                            Une fois connecté, rendez-vous sur la page d'un produit et cliquez sur "Contacter l'artisan". Vous pourrez échanger via notre messagerie interne sécurisée.
                        </div>
                    </div>
                </div>

                <div class="accordion-item-custom">
                    <h2 class="accordion-header">
                        <button class="accordion-button-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            <i class="bi bi-question-circle-fill text-warning me-2"></i>
                            Les paiements sont-ils sécurisés ?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body-custom">
                            Oui, toutes les transactions sont protégées. Nous utilisons des protocoles de chiffrement standards et ne stockons jamais vos données bancaires.
                        </div>
                    </div>
                </div>

                <div class="accordion-item-custom">
                    <h2 class="accordion-header">
                        <button class="accordion-button-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            <i class="bi bi-question-circle-fill text-warning me-2"></i>
                            Puis-je retourner un produit ?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body-custom">
                            Oui, vous disposez d'un délai de 14 jours pour retourner un produit non conforme. Contactez l'artisan via la messagerie pour organiser le retour.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CTA FINAL ===== --}}
<div class="contact-form-card mt-5 p-4 p-md-5 text-center" style="background: linear-gradient(135deg, #F0EBE1, white);">
    <div class="row align-items-center">
        <div class="col-md-8 text-md-start mb-3 mb-md-0">
            <h3 class="fw-bold mb-2" style="font-family: 'Fraunces', serif; color: #2C3E50;">Vous préférez les réseaux sociaux ?</h3>
            <p class="text-muted mb-0">Suivez-nous pour les dernières actualités et offres exclusives.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                <a href="#" class="social-btn-custom"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-btn-custom"><i class="bi bi-instagram"></i></a>
                <a href="#" class="social-btn-custom"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="social-btn-custom"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===== HERO ===== */
    .contact-hero {
        min-height: 280px;
        display: flex;
        align-items: center;
    }
    
    /* ===== CARTES D'INFOS ===== */
    .contact-info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }
    
    .contact-info-card:hover {
        transform: translateY(-8px);
        border-color: #A0522D;
        box-shadow: 0 20px 40px rgba(160, 82, 45, 0.15);
    }
    
    .contact-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #A0522D, #C9A961);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 10px 25px rgba(160, 82, 45, 0.3);
        transition: all 0.3s ease;
    }
    
    .contact-info-card:hover .contact-icon-wrapper {
        transform: rotate(360deg) scale(1.1);
    }
    
    /* ===== CARTES FORMULAIRE ===== */
    .contact-form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
    }
    
    /* ===== FORMULAIRE ===== */
    .form-label-custom {
        font-weight: 600;
        font-size: 0.9rem;
        color: #2C3E50;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control-custom {
        background: white;
        border: 1.5px solid rgba(44, 62, 80, 0.12);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
        width: 100%;
    }
    
    .form-control-custom:focus {
        outline: none;
        border-color: #A0522D;
        box-shadow: 0 0 0 4px rgba(160, 82, 45, 0.1);
    }
    
    .input-group-text-custom {
        background: white;
        border: 1.5px solid rgba(44, 62, 80, 0.12);
        border-right: none;
        border-radius: 12px 0 0 12px;
        padding: 0.75rem 1rem;
    }
    
    .input-group .form-control-custom {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }
    
    .input-group .form-control-custom:focus {
        border-left: none;
    }
    
    .btn-submit-custom {
        background: linear-gradient(135deg, #2C3E50, #A0522D);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        width: 100%;
    }
    
    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(160, 82, 45, 0.3);
        color: white;
    }
    
    /* ===== FAQ ACCORDÉON ===== */
    .accordion-item-custom {
        border: none;
        margin-bottom: 1rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.08);
    }
    
    .accordion-button-custom {
        background: #FAF7F2 !important;
        color: #2C3E50 !important;
        box-shadow: none !important;
        padding: 1rem 1.25rem;
        font-weight: 600;
        font-size: 0.95rem;
        width: 100%;
        border: none;
        text-align: left;
        display: flex;
        align-items: center;
    }
    
    .accordion-button-custom:not(.collapsed) {
        background: #A0522D !important;
        color: white !important;
    }
    
    .accordion-button-custom:not(.collapsed) i {
        color: white !important;
    }
    
    .accordion-button-custom:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(160, 82, 45, 0.15) !important;
    }
    
    .accordion-body-custom {
        background: white;
        padding: 1.25rem;
        color: #6B7280;
        font-size: 0.9rem;
    }
    
    /* ===== BOUTONS RÉSEAUX SOCIAUX ===== */
    .social-btn-custom {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        border: 1px solid rgba(44, 62, 80, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2C3E50;
        font-size: 1.3rem;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .social-btn-custom:hover {
        background: #2C3E50;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(44, 62, 80, 0.2);
    }
    
    /* ===== BADGES ===== */
    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }
</style>
@endpush