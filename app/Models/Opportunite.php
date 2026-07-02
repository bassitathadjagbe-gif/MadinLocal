<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunite extends Model
{
    use HasFactory;

    protected $fillable = [
        'investisseur_id',
        'artisan_id',
        'type',
        'montant_propose',
        'message',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'montant_propose' => 'decimal:2',
        ];
    }

    // ===== RELATIONS =====

    public function investisseur()
    {
        return $this->belongsTo(Investisseur::class);
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }
}