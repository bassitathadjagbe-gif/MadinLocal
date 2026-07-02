<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icone',
    ];

    // Génération automatique du slug
    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // ===== RELATIONS =====

    public function artisans()
    {
        return $this->hasMany(Artisan::class, 'category_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'category_id');
    }
}