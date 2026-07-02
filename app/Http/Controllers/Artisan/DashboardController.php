<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Commande;
use App\Models\Message;
use App\Models\Produit;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
class DashboardController extends Controller
{
    public function index()
    {
        $artisan = Auth::user()->artisan;

        // Statistiques existantes
        $totalProduits = Produit::where('artisan_id', $artisan->id)->count();
        $produitsEnAttente = Produit::where('artisan_id', $artisan->id)
            ->where('is_validated', false)
            ->count();

        $totalCommandes = Commande::where('artisan_id', $artisan->id)->count();
        $commandesEnAttente = Commande::where('artisan_id', $artisan->id)
            ->where('statut', 'en_attente')
            ->count();

        $chiffreAffaires = Commande::where('artisan_id', $artisan->id)
            ->where('statut', 'terminee')
            ->sum('montant_total');

        $messagesNonLus = Message::where('destinataire_id', Auth::id())
            ->whereNull('lu_a')
            ->count();

        // ✅ NOUVEAU : Propositions reçues
        $propositionsRecues = Proposition::where('artisan_id', $artisan->id)
            ->where('statut_admin', 'validee')
            ->where('statut', 'en_attente')
            ->count();

        $propositionsRecentes = Proposition::where('artisan_id', $artisan->id)
            ->where('statut_admin', 'validee')
            ->where('statut', 'en_attente')
            ->with('investisseur')
            ->latest()
            ->take(3)
            ->get();

        // Commandes récentes
        $commandesRecentes = Commande::where('artisan_id', $artisan->id)
            ->with(['client', 'produit'])
            ->latest()
            ->take(5)
            ->get();

        // Produits récents
        $produitsRecents = Produit::where('artisan_id', $artisan->id)
            ->latest()
            ->take(5)
            ->get();

        return view('artisan.dashboard', compact(
            'totalProduits',
            'produitsEnAttente',
            'totalCommandes',
            'commandesEnAttente',
            'chiffreAffaires',
            'messagesNonLus',
            'commandesRecentes',
            'produitsRecents',
            'propositionsRecues',      // ✅ NOUVEAU
            'propositionsRecentes'     // ✅ NOUVEAU
        ));
    }

    /**
 * Page des rendez-vous de l'artisan
 */
public function rendezVous()
{
    $artisan = Auth::user()->artisan;

    // Tous les rendez-vous
    $rendezVous = \App\Models\RendezVous::where('artisan_id', $artisan->id)
        ->with(['client', 'service'])
        ->latest('date_rdv')
        ->paginate(10);

    // Rendez-vous d'aujourd'hui
    $rendezVousAujourdhui = \App\Models\RendezVous::where('artisan_id', $artisan->id)
        ->whereDate('date_rdv', today())
        ->with(['client', 'service'])
        ->orderBy('heure_rdv')
        ->get();

    // Statistiques
    $stats = [
        'total' => \App\Models\RendezVous::where('artisan_id', $artisan->id)->count(),
        'en_attente' => \App\Models\RendezVous::where('artisan_id', $artisan->id)
            ->where('statut', 'en_attente')->count(),
        'confirmes' => \App\Models\RendezVous::where('artisan_id', $artisan->id)
            ->where('statut', 'confirme')->count(),
        'termines' => \App\Models\RendezVous::where('artisan_id', $artisan->id)
            ->where('statut', 'termine')->count(),
    ];

    return view('artisan.rendez-vous.index', compact('rendezVous', 'rendezVousAujourdhui', 'stats'));
}
}