<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Favori;
use App\Models\Artisan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::user();
        
        // ===== STATISTIQUES =====
        $totalCommandes = Commande::where('client_id', $client->id)->count();
        
        $commandesEnCours = Commande::where('client_id', $client->id)
            ->whereIn('statut', ['en_attente', 'acceptee', 'en_cours'])
            ->count();
        
        $commandesTerminees = Commande::where('client_id', $client->id)
            ->where('statut', 'terminee')
            ->count();
        
        $totalFavoris = Favori::where('client_id', $client->id)->count();
        
        // ===== COMMANDES RÉCENTES (5 dernières) =====
        $commandesRecentes = Commande::with(['produit', 'artisan.user'])
            ->where('client_id', $client->id)
            ->latest()
            ->take(5)
            ->get();
        
        // ===== FAVORIS (6 derniers) =====
        $favoris = Favori::with('produit.artisan.user')
            ->where('client_id', $client->id)
            ->latest()
            ->take(6)
            ->get()
            ->map(function($favori) {
                return $favori->produit;
            });
        
        // ===== ARTISANS RECOMMANDÉS =====
        $artisanIdsCommandes = Commande::where('client_id', $client->id)
            ->pluck('artisan_id')
            ->unique();
        
        $artisansRecommandes = Artisan::with(['user', 'produits'])
            ->whereHas('produits', function($q) {
                $q->where('is_validated', true)->where('is_published', true);
            })
            ->whereNotIn('id', $artisanIdsCommandes->toArray())
            ->withCount('produits')
            ->orderBy('produits_count', 'desc')
            ->take(4)
            ->get();
        
        return view('client.dashboard', compact(
            'totalCommandes',
            'commandesEnCours',
            'commandesTerminees',
            'totalFavoris',
            'commandesRecentes',
            'favoris',
            'artisansRecommandes'
        ));
    }
}