<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sale_items')) {
            Schema::create('sale_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sale_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('production_id')->constrained('productions')->onDelete('cascade');
                $table->decimal('quantity_sold', 10, 2);
                $table->decimal('unit_price', 10, 2);
                $table->decimal('line_total', 12, 2);
                $table->timestamps();
            });

            // Migrate existing sales to sale_items only when legacy sales table exists.
            if (Schema::hasTable('sales')) {
                $sales = DB::table('sales')->get();
                foreach ($sales as $sale) {
                    if ($sale->product_id && $sale->production_id) {
                        DB::table('sale_items')->insert([
                            'sale_id' => $sale->id,
                            'product_id' => $sale->product_id,
                            'production_id' => $sale->production_id,
                            'quantity_sold' => $sale->quantity_sold,
                            'unit_price' => $sale->selling_price,
                            'line_total' => $sale->total_revenue,
                            'created_at' => $sale->created_at,
                            'updated_at' => $sale->updated_at,
                        ]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
