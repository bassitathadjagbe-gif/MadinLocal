<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    /**
     * Afficher le formulaire de prise de rendez-vous
     */
    public function create(Produit $service)
    {
        // Vérifier que c'est bien un service
        if (!$service->isService()) {
            return redirect()->route('catalogue')->with('error', 'Ce produit n\'est pas un service.');
        }

        return view('client.rendez_vous.create', compact('service'));
    }

    /**
     * Enregistrer le rendez-vous
     */
    public function store(Request $request, Produit $service)
    {
        $request->validate([
            'date_rdv' => 'required|date|after_or_equal:today',
            'heure_rdv' => 'required|date_format:H:i',
            'lieu' => 'required|string|max:255',
            'telephone_contact' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $rdv = RendezVous::create([
            'client_id' => Auth::id(),
            'service_id' => $service->id,
            'artisan_id' => $service->artisan_id,
            'date_rdv' => $request->date_rdv,
            'heure_rdv' => $request->heure_rdv,
            'duree_minutes' => $service->duree_minutes ?? 60,
            'lieu' => $request->lieu,
            'telephone_contact' => $request->telephone_contact,
            'notes' => $request->notes,
            'montant' => $service->prix,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('client.rendez_vous.confirmation', $rdv)
            ->with('success', 'Votre demande de rendez-vous a été envoyée !');
    }

    /**
     * Page de confirmation
     */
    public function confirmation(RendezVous $rdv)
    {
        if ($rdv->client_id !== Auth::id()) {
            abort(403);
        }

        return view('client.rendez_vous.confirmation', compact('rdv'));
    }

    /**
     * Liste des rendez-vous du client
     */
    public function index()
    {
        $rdvs = RendezVous::with(['service', 'artisan.user'])
            ->where('client_id', Auth::id())
            ->orderBy('date_rdv', 'desc')
            ->paginate(10);

        return view('client.rendez_vous.index', compact('rdvs'));
    }
}