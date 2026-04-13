<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'production_id',
        'quantity_sold',
        'unit_price',
        'line_total',
    ];

    protected $casts = [
        'quantity_sold' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::created(function (SaleItem $item) {
            $production = Production::find($item->production_id);
            if ($production) {
                $production->quantity_produced = max($production->quantity_produced - $item->quantity_sold, 0);
                $production->save();
            }
        });
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }
}
