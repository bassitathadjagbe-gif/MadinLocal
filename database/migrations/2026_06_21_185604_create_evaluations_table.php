<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('artisan_id')->constrained('artisans')->onDelete('cascade');
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('set null');
            
            $table->integer('note')->default(5); // 1 à 5 étoiles
            $table->text('commentaire')->nullable();
            
            $table->timestamps();
            
            // Un seul avis par commande
            $table->unique('commande_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};