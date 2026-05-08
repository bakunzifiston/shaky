<?php

namespace App\Services;

use App\Models\Production;
use Illuminate\Support\Collection;

class StorefrontCheckoutService
{
    /**
     * Build SaleWorkflowService item payloads by allocating storefront cart lines
     * across production batches (FIFO by production id). Matches ERP sale posting
     * so SaleItem hooks deduct finished-goods stock correctly.
     *
     * @param  Collection<int, array{product: object, quantity: int, unit_price: float, line_total: float}>  $rows
     * @return array<int, array{product_id: int, production_id: int, quantity_sold: float, unit_price: float}>
     */
    public function allocateItems(Collection $rows): array
    {
        $items = [];

        foreach ($rows as $row) {
            $productId = (int) $row['product']->id;
            $qtyNeeded = (float) $row['quantity'];
            $unitPrice = (float) $row['unit_price'];

            $sellable = (float) ($row['product']->sellable_qty ?? 0);
            if ($qtyNeeded > $sellable + 0.0001) {
                throw new \InvalidArgumentException(
                    'Insufficient stock for "' . ($row['product']->name ?? 'product') . '". Available: ' . round($sellable, 2) . '.'
                );
            }

            foreach ($this->allocateProduction($productId, $qtyNeeded) as $chunk) {
                $items[] = [
                    'product_id' => $productId,
                    'production_id' => $chunk['production_id'],
                    'quantity_sold' => $chunk['quantity'],
                    'unit_price' => $unitPrice,
                ];
            }
        }

        return $items;
    }

    /**
     * @return array<int, array{production_id: int, quantity: float}>
     */
    private function allocateProduction(int $productId, float $qtyNeeded): array
    {
        $remaining = $qtyNeeded;
        $chunks = [];

        $batches = Production::query()
            ->where('product_id', $productId)
            ->where('quantity_produced', '>', 0)
            ->orderBy('id')
            ->get(['id', 'quantity_produced']);

        foreach ($batches as $batch) {
            if ($remaining <= 0.0001) {
                break;
            }

            $available = (float) $batch->quantity_produced;
            $take = min($remaining, $available);

            if ($take <= 0) {
                continue;
            }

            $chunks[] = [
                'production_id' => (int) $batch->id,
                'quantity' => $take,
            ];

            $remaining -= $take;
        }

        if ($remaining > 0.0001) {
            throw new \InvalidArgumentException(
                'Could not allocate enough production batches for product ID ' . $productId . '. Remaining: ' . round($remaining, 2) . '.'
            );
        }

        return $chunks;
    }
}
