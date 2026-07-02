<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $artisan = Auth::user()->artisan;
        $produits = $artisan->produits()->with('category')->latest()->paginate(10);
        return view('artisan.produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('artisan.produits.create', compact('categories'));
    }

    public function store(Request $request)
{
    
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'type' => 'required|in:produit,service',
        'stock' => 'nullable|integer|min:0',
        'duree_minutes' => 'nullable|integer|min:0',
        'lieu_prestation' => 'nullable|string|max:255',
        'sur_rdv' => 'nullable|boolean',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
        // Messages personnalisés
        'nom.required' => 'Le nom du produit est obligatoire.',
        'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
        'prix.required' => 'Le prix est obligatoire.',
        'prix.numeric' => 'Le prix doit être un nombre.',
        'prix.min' => 'Le prix ne peut pas être négatif.',
        'description.required' => 'La description est obligatoire.',
    ]);

    // Gérer les images
    $imagesPaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('produits', 'public');
            $imagesPaths[] = $path;
        }
    }

    // Créer le produit/service
    $produit = Produit::create([
        'artisan_id' => auth()->user()->artisan->id,
        'category_id' => $request->category_id,
        'nom' => $request->nom,
        'description' => $request->description,
        'prix' => $request->prix,
        'type' => $request->type,
        'stock' => $request->type === 'produit' ? ($request->stock ?? 0) : 0,
        'duree_minutes' => $request->type === 'service' ? $request->duree_minutes : null,
        'lieu_prestation' => $request->type === 'service' ? $request->lieu_prestation : null,
        'sur_rdv' => $request->type === 'service' ? ($request->sur_rdv ?? false) : false,
        'images' => $imagesPaths,
        'is_published' => $request->has('is_published'),
        'is_validated' => false,
        'is_rejected' => false,
    ]);

    return redirect()->route('artisan.produits.index')
        ->with('success', ucfirst($request->type) . ' ajouté avec succès ! En attente de validation.');
}

    public function show(Produit $produit)
    {
        // Vérifier que le produit appartient à l'artisan connecté
        $this->verifierProprietaire($produit);
        return view('artisan.produits.show', compact('produit'));
    }

    public function edit(Produit $produit)
    {
        // ✅ Vérification simple au lieu de authorize()
        $this->verifierProprietaire($produit);
        
        $categories = Categorie::all();
        return view('artisan.produits.edit', compact('produit', 'categories'));
    }

   public function update(Request $request, Produit $produit)
{
    $this->verifierProprietaire($produit);

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'type' => 'required|in:produit,service',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'new_images' => 'nullable|array|max:5',
        'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
    ], [
        'nom.required' => 'Le nom est obligatoire.',
        'description.required' => 'La description est obligatoire.',
        'prix.required' => 'Le prix est obligatoire.',
        'type.required' => 'Le type est obligatoire.',
        'stock.required' => 'Le stock est obligatoire.',
        'category_id.required' => 'La catégorie est obligatoire.',
        'new_images.max' => 'Vous ne pouvez ajouter que 5 images maximum.',
        'new_images.*.image' => 'Les fichiers doivent être des images.',
        'new_images.*.max' => 'Chaque image ne doit pas dépasser 2 Mo.',
    ]);

    // Récupérer les images actuelles
    $currentImages = $produit->images ?? [];

  // Supprimer les images cochées
$imagesToDelete = $request->input('delete_images', []);

// Filtrer les valeurs vides (images non cochées)
$imagesToDelete = array_filter($imagesToDelete, function($path) {
    return !empty($path);
});

if (count($imagesToDelete) > 0) {
    foreach ($imagesToDelete as $imagePath) {
        // Supprimer le fichier physique
        Storage::disk('public')->delete($imagePath);
        
        // Retirer du tableau d'images
        $key = array_search($imagePath, $currentImages);
        if ($key !== false) {
            unset($currentImages[$key]);
        }
    }
    
    // Réindexer le tableau
    $currentImages = array_values($currentImages);
}

    // Ajouter les nouvelles images
    if ($request->hasFile('new_images')) {
        $maxNewImages = 5 - count($currentImages);
        $newImages = $request->file('new_images');
        
        // Limiter au nombre d'images autorisées
        $newImages = array_slice($newImages, 0, $maxNewImages);
        
        foreach ($newImages as $image) {
            $path = $image->store('produits', 'public');
            $currentImages[] = $path;
        }
    }

    // Mettre à jour le produit
    $produit->update([
        'nom' => $validated['nom'],
        'description' => $validated['description'],
        'prix' => $validated['prix'],
        'type' => $validated['type'],
        'stock' => $validated['stock'],
        'category_id' => $validated['category_id'],
        'images' => $currentImages,
    ]);

    return redirect()->route('artisan.produits.index')
        ->with('success', '✅ Produit modifié avec succès !');
}
    public function destroy(Produit $produit)
    {
        $this->verifierProprietaire($produit);

        // Supprimer les images
        if ($produit->images) {
            foreach ($produit->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $produit->delete();

        return redirect()->route('artisan.produits.index')
            ->with('success', 'Produit supprimé !');
    }

    // ✅ MÉTHODE HELPER : Vérifie que l'artisan est bien le propriétaire du produit
    private function verifierProprietaire(Produit $produit)
    {
        $artisan = Auth::user()->artisan;
        
        if ($produit->artisan_id !== $artisan->id) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce produit.');
        }
    }
}