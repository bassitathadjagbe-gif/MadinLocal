<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $fillable = [
        'client_id',
        'produit_id',
        'quantite',
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // Calculer le sous-total pour ce produit
    public function getSousTotalAttribute()
    {
        return $this->produit->prix * $this->quantite;
    }
}