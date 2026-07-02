<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'artisan_id', 'produit_id', 
        'quantite','montant_total', 
        'statut', 'message_client', 'notes_artisan'
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // Helpers pour les statuts (couleurs Bootstrap)
    public function getStatutBadgeClassAttribute()
{
    return [
        'en_attente' => 'bg-warning',
        'acceptee' => 'bg-info',
        'payee' => 'bg-success', // ✅ Ajouté
        'en_cours' => 'bg-primary',
        'terminee' => 'bg-success',
        'refusee' => 'bg-danger',
    ][$this->statut] ?? 'bg-secondary';
}

   public function getStatutLabelAttribute()
{
    return [
        'en_attente' => 'En attente',
        'acceptee' => 'Acceptée',
        'payee' => 'Payée', 
        'en_cours' => 'En cours',
        'terminee' => 'Terminée',
        'refusee' => 'Refusée',
    ][$this->statut] ?? $this->statut;
}

    public function evaluation()
{
    return $this->hasOne(Evaluation::class);
}

// Vérifier si la commande a été évaluée
public function getEstEvalueeAttribute()
{
    return $this->evaluation()->exists();
}
}