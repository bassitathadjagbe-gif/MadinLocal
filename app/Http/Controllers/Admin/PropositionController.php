<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    /**
     * Liste des propositions en attente de validation
     */
    public function index()
    {
        $propositions = Proposition::where('statut_admin', 'en_attente')
            ->with('investisseur', 'artisan.user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.propositions.index', compact('propositions'));
    }

    /**
     * Valider une proposition (l'envoyer à l'artisan)
     */
public function valider(Request $request, Proposition $proposition)
{
    $request->validate([
        'commentaire' => 'nullable|string|max:500',
    ]);

    // ✅ DOUBLE VÉRIFICATION : L'artisan doit toujours être validé
    $artisan = $proposition->artisan;
    if (!$artisan->is_verified) {
        return back()->with('error', '❌ Impossible de valider : cet artisan n\'est pas encore vérifié par l\'administration.');
    }

    $proposition->update([
        'statut_admin' => 'validee',
        'admin_id' => Auth::id(),
        'commentaire_admin' => $request->commentaire,
        'admin_valide_at' => now(),
    ]);

    

    return back()->with('success', '✅ Proposition validée et envoyée à l\'artisan.');
}
    /**
     * Refuser une proposition
     */
    public function refuser(Request $request, Proposition $proposition)
    {
        $request->validate([
            'motif_refus' => 'required|string|max:500',
        ]);

        $proposition->update([
            'statut_admin' => 'refusee',
            'admin_id' => Auth::id(),
            'commentaire_admin' => $request->motif_refus,
            'admin_valide_at' => now(),
        ]);

        // TODO: Envoyer notification à l'investisseur
        // Notification::create([...])

        return back()->with('success', '❌ Proposition refusée. L\'investisseur a été notifié.');
    }

    /**
     * Historique de toutes les propositions traitées
     */
    public function historique()
    {
        $propositions = Proposition::where('statut_admin', '!=', 'en_attente')
            ->with('investisseur', 'artisan.user', 'admin')
            ->orderBy('admin_valide_at', 'desc')
            ->paginate(20);

        return view('admin.propositions.historique', compact('propositions'));
    }
}