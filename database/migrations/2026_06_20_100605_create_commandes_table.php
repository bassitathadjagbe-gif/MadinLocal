<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            // Le client est un utilisateur (table users)
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            // L'artisan
            $table->foreignId('artisan_id')->constrained('artisans')->onDelete('cascade');
            // Le produit commandé
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            
            $table->integer('quantite')->default(1);
            $table->decimal('montant_total', 10, 2);
            $table->string('message_client');
            
            // Statuts possibles
            $table->enum('statut', [
                'en_attente',    // Commande envoyée
                'acceptee',      // Artisan a accepté
                'refusee',       // Artisan a refusé
                'en_cours',      // En préparation
                'terminee',      // Livré/Fini
                'annulee'        // Annulé
            ])->default('en_attente');
            
            $table->text('notes_client')->nullable(); // Message du client
            $table->text('notes_artisan')->nullable(); // Message de l'artisan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};