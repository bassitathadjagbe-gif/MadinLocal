@extends('layouts.guest')
@section('title', 'Pagne tissé traditionnel')

@push('styles')
<style>
    .product-gallery {
        position: sticky;
        top: 110px;
    }

    .main-image {
        border-radius: 24px;
        overflow: hidden;
        aspect-ratio: 1;
        background: white;
        box-shadow: 0 10px 40px rgba(44, 62, 80, 0.1);
        margin-bottom: 1rem;
    }

    .main-image img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .main-image:hover img { transform: scale(1.05); }

    .thumbnails {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    .thumbnails img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s;
    }

    .thumbnails img:hover, .thumbnails img.active {
        border-color: var(--terracotta);
        transform: translateY(-3px);
    }

    .product-info h1 {
        font-size: clamp(1.75rem, 3vw, 2.5rem);
        color: var(--indigo);
        margin-bottom: 0.5rem;
    }

    .artisan-mini {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: white;
        border-radius: 16px;
        margin: 1.5rem 0;
        box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
    }

    .artisan-mini img {
        width: 50px; height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gold);
    }

    .artisan-mini .name {
        font-weight: 600;
        color: var(--indigo);
        margin: 0;
    }

    .artisan-mini .meta {
        font-size: 0.85rem;
        color: var(--muted);
        margin: 0;
    }

    .price-box {
        background: linear-gradient(135deg, var(--ivory-dark), white);
        border-radius: 20px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border: 1px solid rgba(201, 169, 97, 0.2);
    }

    .price-box .price {
        font-family: var(--font-serif);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--terracotta);
        line-height: 1;
    }

    .price-box .price-note {
        color: var(--muted);
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
    }

    .feature-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(44, 62, 80, 0.08);
        font-size: 0.95rem;
    }

    .feature-list li i {
        color: var(--terracotta);
        font-size: 1.25rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .action-buttons .btn-artisan {
        flex: 1;
        justify-content: center;
        padding: 1rem;
        font-size: 1rem;
    }

    .icon-action {
        width: 55px; height: 55px;
        border-radius: 50%;
        background: white;
        border: 1.5px solid rgba(44, 62, 80, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--indigo);
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1.25rem;
    }

    .icon-action:hover {
        background: var(--terracotta);
        color: white;
        border-color: var(--terracotta);
        transform: translateY(-3px);
    }

    .tab-nav {
        display: flex;
        gap: 0.5rem;
        border-bottom: 1px solid rgba(44, 62, 80, 0.1);
        margin-bottom: 1.5rem;
        overflow-x: auto;
    }

    .tab-nav button {
        background: transparent;
        border: none;
        padding: 1rem 1.5rem;
        color: var(--muted);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        transition: color 0.3s;
    }

    .tab-nav button.active {
        color: var(--terracotta);
    }

    .tab-nav button.active::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        height: 3px;
        background: var(--terracotta);
        border-radius: 2px 2px 0 0;
    }

    .review-item {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    .review-item .user {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .review-item .user img {
        width: 40px; height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .review-item .user .name {
        font-weight: 600;
        margin: 0;
        color: var(--indigo);
    }

    .review-item .user .date {
        font-size: 0.8rem;
        color: var(--muted);
        margin: 0;
    }

    .review-item .stars {
        color: var(--gold);
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav class="mb-4" style="font-size:0.9rem;">
        <a href="/" style="color:var(--muted); text-decoration:none;">Accueil</a>
        <i class="bi bi-chevron-right" style="font-size:0.7rem; color:var(--muted);"></i>
        <a href="/catalogue" style="color:var(--muted); text-decoration:none;">Catalogue</a>
        <i class="bi bi-chevron-right" style="font-size:0.7rem; color:var(--muted);"></i>
        <span style="color:var(--terracotta);">Pagne tissé traditionnel</span>
    </nav>

    <div class="row g-5">
        <!-- GALERIE -->
        <div class="col-lg-6">
            <div class="product-gallery">
                <div class="main-image">
                    <img id="mainImg" src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=800" alt="Produit">
                </div>
                <div class="thumbnails">
                    <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=200" class="active" onclick="changeImage(this)">
                    <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200" onclick="changeImage(this)">
                    <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=200" onclick="changeImage(this)">
                    <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=200" onclick="changeImage(this)">
                </div>
            </div>
        </div>

        <!-- INFOS -->
        <div class="col-lg-6">
            <div class="product-info">
                <span class="badge-status badge-info" style="margin-bottom:1rem;">✨ Nouveau</span>
                <h1 class="serif">Pagne tissé traditionnel</h1>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="color:var(--gold);">★★★★★</span>
                    <span style="color:var(--muted); font-size:0.9rem;">4.9 (47 avis)</span>
                    <span style="color:var(--muted);">•</span>
                    <span style="color:var(--muted); font-size:0.9rem;"><i class="bi bi-eye"></i> 328 vues</span>
                </div>

                <!-- Artisan -->
                <div class="artisan-mini">
                    <img src="https://i.pravatar.cc/100?img=12" alt="Artisan">
                    <div style="flex:1;">
                        <p class="name">Atelier Kpodji</p>
                        <p class="meta"><i class="bi bi-geo-alt-fill"></i> Cotonou, Bénin • Membre depuis 2023</p>
                    </div>
                    <a href="/artisan/1" class="btn btn-outline-artisan" style="padding:0.5rem 1rem; font-size:0.85rem;">Voir profil</a>
                </div>

                <!-- Prix -->
                <div class="price-box">
                    <div class="price">25 000 F CFA</div>
                    <div class="price-note">Prix unitaire • Paiement à la commande</div>
                </div>

                <!-- Caractéristiques -->
                <ul class="feature-list">
                    <li><i class="bi bi-check-circle-fill"></i> <strong>Matière :</strong> Coton 100% naturel filé à la main</li>
                    <li><i class="bi bi-check-circle-fill"></i> <strong>Dimensions :</strong> 2m x 1.2m</li>
                    <li><i class="bi bi-check-circle-fill"></i> <strong>Origine :</strong> Fait main au Bénin</li>
                    <li><i class="bi bi-check-circle-fill"></i> <strong>Délai :</strong> Prêt en 3-5 jours</li>
                    <li><i class="bi bi-check-circle-fill"></i> <strong>Personnalisable :</strong> Oui (couleurs, motifs)</li>
                </ul>

                <!-- Actions -->
                <div class="action-buttons">
                    <a href="/client/commander/1" class="btn btn-artisan">
                        <i class="bi bi-bag-check"></i>
                        <span>Commander</span>
                    </a>
                    <button class="icon-action" title="Contacter"><i class="bi bi-chat-dots"></i></button>
                    <button class="icon-action" title="Favoris"><i class="bi bi-heart"></i></button>
                </div>

                <p class="small text-muted mt-3 text-center">
                    <i class="bi bi-shield-check"></i> Paiement sécurisé • <i class="bi bi-truck"></i> Livraison disponible
                </p>
            </div>
        </div>
    </div>

    <!-- DESCRIPTION & AVIS -->
    <div class="mt-5">
        <div class="tab-nav">
            <button class="active" onclick="switchTab(event, 'desc')">Description</button>
            <button onclick="switchTab(event, 'reviews')">Avis (47)</button>
            <button onclick="switchTab(event, 'artisan')">À propos de l'artisan</button>
        </div>

        <div id="desc" class="tab-content">
            <div class="card-artisan">
                <h3 class="serif mb-3">Un savoir-faire ancestral</h3>
                <p style="color:var(--muted); line-height:1.8;">
                    Ce pagne tissé traditionnel est réalisé selon les techniques ancestrales transmises de génération en génération au sein de l'Atelier Kpodji. Chaque pièce est unique, fruit d'un travail minutieux effectué sur un métier à tisser en bois.
                </p>
                <p style="color:var(--muted); line-height:1.8;">
                    Les fils de coton sont teints avec des colorants naturels extraits de plantes locales, garantissant des couleurs durables et respectueuses de l'environnement. Ce pagne peut être porté lors de cérémonies traditionnelles ou intégré à des tenues modernes pour une touche d'authenticité.
                </p>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-leaf" style="color:var(--terracotta); font-size:1.5rem;"></i>
                            <div>
                                <strong style="color:var(--indigo);">Éco-responsable</strong>
                                <p class="small text-muted mb-0">Colorants naturels</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hand-index-thumb" style="color:var(--terracotta); font-size:1.5rem;"></i>
                            <div>
                                <strong style="color:var(--indigo);">100% fait main</strong>
                                <p class="small text-muted mb-0">Sans machine</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-award" style="color:var(--terracotta); font-size:1.5rem;"></i>
                            <div>
                                <strong style="color:var(--indigo);">Qualité premium</strong>
                                <p class="small text-muted mb-0">Coton sélectionné</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="reviews" class="tab-content" style="display:none;">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card-artisan text-center">
                        <div style="font-family:var(--font-serif); font-size:4rem; font-weight:700; color:var(--indigo); line-height:1;">4.9</div>
                        <div style="color:var(--gold); font-size:1.25rem; margin:0.5rem 0;">★★★★★</div>
                        <p class="text-muted small mb-0">Basé sur 47 avis</p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-artisan">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="width:30px;">5★</span>
                            <div style="flex:1; height:8px; background:var(--ivory-dark); border-radius:4px; overflow:hidden;">
                                <div style="width:85%; height:100%; background:var(--gold);"></div>
                            </div>
                            <small>85%</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="width:30px;">4★</span>
                            <div style="flex:1; height:8px; background:var(--ivory-dark); border-radius:4px; overflow:hidden;">
                                <div style="width:10%; height:100%; background:var(--gold);"></div>
                            </div>
                            <small>10%</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="width:30px;">3★</span>
                            <div style="flex:1; height:8px; background:var(--ivory-dark); border-radius:4px; overflow:hidden;">
                                <div style="width:3%; height:100%; background:var(--gold);"></div>
                            </div>
                            <small>3%</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span style="width:30px;">2★</span>
                            <div style="flex:1; height:8px; background:var(--ivory-dark); border-radius:4px; overflow:hidden;">
                                <div style="width:2%; height:100%; background:var(--gold);"></div>
                            </div>
                            <small>2%</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="width:30px;">1★</span>
                            <div style="flex:1; height:8px; background:var(--ivory-dark); border-radius:4px; overflow:hidden;">
                                <div style="width:0%; height:100%; background:var(--gold);"></div>
                            </div>
                            <small>0%</small>
                        </div>
                    </div>
                </div>
            </div>

            @for($i = 1; $i <= 3; $i++)
            <div class="review-item">
                <div class="user">
                    <img src="https://i.pravatar.cc/40?img={{ $i + 20 }}" alt="User">
                    <div>
                        <p class="name">Client {{ $i }}</p>
                        <p class="date">Il y a {{ $i }} jours</p>
                    </div>
                    <div style="margin-left:auto; color:var(--gold);">★★★★★</div>
                </div>
                <p class="mb-0" style="color:var(--muted);">Excellent travail ! La qualité du tissage est remarquable et les couleurs sont encore plus belles en vrai. Je recommande vivement cet artisan.</p>
            </div>
            @endfor
        </div>

        <div id="artisan" class="tab-content" style="display:none;">
            <div class="card-artisan">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="https://i.pravatar.cc/100?img=12" style="width:80px; height:80px; border-radius:50%; border:3px solid var(--gold);">
                    <div>
                        <h3 class="serif mb-1">Atelier Kpodji</h3>
                        <p class="text-muted mb-0"><i class="bi bi-geo-alt-fill" style="color:var(--terracotta);"></i> Cotonou, Bénin</p>
                    </div>
                </div>
                <p style="color:var(--muted); line-height:1.8;">
                    Fondé en 2015 par Maître Kpodji, notre atelier perpétue la tradition du tissage traditionnel béninois. Nous sommes une équipe de 5 artisans passionnés qui travaillons le coton selon des techniques ancestrales.
                </p>
                <a href="/artisan/1" class="btn btn-outline-artisan mt-2"><i class="bi bi-arrow-right"></i> Voir le profil complet</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function changeImage(el) {
        document.getElementById('mainImg').src = el.src.replace('w=200', 'w=800');
        document.querySelectorAll('.thumbnails img').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
    }

    function switchTab(e, tabId) {
        document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        document.getElementById(tabId).style.display = 'block';
    }
</script>
@endpush
