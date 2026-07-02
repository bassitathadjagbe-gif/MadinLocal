<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Couture & Textile', 'description' => 'Vêtements, tissus, accessoires textiles', 'icone' => 'bi-scissors'],
            ['nom' => 'Menuiserie', 'description' => 'Meubles, objets en bois, sculptures', 'icone' => 'bi-hammer'],
            ['nom' => 'Art & Décoration', 'description' => 'Tableaux, sculptures, objets décoratifs', 'icone' => 'bi-palette'],
            ['nom' => 'Bijoux', 'description' => 'Bijoux fantaisie, bijoux traditionnels', 'icone' => 'bi-gem'],
            ['nom' => 'Agroalimentaire', 'description' => 'Produits alimentaires artisanaux', 'icone' => 'bi-cup-hot'],
            ['nom' => 'Coiffure & Beauté', 'description' => 'Soins capillaires, cosmétiques naturels', 'icone' => 'bi-brush'],
            ['nom' => 'Poterie & Céramique', 'description' => 'Objets en argile, poteries traditionnelles', 'icone' => 'bi-flower1'],
            ['nom' => 'Vannerie', 'description' => 'Paniers, objets tressés', 'icone' => 'bi-basket'],
        ];

        foreach ($categories as $categorie) {
            Categorie::create($categorie);
        }

        $this->command->info('✅ ' . count($categories) . ' catégories créées !');
    }
}