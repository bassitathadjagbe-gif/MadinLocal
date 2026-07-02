<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'client_id',
        'artisan_id',
        'commande_id',
        'produit_id',
        'note',
        'commentaire'
    ];

    protected $casts = [
        'note' => 'integer'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // Générer les étoiles HTML
    public function getEtoilesHtmlAttribute()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->note 
                ? '<i class="bi bi-star-fill text-warning"></i>' 
                : '<i class="bi bi-star text-muted"></i>';
        }
        return $html;
    }
}