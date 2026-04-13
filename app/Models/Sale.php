<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'customer_name',
        'customer_Phone',
        'product_id',
        'production_id',
        'quantity_sold',
        'selling_price',
        'total_revenue',
        'payment_status',
        'delivery_status',
        'sales_channel',
        'invoice_number',
        'sale_date',
        'barcode',
    ];

    protected static function booted(): void
    {
        static::creating(function (Sale $sale) {
            if (empty($sale->sales_id)) {
                $sale->sales_id = 'SALE-' . now()->format('YmdHis') . '-' . rand(100, 999);
            }
        });

        // Stock reduction is done only in SaleItem::created when items exist.
        // CreateSale::afterCreate() creates SaleItems from form data, so reduction happens there.
        // Legacy single-product: ensure one SaleItem is created (e.g. by form or import) so reduction runs.
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
