<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'expediteur_id',
        'destinataire_id',
        'sujet',
        'contenu',
        'lu_a',
        'produit_id'
    ];

    protected $casts = [
        'lu_a' => 'datetime'
    ];

    // Relations
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // Vérifier si le message est lu
    public function estLu()
    {
        return $this->lu_a !== null;
    }

    // Marquer comme lu
    public function marquerCommeLu()
    {
        if (!$this->estLu()) {
            $this->update(['lu_a' => now()]);
        }
    }
}