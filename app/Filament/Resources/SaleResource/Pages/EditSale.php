<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

        $first = $items[0] ?? null;
        if ($first && isset($first['product_id'], $first['production_id'])) {
            $data['product_id'] = $first['product_id'];
            $data['production_id'] = $first['production_id'];
            $data['quantity_sold'] = $first['quantity_sold'] ?? 0;
            $data['selling_price'] = $first['unit_price'] ?? 0;
        }

        return $data;
    }

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

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $itemsTotal = (float) $record->items()->sum('line_total');
        $record->update(['total_revenue' => round($itemsTotal, 2)]);
    }
}
