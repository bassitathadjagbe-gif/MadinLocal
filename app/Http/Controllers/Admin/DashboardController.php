<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Proposition;
use App\Models\User;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord administrateur
     */
    public function index()
{
    // Statistiques de base
    $stats = [
        'total_users' => User::count(),
        'total_artisans' => User::where('role', 'artisan')->count(),
        'total_produits' => Produit::count(),
        'total_commandes' => Commande::count(),
        'total_revenus' => Commande::where('statut', 'terminee')->sum('montant_total'),
        'produits_en_attente' => Produit::where('is_validated', false)->count(),
        'artisans_en_attente' => Artisan::where('is_verified', false)->count(),
        'propositions_en_attente' => Proposition::where('statut_admin', 'en_attente')->count(),
    ];

    // ✅ DONNÉES POUR GRAPHIQUES
    
    // Commandes par mois (6 derniers mois)
    $commandesParMois = Commande::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total', 'mois')
        ->toArray();
    
    // Remplir les mois manquants
    $moisLabels = [];
    $commandesData = [];
    for ($i = 5; $i >= 0; $i--) {
        $mois = now()->subMonths($i)->format('Y-m');
        $moisLabels[] = now()->subMonths($i)->format('M Y');
        $commandesData[] = $commandesParMois[$mois] ?? 0;
    }

    // Revenus par mois (6 derniers mois)
    $revenusParMois = Commande::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, SUM(montant_total) as total')
        ->where('statut', 'terminee')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total', 'mois')
        ->toArray();
    
    $revenusData = [];
    for ($i = 5; $i >= 0; $i--) {
        $mois = now()->subMonths($i)->format('Y-m');
        $revenusData[] = $revenusParMois[$mois] ?? 0;
    }

    // Utilisateurs par rôle
    $usersParRole = User::selectRaw('role, COUNT(*) as total')
        ->groupBy('role')
        ->pluck('total', 'role')
        ->toArray();

    // Statut des commandes
    $commandesParStatut = Commande::selectRaw('statut, COUNT(*) as total')
        ->groupBy('statut')
        ->pluck('total', 'statut')
        ->toArray();

    // Produits validés vs en attente
    $produitsStats = [
        'valides' => Produit::where('is_validated', true)->count(),
        'en_attente' => Produit::where('is_validated', false)->count(),
    ];

    $produitsEnAttente = Produit::where('is_validated', false)
        ->with(['artisan.user'])
        ->latest()
        ->take(3)
        ->get();

    $artisansEnAttente = Artisan::where('is_verified', false)
        ->with('user')
        ->latest()
        ->take(3)
        ->get();

    $propositionsEnAttente = Proposition::where('statut_admin', 'en_attente')
        ->with(['investisseur', 'artisan.user'])
        ->latest()
        ->take(5)
        ->get();

    $usersRecents = User::latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'stats',
        'moisLabels',
        'commandesData',
        'revenusData',
        'usersParRole',
        'commandesParStatut',
        'produitsStats',
        'produitsEnAttente',
        'artisansEnAttente',
        'propositionsEnAttente',
        'usersRecents'
    ));
}
}