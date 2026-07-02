<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
         'avatar',
        'password',
        'is_active',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }

    // ===== RELATIONS =====

    public function artisan()
    {
        return $this->hasOne(Artisan::class);
    }

    public function investisseur()
    {
        return $this->hasOne(Investisseur::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'client_id');
    }

   // Messages envoyés
public function messagesEnvoyes()
{
    return $this->hasMany(Message::class, 'expediteur_id');
}

// Messages reçus
public function messagesRecus()
{
    return $this->hasMany(Message::class, 'destinataire_id');
}

// Obtenir tous les partenaires de conversation
public function getConversationsPartnersAttribute()
{
    $envoyesA = Message::where('expediteur_id', $this->id)
        ->pluck('destinataire_id');
    
    $recusDe = Message::where('destinataire_id', $this->id)
        ->pluck('expediteur_id');
    
    $partenaires = $envoyesA->merge($recusDe)->unique();
    
    return User::whereIn('id', $partenaires)->get();
}

// Compter les messages non lus
public function getNonLusCountAttribute()
{
    return Message::where('destinataire_id', $this->id)
        ->whereNull('lu_a')
        ->count();
}

// Favoris du client
public function favoris()
{
    return $this->hasMany(Favori::class, 'client_id');
}



    // ===== HELPERS =====

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function isArtisan(): bool
    {
        return $this->role === 'artisan';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isInvestisseur(): bool
    {
        return $this->role === 'investisseur';
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png');
    }

    public function evaluationsDonnees()
{
    return $this->hasMany(Evaluation::class, 'client_id');
}
}