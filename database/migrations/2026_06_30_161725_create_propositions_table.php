<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            
            // Acteurs
            $table->foreignId('investisseur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('artisan_id')->constrained('artisans')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Détails de la proposition
            $table->decimal('montant', 12, 2); // Montant proposé en FCFA
            $table->integer('duree_mois'); // Durée de remboursement
            $table->decimal('taux_roi', 5, 2); // Taux de retour (ex: 15.00 pour 15%)
            $table->decimal('montant_remboursement', 12, 2); // Montant total à rembourser
            $table->text('message')->nullable(); // Message de l'investisseur
            
            // Workflow de sécurité
            $table->enum('statut_admin', ['en_attente', 'validee', 'refusee'])->default('en_attente');
            $table->text('commentaire_admin')->nullable();
            $table->timestamp('admin_valide_at')->nullable();
            
            // Statut final (après accord de l'artisan)
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee', 'annulee', 'en_cours', 'terminee'])->default('en_attente');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propositions');
    }
};