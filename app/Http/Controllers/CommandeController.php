<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    // ===== CÔTÉ CLIENT =====

    public function create(Produit $produit)
    {
        if (!$produit->is_published || !$produit->is_validated) {
            abort(404);
        }
        return view('commandes.create', compact('produit'));
    }

    public function store(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1|max:' . $produit->stock,
            'message_client' => 'nullable|string|max:500',
        ]);

        $quantite = $request->quantite;
        $montantTotal = $produit->prix * $quantite;

        // ✅ CORRECTION : Utiliser les bons noms de colonnes
        $commande = Commande::create([
            'client_id' => Auth::id(),
            'artisan_id' => $produit->artisan_id,
            'produit_id' => $produit->id,
            'quantite' => $quantite,
            'montant_total' => $montantTotal,     
            'statut' => 'en_attente',
            'message_client' => $request->message_client,  
        ]);

        // Décrémenter le stock
        if ($produit->type === 'produit') {
            $produit->decrement('stock', $quantite);
        }

        return redirect()->route('client.commandes.index')
            ->with('success', 'Commande envoyée avec succès ! L\'artisan va l\'examiner.');
    }

    public function mesCommandes()
    {
        $commandes = Commande::with(['produit', 'artisan.user'])
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('commandes.client.index', compact('commandes'));
    }

    // ===== CÔTÉ ARTISAN =====

    public function commandesRecues()
    {
        $artisan = Auth::user()->artisan;
        $commandes = Commande::with(['produit', 'client'])
            ->where('artisan_id', $artisan->id)
            ->latest()
            ->paginate(10);
            
        return view('commandes.artisan.index', compact('commandes'));
    }

   public function updateStatut(Request $request, Commande $commande)
{
    $request->validate([
        'statut' => 'required|in:acceptee,refusee,en_cours,terminee',
    ]);

    $commande->update([
        'statut' => $request->statut,
    ]);

    return back()->with('success', 'Statut de la commande mis à jour !');
}

/**
 * Afficher les détails d'une commande
 */
public function show(Commande $commande)
{
    // Vérifier que la commande appartient au client connecté
    if ($commande->client_id !== Auth::id()) {
        abort(403, 'Vous n\'êtes pas autorisé à voir cette commande.');
    }

    return view('commandes.client.show', compact('commande'));
}
}