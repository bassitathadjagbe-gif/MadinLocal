<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->integer('duree_minutes')->nullable()->after('stock');
            $table->string('lieu_prestation')->nullable()->after('duree_minutes');
            $table->boolean('sur_rdv')->default(false)->after('lieu_prestation');
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['duree_minutes', 'lieu_prestation', 'sur_rdv']);
        });
    }
};