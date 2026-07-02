<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'artisan_id',
        'category_id',
        'nom',
        'description',
        'prix',
        'type',
        'stock',
        'images',
        'is_published',
        'is_validated',
        'is_rejected',
        'duree_minutes',     
         'lieu_prestation',  
         'sur_rdv',            
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'prix' => 'decimal:2',
            'is_published' => 'boolean',
            'is_validated' => 'boolean',
            'is_rejected' => 'boolean',
            'sur_rdv' => 'boolean',          
        'duree_minutes' => 'integer',     
        ];
    }

    // ===== RELATIONS =====

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    // ===== ACCESSEURS =====

    // Accessor pour l'image principale
    public function getImagePrincipaleAttribute()
    {
        if (is_array($this->images) && !empty($this->images)) {
            $image = $this->images[0];
            
            // Si c'est une URL externe (http/https), on la retourne telle quelle
            if (str_starts_with($image, 'http')) {
                return $image;
            }
            
            // Sinon, on retourne l'URL du storage local
            return asset('storage/' . $image);
        }
        return null;
    }

    // ===== MÉTHODES DE VÉRIFICATION DU TYPE =====

    /**
     * Vérifier si c'est un produit physique
     */
    public function isProduit(): bool
    {
        return $this->type === 'produit';
    }

    /**
     * Vérifier si c'est un service
     */
    public function isService(): bool
    {
        return $this->type === 'service';
    }

    /**
     * Obtenir le label du type
     */
    public function getTypeLabelAttribute(): string
    {
        return [
            'produit' => 'Produit physique',
            'service' => 'Service / Prestation',
        ][$this->type] ?? ucfirst($this->type);
    }

    /**
     * Obtenir l'icône du type
     */
    public function getTypeIconAttribute(): string
    {
        return [
            'produit' => 'bi-box-seam',
            'service' => 'bi-clock',
        ][$this->type] ?? 'bi-tag';
    }

    /**
     * Obtenir la couleur du badge
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return [
            'produit' => 'bg-success',
            'service' => 'bg-info',
        ][$this->type] ?? 'bg-secondary';
    }

    // ===== SCOPES =====

    // Scope pour les produits validés
    public function scopeValides($query)
    {
        return $query->where('is_validated', true)->where('is_published', true);
    }

    // Scope pour les produits physiques uniquement
    public function scopeProduitsPhysiques($query)
    {
        return $query->where('type', 'produit');
    }

    // Scope pour les services uniquement
    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }

    // Scope pour les produits en stock
    public function scopeEnStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}