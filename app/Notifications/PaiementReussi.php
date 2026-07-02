<?php

namespace App\Notifications;

use App\Models\Paiement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaiementReussi extends Notification
{
    use Queueable;

    protected $paiement;

    public function __construct(Paiement $paiement)
    {
        $this->paiement = $paiement;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'paiement_reussi',
            'titre' => 'Paiement reçu',
            'message' => "Vous avez reçu un paiement de " . number_format($this->paiement->montant, 0, ',', ' ') . " FCFA pour la commande #{$this->paiement->commande_id}.",
            'commande_id' => $this->paiement->commande_id,
            'url' => route('artisan.commandes.show', $this->paiement->commande),
            'icon' => 'bi-cash-coin',
            'color' => 'success',
        ];
    }
}