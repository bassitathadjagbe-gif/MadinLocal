<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NouvelleCommande extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'nouvelle_commande',
            'titre' => 'Nouvelle commande reçue',
            'message' => "Vous avez reçu une nouvelle commande pour '{$this->commande->produit->nom}' de la part de {$this->commande->client->name}.",
            'commande_id' => $this->commande->id,
            'url' => route('artisan.commandes.show', $this->commande),
            'icon' => 'bi-bag',
            'color' => 'primary',
        ];
    }
}