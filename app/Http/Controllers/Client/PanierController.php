<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Commande; 

class PanierController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        $panierItems = Panier::where('client_id', Auth::id())
            ->with('produit.artisan')
            ->get();

        $total = $panierItems->sum(function($item) {
            return $item->sous_total;
        });

        $nombreArticles = $panierItems->sum('quantite');

        return view('client.panier.index', compact('panierItems', 'total', 'nombreArticles'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function ajouter(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $client = Auth::user();

        // Vérifier le stock
        if ($produit->stock < $request->quantite) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        // Vérifier si le produit est déjà dans le panier
        $panierItem = Panier::where('client_id', $client->id)
            ->where('produit_id', $produit->id)
            ->first();

        if ($panierItem) {
            // Si déjà dans le panier, augmenter la quantité
            $panierItem->quantite += $request->quantite;
            $panierItem->save();
        } else {
            // Sinon, créer une nouvelle entrée
            Panier::create([
                'client_id' => $client->id,
                'produit_id' => $produit->id,
                'quantite' => $request->quantite,
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité
     */
    public function update(Request $request, Panier $panier)
    {
        // Vérifier que le panier appartient au client connecté
        if ($panier->client_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        // Vérifier le stock
        if ($panier->produit->stock < $request->quantite) {
            return back()->with('error', 'Stock insuffisant.');
        }

        $panier->quantite = $request->quantite;
        $panier->save();

        return back()->with('success', 'Quantité mise à jour.');
    }

    /**
     * Supprimer un produit du panier
     */
    public function supprimer(Panier $panier)
    {
        // Vérifier que le panier appartient au client connecté
        if ($panier->client_id !== Auth::id()) {
            abort(403);
        }

        $panier->delete();

        return back()->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vider le panier
     */
    public function vider()
    {
        Panier::where('client_id', Auth::id())->delete();

        return back()->with('success', 'Panier vidé.');
    }

    public function commanderDepuisPanier()
{
    $client = auth()->user();
    
    // Récupérer tous les articles du panier
    $panierItems = Panier::where('client_id', $client->id)
        ->with('produit')
        ->get();

    if ($panierItems->isEmpty()) {
        return redirect()->route('client.panier.index')
            ->with('error', 'Votre panier est vide.');
    }

    // Vérifier le stock de chaque produit
    foreach ($panierItems as $item) {
        if ($item->produit->stock < $item->quantite) {
            return back()->with('error', 
                "Stock insuffisant pour le produit : {$item->produit->nom}");
                 }
    }

    // Créer une commande pour chaque article du panier
    DB::transaction(function () use ($client, $panierItems) {
        foreach ($panierItems as $item) {
            // Créer la commande
            Commande::create([
                'client_id' => $client->id,
                'produit_id' => $item->produit_id,
                'artisan_id' => $item->produit->artisan_id,
                'quantite' => $item->quantite,
                'montant_total' => $item->produit->prix * $item->quantite,
                'statut' => 'en_attente',
            ]);

            // Décrémenter le stock
            $item->produit->decrement('stock', $item->quantite);
        }

        // Vider le panier après la commande
        Panier::where('client_id', $client->id)->delete();
    });
    return redirect()->route('client.commandes.index')
        ->with('success', '✅ Commande passée avec succès !');
}

/**
 * Commander un seul produit du panier
 */
public function commanderUnProduit(Panier $panier)
{
    // Vérifier que le panier appartient au client connecté
    if ($panier->client_id !== Auth::id()) {
        abort(403);
    }

    // Vérifier le stock
    if ($panier->produit->stock < $panier->quantite) {
        return back()->with('error', 'Stock insuffisant pour ce produit.');
    }

    // Créer la commande
    DB::transaction(function () use ($panier) {
        Commande::create([
            'client_id' => $panier->client_id,
            'produit_id' => $panier->produit_id,
            'artisan_id' => $panier->produit->artisan_id,
            'quantite' => $panier->quantite,
            'montant_total' => $panier->produit->prix * $panier->quantite,
            'statut' => 'en_attente',
            'notes' => 'Commande depuis le panier (produit individuel)',
        ]);

        // Décrémenter le stock
        $panier->produit->decrement('stock', $panier->quantite);

        // Supprimer ce produit du panier
        $panier->delete();
    });

    return redirect()->route('client.commandes.index')
        ->with('success', '✅ Produit commandé avec succès !');
}
}