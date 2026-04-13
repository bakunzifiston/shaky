<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'product_id',
        'inventory_record_id', // now stores multiple items with quantities as JSON
        'barcode',
        'quantity_produced',
        'damaged',
        'production_date',
        'responsible_staff',
        'quality_control_notes',
    ];

    // ✅ Cast JSON to array automatically
    protected $casts = [
        'inventory_record_id' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * ✅ Automatically reduce inventory for each used material
     */
    protected static function booted()
    {
        static::created(function ($production) {
            $materials = $production->inventory_record_id ?? [];

            if (empty($materials) || !is_array($materials)) {
                return;
            }

            foreach ($materials as $item) {
                // Expect structure like: { "inventory_id": 5, "quantity_used": 10 }
                $inventoryId = $item['inventory_id'] ?? null;
                $usedQty = $item['quantity_used'] ?? 0;

                if (!$inventoryId || $usedQty <= 0) {
                    continue;
                }

                $inventory = \App\Models\InventoryRecord::find($inventoryId);

                if (!$inventory) {
                    continue; // skip invalid IDs
                }

                if ($usedQty > $inventory->quantity_in) {
                    throw new Exception("Not enough stock for item: {$inventory->item_name}");
                }

                // ✅ Deduct the used quantity
                $inventory->quantity_in -= $usedQty;
                $inventory->save();
            }
        });

        /**
         * ✅ Automatically generate batch ID if not provided
         */
        static::creating(function ($production) {
            if (empty($production->batch_id)) {
                // e.g. BATCH-0001, BATCH-0002, ...
                $last = self::orderBy('id', 'desc')->first();
                $nextNumber = $last ? ((int) filter_var($last->batch_id, FILTER_SANITIZE_NUMBER_INT) + 1) : 1;
                $production->batch_id = 'BATCH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
