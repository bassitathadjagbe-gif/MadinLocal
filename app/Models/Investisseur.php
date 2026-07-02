<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entreprise',
        'type_investissement',
        'budget_min',
        'budget_max',
        'description',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'budget_min' => 'decimal:2',
            'budget_max' => 'decimal:2',
            'is_approved' => 'boolean',
        ];
    }

    // ===== RELATIONS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opportunites()
    {
        return $this->hasMany(Opportunite::class);
    }
}