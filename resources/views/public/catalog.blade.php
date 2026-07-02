@extends('layouts.guest')
@section('title', 'Catalogue des Artisans')

@push('styles')
<style>
    .catalog-hero {
        background: linear-gradient(135deg, var(--indigo) 0%, var(--indigo-light) 100%);
        color: white;
        padding: 4rem 0 6rem;
        border-radius: 0 0 40px 40px;
        margin-top: -90px;
        padding-top: 150px;
        position: relative;
        overflow: hidden;
    }

    .catalog-hero::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 600px; height: 600px;
        background: radial-gradient(circle, var(--gold), transparent 70%);
        opacity: 0.15;
        border-radius: 50%;
    }

    .catalog-hero h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        margin-bottom: 1rem;
    }

    .catalog-hero p {
        opacity: 0.85;
        max-width: 600px;
        font-size: 1.1rem;
    }

    .search-bar {
        background: white;
        border-radius: 20px;
        padding: 0.5rem;
        display: flex;
        gap: 0.5rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        margin-top: 2rem;
        max-width: 700px;
    }

    .search-bar input {
        flex: 1;
        border: none;
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        background: transparent;
    }

    .search-bar input:focus { outline: none; }

    .search-bar select {
        border: none;
        background: var(--ivory);
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        color: var(--indigo);
    }

    .search-bar .btn-artisan {
        padding: 0.75rem 1.75rem;
    }

    /* Filtres */
    .filter-bar {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-top: -3rem;
        position: relative;
        z-index: 10;
        box-shadow: 0 10px 40px rgba(44, 62, 80, 0.08);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-chip {
        background: var(--ivory);
        border: 1.5px solid transparent;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--indigo);
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .filter-chip:hover, .filter-chip.active {
        background: var(--terracotta);
        color: white;
        border-color: var(--terracotta);
    }

    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 2rem 0 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .results-info h3 {
        margin: 0;
        color: var(--indigo);
        font-size: 1.5rem;
    }

    .results-info .count {
        color: var(--muted);
        font-size: 0.9rem;
    }

    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-toggle button {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: white;
        border: 1.5px solid rgba(44,62,80,0.1);
        color: var(--muted);
        cursor: pointer;
        transition: all 0.3s;
    }

    .view-toggle button.active {
        background: var(--indigo);
        color: white;
        border-color: var(--indigo);
    }
</style>
@endpush

@section('content')

<section class="catalog-hero">
    <div class="container position-relative">
        <p class="section-subtitle" style="color:var(--gold);">🔍 Explorez nos artisans</p>
        <h1 class="serif">Trouvez l'artisan idéal</h1>
        <p>Parcourez plus de 1500 produits et services artisanaux authentiques du Bénin.</p>

        <div class="search-bar">
            <i class="bi bi-search" style="padding-left:1rem; color:var(--muted); align-self:center;"></i>
            <input type="text" placeholder="Que recherchez-vous ? (ex: pagne, sculpture, bijou...)">
            <select>
                <option>Tout le Bénin</option>
                <option>Cotonou</option>
                <option>Porto-Novo</option>
                <option>Parakou</option>
                <option>Abomey</option>
            </select>
            <button class="btn btn-artisan"><span>Rechercher</span></button>
        </div>
    </div>
</section>

<div class="container">
    <div class="filter-bar reveal">
        <strong style="color:var(--indigo); font-size:0.9rem;"><i class="bi bi-funnel"></i> Filtres :</strong>
        <button class="filter-chip active"><i class="bi bi-grid"></i> Tous</button>
        <button class="filter-chip">🧵 Textile</button>
        <button class="filter-chip">🪵 Bois</button>
        <button class="filter-chip">🏺 Argile</button>
        <button class="filter-chip">👜 Cuir</button>
        <button class="filter-chip">💍 Bijoux</button>
        <button class="filter-chip">🍯 Agro</button>
        <div style="margin-left:auto;">
            <select class="form-select-artisan" style="width:auto; padding:0.5rem 1rem; font-size:0.85rem;">
                <option>Trier par : Popularité</option>
                <option>Prix croissant</option>
                <option>Prix décroissant</option>
                <option>Mieux notés</option>
                <option>Plus récents</option>
            </select>
        </div>
    </div>

    <div class="results-info">
        <div>
            <h3 class="serif">Tous les artisans</h3>
            <span class="count">248 résultats trouvés</span>
        </div>
        <div class="view-toggle">
            <button class="active"><i class="bi bi-grid-3x3-gap-fill"></i></button>
            <button><i class="bi bi-list-ul"></i></button>
        </div>
    </div>

    <div class="row g-4">
        @php
            $products = [
                ['name' => 'Pagne tissé traditionnel', 'artisan' => 'Atelier Kpodji', 'price' => 25000, 'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=500', 'category' => 'Textile', 'rating' => 5, 'city' => 'Cotonou'],
                ['name' => 'Masque sculpté Gèlèdé', 'artisan' => 'Sègbé Arts', 'price' => 85000, 'image' => 'https://images.unsplash.com/photo-1604473918181-2d9a2e0ef95b?w=500', 'category' => 'Bois', 'rating' => 5, 'city' => 'Porto-Novo'],
                ['name' => 'Sac en cuir fait main', 'artisan' => 'Cuir d\'Afrique', 'price' => 35000, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500', 'category' => 'Cuir', 'rating' => 4, 'city' => 'Parakou'],
                ['name' => 'Collier perles ethnique', 'artisan' => 'Bijoux Akossiwa', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=500', 'category' => 'Bijoux', 'rating' => 5, 'city' => 'Abomey'],
                ['name' => 'Poterie décorative', 'artisan' => 'Atelier Terre', 'price' => 18000, 'image' => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=500', 'category' => 'Argile', 'rating' => 4, 'city' => 'Bohicon'],
                ['name' => 'Miel bio de brousse', 'artisan' => 'Ruches du Bénin', 'price' => 8500, 'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500', 'category' => 'Agro', 'rating' => 5, 'city' => 'Djougou'],
                ['name' => 'Chemise en pagne', 'artisan' => 'Couture Fifa', 'price' => 22000, 'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=500', 'category' => 'Textile', 'rating' => 5, 'city' => 'Cotonou'],
                ['name' => 'Statuette ancestrale', 'artisan' => 'Bois Sacré', 'price' => 120000, 'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=500', 'category' => 'Bois', 'rating' => 5, 'city' => 'Porto-Novo'],
            ];
        @endphp

        @foreach($products as $product)
        <div class="col-md-6 col-lg-4 col-xl-3 reveal">
            @include('components.product-card', ['product' => $product])
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <nav class="mt-5 d-flex justify-content-center">
        <ul class="pagination" style="gap:0.25rem;">
            <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">12</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
        </ul>
    </nav>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
        });
    });
</script>
@endpush
