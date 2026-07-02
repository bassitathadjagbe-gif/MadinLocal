<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'bio',
        'specialite',
        'category_id',
        'adresse',
        'ville',
        'experience_annees',
        'portfolio_images',
        'is_verified',
        'average_rating',
    ];

    protected function casts(): array
    {
        return [
            'portfolio_images' => 'array',
            'is_verified' => 'boolean',
            'average_rating' => 'decimal:2',
        ];
    }

    // ===== RELATIONS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function opportunites()
    {
        return $this->hasMany(Opportunite::class);
    }

    // ===== HELPERS =====

    public function recalculerNoteMoyenne(): void
    {
        $this->average_rating = $this->avis()->avg('note') ?? 0;
        $this->save();
    }

    public function getNomCompletAttribute(): string
    {
        return $this->user->name ?? 'Artisan';
    }

    public function evaluations()
{
    return $this->hasMany(Evaluation::class);
}

// Note moyenne calculée
public function getNoteMoyenneAttribute()
{
    return $this->evaluations()->avg('note') ?? 0;
}

public function getNombreEvaluationsAttribute()
{
    return $this->evaluations()->count();
}
}