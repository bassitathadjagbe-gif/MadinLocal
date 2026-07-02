<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Expéditeur (peut être client ou artisan)
            $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade');
            
            // Destinataire (peut être client ou artisan)
            $table->foreignId('destinataire_id')->constrained('users')->onDelete('cascade');
            
            // Contenu du message
            $table->text('contenu');
            
            // Statut de lecture
            $table->timestamp('lu_a')->nullable();
            
            // Référence optionnelle à un produit
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};