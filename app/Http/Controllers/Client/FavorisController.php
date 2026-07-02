<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favori;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function index()
    {
        $favoris = Favori::with('produit.artisan.user')
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

        return view('client.favoris.index', compact('favoris'));
    }

    public function toggle(Produit $produit)
    {
        $favori = Favori::where('client_id', Auth::id())
            ->where('produit_id', $produit->id)
            ->first();

        if ($favori) {
            $favori->delete();
            return back()->with('success', 'Produit retiré des favoris');
        } else {
            Favori::create([
                'client_id' => Auth::id(),
                'produit_id' => $produit->id,
            ]);
            return back()->with('success', 'Produit ajouté aux favoris ❤️');
        }
    }
}