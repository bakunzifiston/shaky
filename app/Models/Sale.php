<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;
    // Allow mass assignment for these attributes
    protected $fillable = [
        'sales_id',
        'customer_name',
        'customer_Phone',
        'product_id',
        'quantity_sold',
        'selling_price',
        'total_revenue',
        'payment_status',
        'delivery_status',
        'sales_channel',
        'invoice_number',
        'sale_date',
    ];
    // Define the relationship with the Product model
    protected static function booted()
{
    static::creating(function ($sale) {
        $sale->sales_id = 'SALE-' . now()->format('YmdHis') . '-' . rand(100, 999);
    });
}

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Define the relationship with the Employee model

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
