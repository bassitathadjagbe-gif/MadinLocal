<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    public function toggle(Produit $produit)
    {
        $client = Auth::user();
        
        // Vérifier si le produit est déjà en favori
        $favori = Favori::where('client_id', $client->id)
                        ->where('produit_id', $produit->id)
                        ->first();

        if ($favori) {
            // Si oui, on le retire
            $favori->delete();
            return back()->with('success', 'Produit retiré des favoris.');
        } else {
            // Sinon, on l'ajoute
            Favori::create([
                'client_id' => $client->id,
                'produit_id' => $produit->id
            ]);
            return back()->with('success', '❤️ Produit ajouté aux favoris !');
        }
    }
}