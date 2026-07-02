<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nom_entreprise');
            $table->text('bio')->nullable();
            $table->string('specialite');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->integer('experience_annees')->default(0);
            $table->json('portfolio_images')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};
