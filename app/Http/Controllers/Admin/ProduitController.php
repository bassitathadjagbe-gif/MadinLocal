<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    // Liste de tous les produits avec filtres
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'en_attente');
        
        $query = Produit::with(['artisan.user', 'category']);
        
        switch ($filter) {
            case 'valides':
                $query->where('is_validated', true);
                break;
            case 'rejetes':
                $query->where('is_rejected', true);
                break;
            case 'en_attente':
            default:
                $query->where('is_validated', false)->where('is_rejected', false);
                break;
        }
        
        $produits = $query->latest()->paginate(15);
        
        // Compteurs
        $enAttente = Produit::where('is_validated', false)->where('is_rejected', false)->count();
        $valides = Produit::where('is_validated', true)->count();
        $rejetes = Produit::where('is_rejected', true)->count();
        
        return view('admin.produits.index', compact('produits', 'filter', 'enAttente', 'valides', 'rejetes'));
    }

/**
 * Valider un produit
 */
public function validateProduit(Produit $produit)
{
     // Vérifier si le produit est déjà validé
    if ($produit->is_validated) {
        return back()->with('error', ' Ce produit est déjà validé.');
    }

    // Vérifier si l'artisan existe
    if (!$produit->artisan) {
        return back()->with('error', '❌ L\'artisan associé à ce produit n\'existe plus.');
    }

    try {
        $produit->update(['is_validated' => true]);
        return back()->with('success', '✅ Produit validé avec succès !');
    } catch (\Exception $e) {
        // Log l'erreur
        Log::error('Erreur lors de la validation du produit: ' . $e->getMessage());
        return back()->with('error', '❌ Une erreur est survenue lors de la validation.');
    }
    $produit->update([
        'is_validated' => true,
        'is_published' => true,
        'is_rejected' => false,
    ]);

    return back()->with('success', '✅ Produit validé avec succès !');
}

/**
 * Rejeter/Dévalider un produit
 */
public function reject(Produit $produit)
{
    $produit->update([
        'is_rejected' => true,
        'is_published' => false,
        'is_validated' => false,
    ]);

    return back()->with('success', '❌ Produit dévalidé.');
}
    // Supprimer un produit
    public function destroy(Produit $produit)
    {
        if ($produit->images) {
            foreach ($produit->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $nom = $produit->nom;
        $produit->delete();

        return back()->with('success', '🗑️ Produit "' . $nom . '" supprimé définitivement.');
    }

    /**
 * Afficher les détails d'un produit
 */
public function show(Produit $produit)
{
    $produit->load(['artisan.user', 'category']);
    return view('admin.produits.show', compact('produit'));
}

}