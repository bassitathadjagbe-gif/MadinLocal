<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommandeAcceptee extends Notification
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
            'type' => 'commande_acceptee',
            'titre' => 'Commande acceptée',
            'message' => "Votre commande pour '{$this->commande->produit->nom}' a été acceptée par l'artisan. Vous pouvez maintenant procéder au paiement.",
            'commande_id' => $this->commande->id,
            'url' => route('client.paiement.show', $this->commande),
            'icon' => 'bi-check-circle',
            'color' => 'success',
        ];
    }
}