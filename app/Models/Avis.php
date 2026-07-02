<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artisan_id',
        'commande_id',
        'note',
        'commentaire',
    ];

    // ===== RELATIONS =====

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

    // ===== OBSERVER : recalcule la note moyenne automatiquement =====

    protected static function booted()
    {
        static::saved(function ($avis) {
            $avis->artisan->recalculerNoteMoyenne();
        });

        static::deleted(function ($avis) {
            $avis->artisan->recalculerNoteMoyenne();
        });
    }

    // ===== HELPERS =====

    public function getEtoilesAttribute(): string
    {
        return str_repeat('⭐', $this->note);
    }
}