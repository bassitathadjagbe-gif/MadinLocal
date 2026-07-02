<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Liste des conversations
 public function index()
{
    $userId = Auth::id();
    
    // Récupérer tous les messages où l'utilisateur est impliqué
    $allMessages = Message::where('expediteur_id', $userId)
        ->orWhere('destinataire_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();
    
    // Grouper les messages par partenaire
    $conversationsMap = [];
    
    foreach ($allMessages as $message) {
        // Déterminer qui est le partenaire
        $partnerId = ($message->expediteur_id == $userId) 
            ? $message->destinataire_id 
            : $message->expediteur_id;
        
        // Si c'est la première fois qu'on voit ce partenaire
        if (!isset($conversationsMap[$partnerId])) {
            $conversationsMap[$partnerId] = [
                'partner_id' => $partnerId,
                'last_message' => $message,
                'unread_count' => 0
            ];
        }
        
        // Compter les messages non lus (reçus de ce partenaire)
        if ($message->expediteur_id == $partnerId 
            && $message->destinataire_id == $userId 
            && $message->lu_a === null) {
            $conversationsMap[$partnerId]['unread_count']++;
        }
    }
    
    // Récupérer les infos des partenaires
    $conversationsData = [];
    foreach ($conversationsMap as $partnerId => $data) {
        $partner = User::find($partnerId);
        if ($partner) {
            $conversationsData[] = [
                'partner' => $partner,
                'last_message' => $data['last_message'],
                'unread_count' => $data['unread_count']
            ];
        }
    }
    
    // Trier par date du dernier message (plus récent en premier)
    usort($conversationsData, function($a, $b) {
        return $b['last_message']->created_at <=> $a['last_message']->created_at;
    });
    
    return view('messages.index', compact('conversationsData'));
}
    // Conversation avec un utilisateur spécifique
    public function show($partnerId)
{
    $userId = Auth::id();
    $partner = User::findOrFail($partnerId);
    
    // Récupérer TOUS les messages entre les deux utilisateurs
    $messages = Message::where(function($q) use ($userId, $partnerId) {
            $q->where('expediteur_id', $userId)
              ->where('destinataire_id', $partnerId);
        })
        ->orWhere(function($q) use ($userId, $partnerId) {
            $q->where('expediteur_id', $partnerId)
              ->where('destinataire_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
    // 🐛 DEBUG : Logger les infos
    \Log::info('=== DEBUG CONVERSATION ===');
    \Log::info('User ID: ' . $userId);
    \Log::info('Partner ID: ' . $partnerId);
    \Log::info('Nombre de messages trouvés: ' . $messages->count());
    \Log::info('Messages:', $messages->toArray());
    
    // Marquer tous les messages reçus comme lus
    Message::where('expediteur_id', $partnerId)
        ->where('destinataire_id', $userId)
        ->whereNull('lu_a')
        ->update(['lu_a' => now()]);
    
    return view('messages.show', compact('partner', 'messages'));
}
    // Envoyer un message
   public function store(Request $request, $partnerId)
{
    $request->validate([
        'contenu' => 'required|string|max:1000',
        'produit_id' => 'nullable|integer|exists:produits,id'
    ]);

    // Créer le message
    $message = Message::create([
        'expediteur_id' => Auth::id(),
        'destinataire_id' => $partnerId,
        'sujet' => $request->sujet ?? null,
        'contenu' => $request->contenu,
        'produit_id' => $request->produit_id ?: null,  //Force null si vide
    ]);

    return redirect()->back()->with('success', 'Message envoyé !');
}

    // Formulaire de contact depuis un produit
    public function createFromProduit(Produit $produit)
    {
        if (!$produit->is_published || !$produit->is_validated) {
            abort(404);
        }

        $artisan = $produit->artisan->user;
        
        return view('messages.create', compact('produit', 'artisan'));
    }
}