<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InvestisseurController extends Controller
{
    /**
     * Liste des investisseurs en attente de validation
     */
    public function index()
    {
        // On cherche les utilisateurs qui ont le rôle 'investisseur' et qui ne sont pas encore validés
        $investisseurs = User::where('role', 'investisseur')
            ->where('is_validated', false) // Adapte si ton champ s'appelle 'is_approved'
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.investisseurs.index', compact('investisseurs'));
    }

    /**
     * Valider le compte d'un investisseur
     */
    public function valider(User $user)
    {
        if ($user->role !== 'investisseur') {
            return back()->with('error', 'Cet utilisateur n\'est pas un investisseur.');
        }

        $user->update(['is_validated' => true]);

        // TODO: Envoyer une notification/email à l'investisseur
        
        return back()->with('success', '✅ Le compte de l\'investisseur a été validé avec succès.');
    }

    /**
     * Rejeter le compte d'un investisseur
     */
    public function rejeter(Request $request, User $user)
    {
        $request->validate(['motif' => 'required|string|max:500']);

        if ($user->role !== 'investisseur') {
            return back()->with('error', 'Cet utilisateur n\'est pas un investisseur.');
        }

        // Optionnel : tu peux garder is_validated à false, ou créer un champ 'is_rejected'
        $user->update([
            'is_validated' => false,
            'motif_rejet' => $request->motif // Si tu as ajouté ce champ
        ]);

        return back()->with('success', 'Le compte de l\'investisseur a été rejeté.');
    }
}