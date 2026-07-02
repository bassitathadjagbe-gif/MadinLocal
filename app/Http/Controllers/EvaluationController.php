<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    // Formulaire d'évaluation
    public function create(Commande $commande)
    {
        // Vérifier que c'est bien le client de la commande
        if ($commande->client_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à évaluer cette commande.');
        }

        // Vérifier que la commande est terminée
        if ($commande->statut !== 'terminee') {
            return back()->with('error', 'Vous ne pouvez évaluer qu\'une commande terminée.');
        }

        // Vérifier qu'elle n'a pas déjà été évaluée
        if ($commande->est_evaluee) {
            return back()->with('error', 'Vous avez déjà évalué cette commande.');
        }

        $commande->load(['produit', 'artisan.user']);

        return view('evaluations.create', compact('commande'));
    }

    // Enregistrer l'évaluation
    public function store(Request $request, Commande $commande)
    {
        if ($commande->client_id !== Auth::id()) {
            abort(403);
        }

        if ($commande->statut !== 'terminee' || $commande->est_evaluee) {
            return back()->with('error', 'Évaluation impossible.');
        }

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Evaluation::create([
            'client_id' => Auth::id(),
            'artisan_id' => $commande->artisan_id,
            'commande_id' => $commande->id,
            'produit_id' => $commande->produit_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('client.commandes.index')
            ->with('success', '✅ Merci pour votre évaluation !');
    }

    // Voir les évaluations d'un artisan (pour la page profil futur)
    public function index($artisanId)
    {
        $evaluations = Evaluation::with(['client', 'produit'])
            ->where('artisan_id', $artisanId)
            ->latest()
            ->paginate(10);

        return view('evaluations.index', compact('evaluations'));
    }
}