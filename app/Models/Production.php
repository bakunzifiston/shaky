<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'product_id',
        'inventory_record_id',
        'barcode',
        'quantity_produced',
        'damaged',
        'production_date',
        'responsible_staff',
        'quality_control_notes',
    ];

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

    protected static function booted(): void
    {
        static::creating(function (Production $production): void {
            if (empty($production->batch_id)) {
                $last = self::query()->orderByDesc('id')->first();
                $nextNumber = $last ? ((int) filter_var($last->batch_id, FILTER_SANITIZE_NUMBER_INT) + 1) : 1;
                $production->batch_id = 'BATCH-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function (Production $production): void {
            DB::transaction(function () use ($production): void {
                self::applyMaterials(self::normalizeMaterials($production->inventory_record_id));
            });
        });

        static::updated(function (Production $production): void {
            if (! $production->wasChanged('inventory_record_id')) {
                return;
            }

            DB::transaction(function () use ($production): void {
                $oldMaterials = self::normalizeMaterials($production->getOriginal('inventory_record_id'));
                $newMaterials = self::normalizeMaterials($production->inventory_record_id);

                self::releaseMaterials($oldMaterials);

                try {
                    self::applyMaterials($newMaterials);
                } catch (Exception $exception) {
                    self::applyMaterials($oldMaterials);
                    throw $exception;
                }
            });
        });

        static::deleting(function (Production $production): void {
            self::releaseMaterials(self::normalizeMaterials($production->inventory_record_id));
        });
    }

    /**
     * @return array<int, array{inventory_id: int|string, quantity_used: float|int|string}>
     */
    public static function normalizeMaterials(mixed $materials): array
    {
        if (is_string($materials)) {
            $materials = json_decode($materials, true);
        }

        return is_array($materials) ? $materials : [];
    }

    /**
     * @param  array<int, array<string, mixed>>  $materials
     */
    public static function applyMaterials(array $materials): void
    {
        foreach ($materials as $item) {
            $inventoryId = $item['inventory_id'] ?? null;
            $usedQty = (float) ($item['quantity_used'] ?? 0);

            if (! $inventoryId || $usedQty <= 0) {
                continue;
            }

            $inventory = InventoryRecord::query()->lockForUpdate()->find($inventoryId);

            if (! $inventory) {
                continue;
            }

            if ($usedQty > $inventory->remainingQuantity()) {
                throw new Exception("Not enough stock for item: {$inventory->item_name}");
            }

            $inventory->quantity_out = round((float) $inventory->quantity_out + $usedQty, 2);
            $inventory->save();
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $materials
     */
    public static function releaseMaterials(array $materials): void
    {
        foreach ($materials as $item) {
            $inventoryId = $item['inventory_id'] ?? null;
            $usedQty = (float) ($item['quantity_used'] ?? 0);

            if (! $inventoryId || $usedQty <= 0) {
                continue;
            }

            $inventory = InventoryRecord::query()->lockForUpdate()->find($inventoryId);

            if (! $inventory) {
                continue;
            }

            $inventory->quantity_out = max(0, round((float) $inventory->quantity_out - $usedQty, 2));
            $inventory->save();
        }
    }
}
