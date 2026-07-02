<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Afficher la page de paiement
     */
    public function show(Commande $commande)
    {
        // Vérifier que la commande appartient au client connecté
        if ($commande->client_id !== Auth::id()) {
            abort(403);
        }

        // Vérifier que la commande est en statut "acceptee"
        if ($commande->statut !== 'acceptee') {
            return redirect()->route('client.commandes.index')
                ->with('error', 'Cette commande ne peut pas être payée actuellement.');
        }

        return view('client.paiement.show', compact('commande'));
    }

    /**
     * Traiter le paiement
     */
    public function process(Request $request, Commande $commande)
    {
        // Vérifier que la commande appartient au client
        if ($commande->client_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'methode' => 'required|in:mobile_money,carte_bancaire,paiement_livraison',
            'operateur' => 'required_if:methode,mobile_money|in:MTN,Moov,Celtiis',
            'numero_telephone' => 'required_if:methode,mobile_money|string|max:20',
        ]);

        // Générer une référence unique de transaction
        $reference = 'PAY-' . strtoupper(Str::random(10)) . '-' . time();
        $numeroTransaction = 'TXN-' . date('Ymd') . '-' . rand(100000, 999999);

        // Créer le paiement en statut "en_cours" (comme une vraie API)
        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'client_id' => Auth::id(),
            'montant' => $commande->montant_total,
            'methode' => $request->methode,
            'statut' => 'en_cours', // En attente de confirmation API
            'reference' => $reference,
            'operateur' => $request->operateur,
            'numero_transaction' => $numeroTransaction,
            'details' => json_encode([
                'methode' => $request->methode,
                'operateur' => $request->operateur ?? null,
                'telephone' => $request->numero_telephone ?? null,
                'initie_a' => now()->toISOString(),
                'ip_client' => $request->ip(),
            ]),
        ]);


        return $this->simulerTraitementApi($paiement, $commande);
    }

    /**
     * Simule le traitement d'une vraie API de paiement
     * (Remplace le webhook de KKiaPay/FedaPay en démo)
     */
    private function simulerTraitementApi(Paiement $paiement, Commande $commande)
    {
        // Simulation : 95% de succès (comme une vraie API fiable)
        $success = rand(1, 100) <= 95;

        // Délai simulé de traitement (1-3 secondes)
        sleep(2);

        if ($success) {
            // Paiement réussi - Mise à jour comme un webhook le ferait
            $paiement->update([
                'statut' => 'reussi',
                'details' => json_encode(array_merge(
                    json_decode($paiement->details, true) ?? [],
                    [
                        'traite_a' => now()->toISOString(),
                        'frais_transaction' => round($commande->montant_total * 0.02, 2),
                        'statut_api' => 'SUCCESS',
                        'code_autorisation' => 'AUTH-' . strtoupper(Str::random(8)),
                    ]
                )),
            ]);

            // Mise à jour du statut de la commande
            $commande->update(['statut' => 'payee']);

            // Notification à l'artisan
            if ($commande->artisan && $commande->artisan->user) {
                $commande->artisan->user->notify(
                    new \App\Notifications\PaiementReussi($paiement)
                );
            }

            return view('client.paiement.success', compact('paiement', 'commande'));
        } else {
            // Paiement échoué
            $paiement->update([
                'statut' => 'echoue',
                'details' => json_encode(array_merge(
                    json_decode($paiement->details, true) ?? [],
                    [
                        'traite_a' => now()->toISOString(),
                        'statut_api' => 'FAILED',
                        'erreur' => 'Transaction declined by operator',
                        'code_erreur' => 'ERR-' . rand(100, 999),
                    ]
                )),
            ]);

            return view('client.paiement.failed', compact('paiement', 'commande'));
        }
    }

    /**
     * Callback (webhook) - Point d'entrée pour les vraies API
     * Cette méthode serait appelée par KKiaPay/FedaPay après le paiement
     */
    public function callback(Request $request)
    {
        /*
         * En production avec KKiaPay :
         * 
         * $reference = $request->input('transaction_id');
         * $status = $request->input('status');
         * 
         * $paiement = Paiement::where('reference', $reference)->first();
         * 
         * if ($paiement && $status === 'SUCCESS') {
         *     $paiement->update(['statut' => 'reussi']);
         *     $paiement->commande->update(['statut' => 'payee']);
         * }
         * 
         * return response()->json(['status' => 'ok']);
         */

        return response()->json(['status' => 'demo_mode']);
    }
}