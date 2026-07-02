<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
 public function index(Request $request)
{
    // Récupérer les paramètres
    $search = $request->input('search', '');
    $category = $request->input('category', '');
    $sortBy = $request->input('sort', 'recent');
    $type = $request->input('type', '');

    // Requête de base avec filtres
    $query = Produit::with(['artisan.user', 'category'])
        ->where('is_published', true)
        ->where('is_validated', true);

    // Filtre de recherche
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // Filtre par catégorie
    if ($category) {
        $query->where('category_id', $category);
    }

    // Filtre par type
    if ($type) {
        $query->where('type', $type);
    }

    // Tri
    switch ($sortBy) {
        case 'price_low':
            $query->orderBy('prix', 'asc');
            break;
        case 'price_high':
            $query->orderBy('prix', 'desc');
            break;
        case 'popular':
            $query->orderBy('created_at', 'desc');
            break;
        case 'recent':
        default:
            $query->latest();
            break;
    }

    $produits = $query->paginate(12);
    $categories = Categorie::all();

    return view('catalogue', compact(
        'produits', 
        'categories', 
        'search', 
        'category', 
        'sortBy', 
        'type'
    ));
}
 public function show(Produit $produit)
{
    if (!$produit->is_published || !$produit->is_validated) {
        abort(404);
    }

    $produit->load(['artisan.user', 'category']);

    // Produits similaires
    $produitsSimilaires = Produit::with(['artisan.user'])
        ->where('category_id', $produit->category_id)
        ->where('id', '!=', $produit->id)
        ->where('is_published', true)
        ->where('is_validated', true)
        ->limit(4)
        ->get();

    // ✅ Vérifier si le produit est dans les favoris du client connecté
    $estFavori = false;
    if (auth()->check()) {
        $estFavori = \App\Models\Favori::where('client_id', auth()->id())
                                        ->where('produit_id', $produit->id)
                                        ->exists();
    }

    // Récupérer les évaluations de ce produit
$evaluations = \App\Models\Evaluation::with('client')
    ->where('produit_id', $produit->id)
    ->latest()
    ->take(5)
    ->get();

// Statistiques
$noteMoyenne = \App\Models\Evaluation::where('produit_id', $produit->id)->avg('note') ?? 0;
$totalEvaluations = \App\Models\Evaluation::where('produit_id', $produit->id)->count();

return view('produit-detail', compact(
    'produit', 'produitsSimilaires', 'estFavori', 
    'evaluations', 'noteMoyenne', 'totalEvaluations'
));
    return view('produit-detail', compact('produit', 'produitsSimilaires', 'estFavori'));
}
}