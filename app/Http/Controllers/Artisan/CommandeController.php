<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Afficher la liste des commandes de l'artisan
     */
    public function index()
    {
        $commandes = Commande::where('artisan_id', Auth::user()->artisan->id)
            ->with('client', 'produit')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('commandes.artisan.index', compact('commandes'));
    }

    /**
     * Accepter une commande
     */
    public function accepter(Commande $commande)
    {
        // Vérifier que la commande appartient bien à cet artisan
        if ($commande->artisan_id !== Auth::user()->artisan->id) {
            abort(403, 'Action non autorisée');
        }

        // Vérifier que la commande est en attente
        if ($commande->statut !== 'en_attente') {
            return back()->with('error', 'Cette commande ne peut plus être acceptée.');
        }

        $commande->statut = 'acceptee';
        $commande->save();

        return back()->with('success', '✅ Commande acceptée avec succès !');
    }

    /**
     * Refuser une commande
     */
    public function refuser(Commande $commande)
    {
        // Vérifier que la commande appartient bien à cet artisan
        if ($commande->artisan_id !== Auth::user()->artisan->id) {
            abort(403, 'Action non autorisée');
        }

        // Vérifier que la commande est en attente
        if ($commande->statut !== 'en_attente') {
            return back()->with('error', 'Cette commande ne peut plus être refusée.');
        }

        $commande->statut = 'refusee';
        $commande->save();

        return back()->with('success', 'Commande refusée.');
    }
}