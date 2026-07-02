@extends('layouts.guest')
@section('title', 'Atelier Kpodji')

@push('styles')
<style>
    .profile-cover {
        height: 300px;
        background: linear-gradient(135deg, var(--indigo), var(--terracotta));
        border-radius: 0 0 40px 40px;
        margin-top: -90px;
        padding-top: 90px;
        position: relative;
        overflow: hidden;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=1200');
        background-size: cover;
        background-position: center;
        opacity: 0.3;
    }

    .profile-header {
        display: flex;
        align-items: flex-end;
        gap: 2rem;
        margin-top: -80px;
        position: relative;
        z-index: 10;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 160px; height: 160px;
        border-radius: 30px;
        border: 5px solid white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        object-fit: cover;
        background: white;
    }

    .profile-info h1 {
        font-size: 2.5rem;
        margin: 0;
        color: var(--indigo);
    }

    .profile-info .meta {
        color: var(--muted);
        font-size: 1rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .profile-info .meta span {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .profile-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .profile-stats .stat {
        text-align: center;
    }

    .profile-stats .stat .num {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 700;
        color: var(--indigo);
        line-height: 1;
    }

    .profile-stats .stat .lbl {
        color: var(--muted);
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }

    .portfolio-item {
        aspect-ratio: 1;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }

    .portfolio-item img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .portfolio-item:hover img { transform: scale(1.1); }

    .portfolio-item .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        align-items: flex-end;
        padding: 1rem;
        color: white;
    }

    .portfolio-item:hover .overlay { opacity: 1; }
</style>
@endpush

@section('content')

<div class="profile-cover"></div>

<div class="container">
    <div class="profile-header">
        <img src="https://i.pravatar.cc/200?img=12" class="profile-avatar" alt="Artisan">
        <div class="profile-info" style="flex:1;">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h1 class="serif">Atelier Kpodji</h1>
                <span class="badge-status badge-success">✓ Vérifié</span>
            </div>
            <div class="meta">
                <span><i class="bi bi-geo-alt-fill" style="color:var(--terracotta);"></i> Cotonou, Bénin</span>
                <span><i class="bi bi-tag-fill" style="color:var(--terracotta);"></i> Textile traditionnel</span>
                <span><i class="bi bi-calendar3" style="color:var(--terracotta);"></i> Membre depuis 2023</span>
            </div>
            <div class="profile-stats">
                <div class="stat">
                    <div class="num">47</div>
                    <div class="lbl">Avis</div>
                </div>
                <div class="stat">
                    <div class="num">4.9</div>
                    <div class="lbl">Note ★</div>
                </div>
                <div class="stat">
                    <div class="num">12</div>
                    <div class="lbl">Produits</div>
                </div>
                <div class="stat">
                    <div class="num">156</div>
                    <div class="lbl">Ventes</div>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="/client/commander/1" class="btn btn-artisan"><i class="bi bi-bag-check"></i> Commander</a>
            <button class="btn btn-outline-artisan"><i class="bi bi-chat-dots"></i> Contacter</button>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-lg-8">
           

            <h3 class="serif mb-3">Portfolio</h3>
            <div class="portfolio-grid mb-4">
                @for($i = 1; $i <= 8; $i++)
                <div class="portfolio-item">
                    <img src="https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=400" alt="Portfolio">
                    <div class="overlay">
                        <div>
                            <strong>Création #{{ $i }}</strong>
                            <p class="small mb-0 opacity-75">Tissage traditionnel</p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <h3 class="serif mb-3">Produits (12)</h3>
            <div class="row g-3">
                @php
                    $products = [
                        ['name' => 'Pagne tissé traditionnel', 'artisan' => 'Atelier Kpodji', 'price' => 25000, 'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=500', 'category' => 'Textile', 'rating' => 5, 'city' => 'Cotonou'],
                        ['name' => 'Chemise en pagne', 'artisan' => 'Atelier Kpodji', 'price' => 22000, 'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=500', 'category' => 'Textile', 'rating' => 5, 'city' => 'Cotonou'],
                        ['name' => 'Nappe tissée', 'artisan' => 'Atelier Kpodji', 'price' => 35000, 'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=500', 'category' => 'Textile', 'rating' => 4, 'city' => 'Cotonou'],
                        ['name' => 'Écharpe artisanale', 'artisan' => 'Atelier Kpodji', 'price' => 12000, 'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=500', 'category' => 'Textile', 'rating' => 5, 'city' => 'Cotonou'],
                    ];
                @endphp
                @foreach($products as $product)
                <div class="col-md-6">
                    @include('components.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-artisan mb-3">
                <h5 class="serif mb-3">Informations</h5>
                <ul class="list-unstyled" style="color:var(--muted);">
                    <li class="mb-2"><i class="bi bi-telephone" style="color:var(--terracotta); width:20px;"></i> +229 97 00 00 00</li>
                    <li class="mb-2"><i class="bi bi-envelope" style="color:var(--terracotta); width:20px;"></i> contact@kpodji.bj</li>
                    <li class="mb-2"><i class="bi bi-geo-alt" style="color:var(--terracotta); width:20px;"></i> Quartier Zongo, Cotonou</li>
                    <li class="mb-2"><i class="bi bi-clock" style="color:var(--terracotta); width:20px;"></i> Lun-Sam : 8h-18h</li>
                </ul>
            </div>

            <div class="card-artisan mb-3">
                <h5 class="serif mb-3">Compétences</h5>
                <div class="d-flex flex-wrap gap-2">
                    <span class="filter-chip active" style="font-size:0.8rem;">Tissage</span>
                    <span class="filter-chip active" style="font-size:0.8rem;">Coton</span>
                    <span class="filter-chip active" style="font-size:0.8rem;">Teinture naturelle</span>
                    <span class="filter-chip active" style="font-size:0.8rem;">Sur mesure</span>
                </div>
            </div>

            <div class="card-artisan">
                <h5 class="serif mb-3">Derniers avis</h5>
                @for($i = 1; $i <= 3; $i++)
                <div class="mb-3 pb-3 {{ $i < 3 ? 'border-bottom' : '' }}" style="border-color:rgba(44,62,80,0.08);">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="https://i.pravatar.cc/30?img={{ $i + 30 }}" style="width:30px; height:30px; border-radius:50%;">
                        <div>
                            <strong style="font-size:0.85rem;">Client {{ $i }}</strong>
                            <div style="color:var(--gold); font-size:0.75rem;">★★★★★</div>
                        </div>
                    </div>
                    <p class="small mb-0" style="color:var(--muted);">Excellent travail, je recommande vivement !</p>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

@endsection
