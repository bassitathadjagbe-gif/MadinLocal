<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    /**
     * Liste des propositions validées par l'admin (en attente de réponse de l'artisan)
     */
    public function index()
    {
        $artisan = Auth::user()->artisan;

        $propositions = Proposition::where('artisan_id', $artisan->id)
            ->where('statut_admin', 'validee')
            ->where('statut', 'en_attente')
            ->with('investisseur')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('artisan.propositions.index', compact('propositions'));
    }

    /**
     * Accepter une proposition
     */
    public function accepter(Request $request, Proposition $proposition)
    {
        $artisan = Auth::user()->artisan;

        if ($proposition->artisan_id !== $artisan->id) {
            return back()->with('error', '❌ Cette proposition ne vous concerne pas.');
        }

        if ($proposition->statut_admin !== 'validee') {
            return back()->with('error', '❌ Cette proposition n\'a pas encore été validée par l\'administrateur.');
        }

        if ($proposition->statut !== 'en_attente') {
            return back()->with('error', '❌ Vous avez déjà répondu à cette proposition.');
        }

        $proposition->update([
            'statut' => 'acceptee',
        ]);

        return back()->with('success', '✅ Proposition acceptée ! L\'investisseur sera notifié pour procéder au paiement.');
    }

    /**
     * Refuser une proposition
     */
    public function refuser(Request $request, Proposition $proposition)
    {
        $artisan = Auth::user()->artisan;

        if ($proposition->artisan_id !== $artisan->id) {
            return back()->with('error', '❌ Cette proposition ne vous concerne pas.');
        }

        if ($proposition->statut_admin !== 'validee') {
            return back()->with('error', '❌ Cette proposition n\'a pas encore été validée par l\'administrateur.');
        }

        if ($proposition->statut !== 'en_attente') {
            return back()->with('error', '❌ Vous avez déjà répondu à cette proposition.');
        }

        $request->validate([
            'motif_refus' => 'nullable|string|max:500',
        ]);

        $proposition->update([
            'statut' => 'refusee',
        ]);

        return back()->with('success', 'Proposition refusée. L\'investisseur a été notifié.');
    }

    /**
     * Historique de toutes les propositions reçues
     */
    public function historique()
    {
        $artisan = Auth::user()->artisan;

        $propositions = Proposition::where('artisan_id', $artisan->id)
            ->where('statut_admin', 'validee')
            ->whereIn('statut', ['acceptee', 'refusee', 'en_cours', 'terminee'])
            ->with('investisseur')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('artisan.propositions.historique', compact('propositions'));
    }
}