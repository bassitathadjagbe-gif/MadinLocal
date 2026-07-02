<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $fillable = [
        'investisseur_id',
        'artisan_id',
        'admin_id',
        'montant',
        'duree_mois',
        'taux_roi',
        'montant_remboursement',
        'message',
        'statut_admin',
        'commentaire_admin',
        'admin_valide_at',
        'statut',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'taux_roi' => 'decimal:2',
        'montant_remboursement' => 'decimal:2',
        'admin_valide_at' => 'datetime',
    ];

    // Relations
    public function investisseur()
    {
        return $this->belongsTo(User::class, 'investisseur_id');
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class, 'artisan_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Scopes (filtres réutilisables)
    public function scopeEnAttenteAdmin($query)
    {
        return $query->where('statut_admin', 'en_attente');
    }

    public function scopeValideesParAdmin($query)
    {
        return $query->where('statut_admin', 'validee');
    }

    public function scopeRefuseesParAdmin($query)
    {
        return $query->where('statut_admin', 'refusee');
    }
}