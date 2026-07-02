<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifier la colonne statut pour ajouter 'payee' dans l'ENUM
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('en_attente', 'acceptee', 'payee', 'en_cours', 'terminee', 'refusee') DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre l'ENUM original (sans 'payee')
        DB::statement("ALTER TABLE commandes MODIFY COLUMN statut ENUM('en_attente', 'acceptee', 'en_cours', 'terminee', 'refusee') DEFAULT 'en_attente'");
    }
};