<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter 'admin' aux valeurs possibles du ENUM role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'artisan', 'investisseur', 'admin') DEFAULT 'client'");
    }

    public function down(): void
    {
        // Remettre l'ENUM original (sans 'admin')
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('client', 'artisan', 'investisseur') DEFAULT 'client'");
    }
};