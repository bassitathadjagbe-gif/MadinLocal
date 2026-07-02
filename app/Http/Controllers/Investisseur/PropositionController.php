<?php

namespace App\Http\Controllers\Investisseur;

use App\Http\Controllers\Controller;
use App\Models\Proposition;
use App\Models\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    /**
     * Soumettre une proposition à un artisan
     */
public function store(Request $request)
{
    $investisseur = Auth::user();

    // ✅ VÉRIFICATION CRITIQUE : Le compte investisseur doit être validé par l'admin
    // Si tu utilises une table 'entreprises' séparée : if (!$investisseur->entreprise->is_validated)
    if (!$investisseur->is_validated) { 
        return back()->with('error', '❌ Votre compte investisseur n\'est pas encore validé par l\'administrateur. Vous ne pouvez pas faire de propositions pour le moment.');
    }

    // ... le reste de ton code de validation et de création ...
}
    /**
     * Liste des propositions de l'investisseur
     */
    public function index()
    {
        $propositions = Proposition::where('investisseur_id', Auth::id())
            ->with('artisan.user', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('investisseur.propositions.index', compact('propositions'));
    }
    /**
 * Afficher le formulaire de proposition
 */
public function create(Artisan $artisan)
{
    $investisseur = Auth::user();

    
    return view('investisseur.propositions.create', compact('artisan'));
}
}