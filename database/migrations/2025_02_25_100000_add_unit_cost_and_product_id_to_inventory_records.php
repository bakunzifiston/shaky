<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_records', 'unit_cost')) {
                $table->decimal('unit_cost', 12, 2)->nullable()->after('record_date');
            }
            if (!Schema::hasColumn('inventory_records', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('item_name')->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['unit_cost', 'product_id']);
        });
    }
};
