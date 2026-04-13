<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\SaleItem;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    /** @var array Normalized items to create after the sale is saved (for stock reduction) */
    protected array $pendingSaleItems = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $items = $this->normalizeRepeaterItems($data['items'] ?? []);
        $totalRevenue = 0;

        foreach ($items as &$item) {
            $qty = (float) ($item['quantity_sold'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $lineTotal = round($qty * $price, 2);
            $item['line_total'] = $lineTotal;
            $totalRevenue += $lineTotal;
        }

        $data['total_revenue'] = round($totalRevenue, 2);
        $data['items'] = $items;

        // Keep normalized items to create after save so SaleItem::created fires (production reduction)
        $this->pendingSaleItems = $items;

        // Set product_id/production_id/quantity_sold/selling_price from first item (required by sales table)
        $first = $items[0] ?? null;
        if ($first && isset($first['product_id'], $first['production_id'])) {
            $data['product_id'] = $first['product_id'];
            $data['production_id'] = $first['production_id'];
            $data['quantity_sold'] = $first['quantity_sold'] ?? 0;
            $data['selling_price'] = $first['unit_price'] ?? 0;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        // Create sale items from form data so SaleItem::created fires and production is reduced.
        // Only run when Repeater didn't save any items (e.g. wrong form state on cPanel).
        if ($record->id && count($this->pendingSaleItems) > 0 && $record->items()->count() === 0) {
            foreach ($this->pendingSaleItems as $item) {
                if (empty($item['product_id']) || empty($item['production_id'])) {
                    continue;
                }
                SaleItem::create([
                    'sale_id' => $record->id,
                    'product_id' => $item['product_id'],
                    'production_id' => $item['production_id'],
                    'quantity_sold' => $item['quantity_sold'] ?? 0,
                    'unit_price' => $item['unit_price'] ?? 0,
                    'line_total' => $item['line_total'] ?? (($item['quantity_sold'] ?? 0) * ($item['unit_price'] ?? 0)),
                ]);
            }
        }

        // Final safeguard: ensure sales.total_revenue matches saved line items.
        $itemsTotal = (float) $record->items()->sum('line_total');
        if ($itemsTotal <= 0 && count($this->pendingSaleItems) > 0) {
            foreach ($this->pendingSaleItems as $item) {
                $itemsTotal += (float) ($item['line_total'] ?? 0);
            }
        }
        $record->update(['total_revenue' => round($itemsTotal, 2)]);
    }

    /**
     * Normalize repeater items for all known Livewire payload shapes.
     */
    protected function normalizeRepeaterItems(array $items): array
    {
        $normalized = [];

        $walk = function ($node) use (&$walk, &$normalized): void {
            if (!is_array($node)) {
                return;
            }

            if (isset($node['product_id']) && isset($node['production_id'])) {
                $normalized[] = [
                    'product_id' => $node['product_id'],
                    'production_id' => $node['production_id'],
                    'quantity_sold' => $node['quantity_sold'] ?? 0,
                    'unit_price' => $node['unit_price'] ?? 0,
                    'line_total' => $node['line_total'] ?? 0,
                ];
                return;
            }

            foreach ($node as $child) {
                $walk($child);
            }
        };

        $walk($items);

        return $normalized;
    }
}
