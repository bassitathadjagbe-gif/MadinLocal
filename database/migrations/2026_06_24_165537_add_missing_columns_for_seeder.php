<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table artisans
        if (!Schema::hasColumn('artisans', 'is_approved')) {
            Schema::table('artisans', function (Blueprint $table) {
                $table->boolean('is_approved')->default(false)->after('description');
            });
        }

        // Table investisseurs
        if (!Schema::hasColumn('investisseurs', 'entreprise')) {
            Schema::table('investisseurs', function (Blueprint $table) {
                $table->string('entreprise')->nullable()->after('user_id');
                $table->string('type_investissement')->nullable()->after('entreprise');
                $table->decimal('budget_min', 12, 2)->nullable()->after('type_investissement');
                $table->decimal('budget_max', 12, 2)->nullable()->after('budget_min');
                $table->text('description')->nullable()->after('budget_max');
                $table->boolean('is_approved')->default(false)->after('description');
            });
        }

        // Table produits
        if (!Schema::hasColumn('produits', 'is_validated')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->boolean('is_validated')->default(false)->after('artisan_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('artisans', 'is_approved')) {
            Schema::table('artisans', function (Blueprint $table) {
                $table->dropColumn('is_approved');
            });
        }

        if (Schema::hasColumn('investisseurs', 'entreprise')) {
            Schema::table('investisseurs', function (Blueprint $table) {
                $table->dropColumn(['entreprise', 'type_investissement', 'budget_min', 'budget_max', 'description', 'is_approved']);
            });
        }

        if (Schema::hasColumn('produits', 'is_validated')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->dropColumn('is_validated');
            });
        }
    }
};