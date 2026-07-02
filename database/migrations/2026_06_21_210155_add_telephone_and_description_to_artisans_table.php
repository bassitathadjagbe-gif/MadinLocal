<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artisans', function (Blueprint $table) {
            // Ajouter telephone si elle n'existe pas
            if (!Schema::hasColumn('artisans', 'telephone')) {
                $table->string('telephone')->nullable()->after('specialite');
            }
            
            // Ajouter description si elle n'existe pas
            if (!Schema::hasColumn('artisans', 'description')) {
                $table->text('description')->nullable()->after('ville');
            }
        });
    }

    public function down(): void
    {
        Schema::table('artisans', function (Blueprint $table) {
            if (Schema::hasColumn('artisans', 'telephone')) {
                $table->dropColumn('telephone');
            }
            if (Schema::hasColumn('artisans', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};