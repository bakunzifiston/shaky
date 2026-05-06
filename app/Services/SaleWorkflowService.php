<?php

namespace App\Services;

use App\Models\Production;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleWorkflowService
{
    public function create(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $items = $this->normalizeItems($data['items'] ?? []);
            $saleData = $this->buildSaleData($data, $items);

            $sale = Sale::create($saleData);
            $this->createItems($sale, $items);
            $this->syncSaleTotal($sale);

            return $sale->fresh(['items']);
        });
    }

    public function update(Sale $sale, array $data): Sale
    {
        return DB::transaction(function () use ($sale, $data) {
            // Revert old stock deductions before rebuilding items.
            foreach ($sale->items as $oldItem) {
                $production = Production::find($oldItem->production_id);
                if ($production) {
                    $production->quantity_produced += (float) $oldItem->quantity_sold;
                    $production->save();
                }
            }

            $sale->items()->delete();

            $items = $this->normalizeItems($data['items'] ?? []);
            $saleData = $this->buildSaleData($data, $items);

            $sale->update($saleData);
            $this->createItems($sale, $items);
            $this->syncSaleTotal($sale);

            return $sale->fresh(['items']);
        });
    }

    private function createItems(Sale $sale, array $items): void
    {
        foreach ($items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'production_id' => $item['production_id'],
                'quantity_sold' => $item['quantity_sold'],
                'unit_price' => $item['unit_price'],
                'line_total' => $item['line_total'],
            ]);
        }
    }

    private function buildSaleData(array $data, array $items): array
    {
        $totalRevenue = collect($items)->sum(fn (array $item): float => (float) $item['line_total']);
        $first = $items[0];

        return [
            'customer_name' => $data['customer_name'],
            'customer_Phone' => $data['customer_Phone'] ?? null,
            'invoice_number' => $data['invoice_number'] ?? null,
            'sale_date' => $data['sale_date'],
            'payment_status' => $data['payment_status'],
            'delivery_status' => $data['delivery_status'],
            'sales_channel' => $data['sales_channel'],
            'product_id' => $first['product_id'] ?? null,
            'production_id' => $first['production_id'] ?? null,
            'quantity_sold' => $first['quantity_sold'] ?? 0,
            'selling_price' => $first['unit_price'] ?? 0,
            'total_revenue' => round($totalRevenue, 2),
        ];
    }

    private function normalizeItems(array $items): array
    {
        return collect($items)->map(function ($item) {
            $qty = (float) ($item['quantity_sold'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            return [
                'product_id' => $item['product_id'],
                'production_id' => $item['production_id'],
                'quantity_sold' => $qty,
                'unit_price' => $price,
                'line_total' => round($qty * $price, 2),
            ];
        })->values()->all();
    }

    private function syncSaleTotal(Sale $sale): void
    {
        $sale->update([
            'total_revenue' => round((float) $sale->items()->sum('line_total'), 2),
        ]);
    }
}
