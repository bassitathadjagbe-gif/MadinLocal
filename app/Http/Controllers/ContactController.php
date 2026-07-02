<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Afficher le formulaire
    public function index()
    {
        return view('contact');
    }

    // Traiter l'envoi du formulaire
    public function send(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Pour la soutenance, on simule l'envoi avec un message de succès
        // (En production, on utiliserait Mail::to(...)->send(...) ici)
        
        return back()->with('success', '✅ Votre message a bien été envoyé ! Notre équipe vous répondra dans les plus brefs délais.');
    }
}