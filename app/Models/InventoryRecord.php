<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'invoice_number',
        'item_type',
        'item_name',
        'product_id',
        'quantity_in',
        'quantity_out',
        'damaged',
        'storage_location',
        'record_date',
        'unit_cost',
        'total_amount',
        'amount_paid',
        'payment_status',
        'payment_due_date',
    ];

    protected $casts = [
        'record_date' => 'date',
        'payment_due_date' => 'date',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Line value for this record (remaining quantity × unit cost).
     */
    public function getLineValueAttribute(): float
    {
        $qty = ($this->quantity_in ?? 0) - ($this->quantity_out ?? 0);
        return round($qty * (float) ($this->unit_cost ?? 0), 2);
    }

    public function getRemainingBalanceAttribute(): float
    {
        return ($this->total_amount ?? 0) - ($this->amount_paid ?? 0);
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->payment_status === 'Paid') {
            return false;
        }
        return $this->payment_due_date && $this->payment_due_date->isPast();
    }
}
