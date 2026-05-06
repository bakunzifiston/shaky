<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('inventory_records')) {
            Schema::table('inventory_records', function (Blueprint $table) {
                if (!Schema::hasColumn('inventory_records', 'unit_cost')) {
                    $table->decimal('unit_cost', 12, 2)->nullable()->after('record_date');
                }
                if (!Schema::hasColumn('inventory_records', 'product_id')) {
                    $table->foreignId('product_id')->nullable()->after('item_name')->constrained()->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('inventory_records')) {
            Schema::table('inventory_records', function (Blueprint $table) {
                if (Schema::hasColumn('inventory_records', 'product_id')) {
                    $table->dropConstrainedForeignId('product_id');
                }
                $drop = [];
                if (Schema::hasColumn('inventory_records', 'unit_cost')) {
                    $drop[] = 'unit_cost';
                }
                if ($drop !== []) {
                    $table->dropColumn($drop);
                }
            });
        }
    }
};
