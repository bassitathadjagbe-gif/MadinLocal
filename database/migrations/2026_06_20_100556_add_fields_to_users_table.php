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
        Schema::table('users', function (Blueprint $table) {
             $table->string('phone')->nullable()->after('email');
            // ✅ Plus de 'admin' dans l'enum
            $table->enum('role', ['artisan', 'client', 'investisseur'])->default('client')->after('phone');
            $table->string('avatar')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('avatar');
            // ✅ Nouveau champ booléen pour identifier l'admin
            $table->boolean('is_admin')->default(false)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['phone', 'role', 'avatar', 'is_active', 'is_admin']);
        });
    }
};
