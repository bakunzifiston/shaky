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
                if (!Schema::hasColumn('inventory_records', 'invoice_number')) {
                    $table->string('invoice_number')->nullable()->after('supplier_name');
                }
                if (!Schema::hasColumn('inventory_records', 'total_amount')) {
                    $table->decimal('total_amount', 12, 2)->nullable()->after('record_date');
                }
                if (!Schema::hasColumn('inventory_records', 'amount_paid')) {
                    $table->decimal('amount_paid', 12, 2)->default(0)->after('total_amount');
                }
                if (!Schema::hasColumn('inventory_records', 'payment_status')) {
                    $table->enum('payment_status', ['Paid', 'Partial', 'Unpaid'])->default('Unpaid')->after('amount_paid');
                }
                if (!Schema::hasColumn('inventory_records', 'payment_due_date')) {
                    $table->date('payment_due_date')->nullable()->after('payment_status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('inventory_records')) {
            Schema::table('inventory_records', function (Blueprint $table) {
                $drop = [];
                foreach (['invoice_number', 'total_amount', 'amount_paid', 'payment_status', 'payment_due_date'] as $column) {
                    if (Schema::hasColumn('inventory_records', $column)) {
                        $drop[] = $column;
                    }
                }
                if ($drop !== []) {
                    $table->dropColumn($drop);
                }
            });
        }
    }
};
