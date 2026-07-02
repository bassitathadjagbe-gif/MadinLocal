<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    /**
     * Liste des artisans en attente de validation
     */
    public function index()
    {
        // On récupère uniquement les artisans NON vérifiés
        $artisans = Artisan::where('is_verified', false)
            ->with('user') // Pour avoir le nom et l'email de l'utilisateur
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.artisans.index', compact('artisans'));
    }

    /**
     * Valider un artisan
     */
    public function valider(Artisan $artisan)
    {
        $artisan->update(['is_verified' => true]);

        return back()->with('success', '✅ Le compte de l\'artisan a été validé avec succès. Il est maintenant visible par les investisseurs.');
    }

    /**
     * Rejeter un artisan
     */
    public function rejeter(Request $request, Artisan $artisan)
    {
        $request->validate([
            'motif' => 'required|string|max:500',
        ]);

        // Optionnel : tu peux supprimer le compte ou juste le laisser à false
        // $artisan->delete(); 

        return back()->with('success', 'Le compte de l\'artisan a été rejeté.');
    }
}