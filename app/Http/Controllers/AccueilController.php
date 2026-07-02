<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Produit;
use App\Models\Commande;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function accueil()
    {
        // ===== STATISTIQUES GLOBALES =====
        $totalArtisans = Artisan::count();
        $totalProduits = Produit::where('is_validated', true)
                                ->where('is_published', true)
                                ->count();
        $totalCommandes = Commande::count();
        $totalClients = User::where('role', 'client')->count();

        // ===== PRODUITS VEDETTES (6 derniers validés) =====
        $produitsVedettes = Produit::with(['artisan.user', 'category'])
            ->where('is_validated', true)
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        // ===== ARTISANS POPULAIRES (les mieux notés) =====
        $artisansPopulaires = Artisan::with(['user', 'evaluations'])
            ->withCount('produits')
            ->having('produits_count', '>', 0)
            ->get()
            ->sortByDesc(function($artisan) {
                return $artisan->evaluations()->avg('note') ?? 0;
            })
            ->take(4)
            ->values();

        // ===== CATÉGORIES POPULAIRES =====
        $categories = \App\Models\Categorie::withCount('produits')
            ->whereHas('produits', function($q) {
                $q->where('is_validated', true)->where('is_published', true);
            })
            ->orderBy('produits_count', 'desc')
            ->take(6)
            ->get();

        return view('accueil', compact(
            'totalArtisans',
            'totalProduits',
            'totalCommandes',
            'totalClients',
            'produitsVedettes',
            'artisansPopulaires',
            'categories'
        ));
    }
}