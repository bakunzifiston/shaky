<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->change();
            $table->foreignId('production_id')->nullable()->change();
            $table->decimal('quantity_sold', 10, 2)->nullable()->change();
            $table->decimal('selling_price', 10, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable(false)->change();
            $table->foreignId('production_id')->nullable(false)->change();
            $table->decimal('quantity_sold', 10, 2)->nullable(false)->change();
            $table->decimal('selling_price', 10, 2)->nullable(false)->change();
        });
    }
};
