<?php

namespace App\Http\Controllers\Investisseur;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard principal
     */
    public function index()
    {
        $investisseur = Auth::user();

        // ✅ RÉCUPÉRER LES ARTISANS VALIDÉS ET ACTIFS
        $artisansDisponibles = Artisan::where('is_verified', 1)
            ->whereHas('user', function($query) {
                $query->where('is_active', 1);
            })
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Statistiques
        $totalOpportunites = $artisansDisponibles->count();
        
        $opportunitesEnAttente = Proposition::where('investisseur_id', $investisseur->id)
            ->where('statut_admin', 'en_attente')
            ->count();
        
        $opportunitesAcceptees = Proposition::where('investisseur_id', $investisseur->id)
            ->whereIn('statut', ['acceptee', 'en_cours'])
            ->count();
        
        $montantTotalPropose = Proposition::where('investisseur_id', $investisseur->id)
            ->where('statut_admin', 'validee')
            ->sum('montant');

        // Mes dernières propositions
        $mesOpportunites = Proposition::where('investisseur_id', $investisseur->id)
            ->with(['artisan.user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($prop) {
                return [
                    'id' => $prop->id,
                    'artisan_name' => $prop->artisan->user->name ?? 'Artisan',
                    'specialite' => $prop->artisan->specialite ?? 'Artisanat',
                    'montant_propose' => $prop->montant,
                    'statut' => $prop->statut,
                ];
            });

        // Profil investisseur
        $profilInvestisseur = $investisseur->profilInvestisseur ?? null;

        return view('investisseur.dashboard', compact(
            'artisansDisponibles',
            'totalOpportunites',
            'opportunitesEnAttente',
            'opportunitesAcceptees',
            'montantTotalPropose',
            'mesOpportunites',
            'profilInvestisseur'
        ));
    }

    /**
     * Liste de toutes les opportunités/propositions
     */
    public function opportunites()
    {
        $investisseur = Auth::user();

        $opportunites = Proposition::where('investisseur_id', $investisseur->id)
            ->with(['artisan.user'])
            ->latest()
            ->paginate(15);

        return view('investisseur.opportunites.index', compact('opportunites'));
    }

    /**
     * ✅ MÉTHODE MANQUANTE : Page entreprise/profil investisseur
     */
    public function entreprise()
    {
        $investisseur = Auth::user();
        $profilInvestisseur = $investisseur->profilInvestisseur ?? null;

        return view('investisseur.entreprise.index', compact('profilInvestisseur'));
    }

    /**
     * ✅ MÉTHODE MANQUANTE : Mettre à jour le profil entreprise
     */
    public function updateEntreprise(Request $request)
    {
        $investisseur = Auth::user();

        $request->validate([
            'entreprise' => 'required|string|max:255',
            'budget_min' => 'required|numeric|min:0',
            'budget_max' => 'required|numeric|min:0|gte:budget_min',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($investisseur->profilInvestisseur) {
            $investisseur->profilInvestisseur->update([
                'entreprise' => $request->entreprise,
                'budget_min' => $request->budget_min,
                'budget_max' => $request->budget_max,
                'description' => $request->description,
            ]);
        }

        return back()->with('success', '✅ Profil entreprise mis à jour avec succès !');
    }
}