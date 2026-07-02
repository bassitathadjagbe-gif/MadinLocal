<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'app_notifications';
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope pour les notifications non lues
    public function scopeNonLues($query)
    {
        return $query->whereNull('read_at');
    }

    // Scope pour les notifications lues
    public function scopeLues($query)
    {
        return $query->whereNotNull('read_at');
    }

    // Méthode pour marquer comme lue
    public function marquerCommeLue()
    {
        return $this->update(['read_at' => now()]);
    }

    // Icône selon le type
    public function getIconAttribute()
    {
        return [
            'commande_acceptee' => 'bi-check-circle text-success',
            'commande_refusee' => 'bi-x-circle text-danger',
            'commande_terminee' => 'bi-check2-all text-info',
            'paiement_reussi' => 'bi-credit-card text-success',
            'nouveau_message' => 'bi-chat-dots text-primary',
            'rendez_vous_confirme' => 'bi-calendar-check text-warning',
        ][$this->type] ?? 'bi-bell text-secondary';
    }

    public function getLinkAttribute()
{
    $data = $this->data ?? [];
    
    return match($this->type) {
        'commande_acceptee', 'commande_refusee', 'commande_terminee' => 
            route('commandes.client.show', $data['commande_id'] ?? 0),
        'paiement_reussi' => 
            route('client.commandes.show', $data['commande_id'] ?? 0),
        'rendez_vous_confirme' => 
            route('client.rendez_vous.index'),
        default => '#',
    };
}
}