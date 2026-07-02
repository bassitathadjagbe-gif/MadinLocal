<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'client_id',
        'service_id',
        'artisan_id',
        'date_rdv',
        'heure_rdv',
        'duree_minutes',
        'lieu',
        'notes',
        'telephone_contact',
        'montant',
        'statut',
    ];

    protected $casts = [
        'date_rdv' => 'date',
        'heure_rdv' => 'datetime:H:i',
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Produit::class, 'service_id');
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    // Accessors
    public function getStatutLabelAttribute()
    {
        return [
            'en_attente' => 'En attente',
            'confirme' => 'Confirmé',
            'annule' => 'Annulé',
            'termine' => 'Terminé',
        ][$this->statut] ?? $this->statut;
    }

    public function getStatutBadgeClassAttribute()
    {
        return [
            'en_attente' => 'bg-warning',
            'confirme' => 'bg-success',
            'annule' => 'bg-danger',
            'termine' => 'bg-info',
        ][$this->statut] ?? 'bg-secondary';
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeConfirmes($query)
    {
        return $query->where('statut', 'confirme');
    }
}