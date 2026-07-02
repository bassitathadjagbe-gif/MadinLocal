<?php

namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProduitValide extends Notification
{
    use Queueable;

    protected $produit;

    public function __construct(Produit $produit)
    {
        $this->produit = $produit;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'produit_valide',
            'titre' => 'Produit validé',
            'message' => "Votre produit '{$this->produit->nom}' a été validé par l'administrateur et est maintenant visible dans le catalogue.",
            'produit_id' => $this->produit->id,
            'url' => route('produit.show', $this->produit),
            'icon' => 'bi-patch-check',
            'color' => 'success',
        ];
    }
}