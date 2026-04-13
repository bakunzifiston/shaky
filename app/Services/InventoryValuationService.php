<?php

namespace App\Services;

use App\Models\InventoryRecord;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InventoryValuationService
{
    /**
     * FIFO: Build remaining layers per item (product_id or item_name).
     * Each layer is [quantity_remaining, unit_cost].
     */
    public function getFifoLayers(?string $asOfDate = null): array
    {
        $query = InventoryRecord::query()
            ->orderBy('record_date')
            ->orderBy('id');

        if ($asOfDate) {
            $query->where('record_date', '<=', $asOfDate);
        }

        $records = $query->get();
        $layersByKey = [];

        foreach ($records as $record) {
            $key = $this->itemKey($record);
            $unitCost = max(0, (float) ($record->unit_cost ?? 0));

            if (($record->quantity_in ?? 0) > 0) {
                if (!isset($layersByKey[$key])) {
                    $layersByKey[$key] = [];
                }
                $layersByKey[$key][] = [(float) $record->quantity_in, $unitCost];
            }

            $toConsume = (float) ($record->quantity_out ?? 0);
            if ($toConsume > 0 && isset($layersByKey[$key])) {
                $layersByKey[$key] = $this->consumeFromLayers($layersByKey[$key], $toConsume);
            }
        }

        return $layersByKey;
    }

    /**
     * Total stock value using FIFO (all items).
     */
    public function getFifoTotalValue(?string $asOfDate = null): float
    {
        $layers = $this->getFifoLayers($asOfDate);
        $total = 0;
        foreach ($layers as $itemLayers) {
            foreach ($itemLayers as [$qty, $cost]) {
                $total += $qty * $cost;
            }
        }
        return round($total, 2);
    }

    /**
     * Total quantity on hand (FIFO remaining).
     */
    public function getFifoTotalQuantity(?string $asOfDate = null): float
    {
        $layers = $this->getFifoLayers($asOfDate);
        $total = 0;
        foreach ($layers as $itemLayers) {
            foreach ($itemLayers as [$qty]) {
                $total += $qty;
            }
        }
        return $total;
    }

    /**
     * COGS for sales in a date range: process inventory + sales in date order, consume FIFO per sale item.
     */
    public function getCogsForSalesInPeriod(?string $startDate, ?string $endDate): float
    {
        if (!$startDate || !$endDate) {
            return 0;
        }
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Initial layers at day before start
        $layers = $this->getFifoLayers($start->copy()->subDay()->format('Y-m-d'));

        // Events: inventory records in range
        $inventoryRecords = InventoryRecord::query()
            ->whereBetween('record_date', [$start, $end])
            ->orderBy('record_date')
            ->orderBy('id')
            ->get();

        // Events: sale items in range with sale date
        $saleItems = SaleItem::query()
            ->with('sale', 'product')
            ->whereHas('sale', fn ($q) => $q->whereBetween('sale_date', [$start, $end]))
            ->get()
            ->sortBy(fn ($item) => $item->sale->sale_date . ' ' . $item->id);

        // Merge and sort: we'll process inventory first by record_date, then sales by sale_date
        $events = [];
        foreach ($inventoryRecords as $r) {
            $events[] = ['date' => Carbon::parse($r->record_date), 'type' => 'inventory', 'record' => $r];
        }
        foreach ($saleItems as $si) {
            $events[] = ['date' => Carbon::parse($si->sale->sale_date), 'type' => 'sale_item', 'sale_item' => $si];
        }
        usort($events, fn ($a, $b) => $a['date']->getTimestamp() <=> $b['date']->getTimestamp());

        $totalCogs = 0;
        foreach ($events as $ev) {
            if ($ev['type'] === 'inventory') {
                $r = $ev['record'];
                $key = $this->itemKey($r);
                $unitCost = max(0, (float) ($r->unit_cost ?? 0));
                if (($r->quantity_in ?? 0) > 0) {
                    if (!isset($layers[$key])) {
                        $layers[$key] = [];
                    }
                    $layers[$key][] = [(float) $r->quantity_in, $unitCost];
                }
                $toConsume = (float) ($r->quantity_out ?? 0);
                if ($toConsume > 0 && isset($layers[$key])) {
                    $layers[$key] = $this->consumeFromLayers($layers[$key], $toConsume);
                }
            } else {
                $si = $ev['sale_item'];
                $productId = $si->product_id;
                $productName = $si->product->name ?? '';
                $qty = (float) $si->quantity_sold;
                if ($qty <= 0) {
                    continue;
                }
                // Try product_id key first, then item name key (for inventory not linked to product)
                $key = $productId ? (string) $productId : 'name:' . $productName;
                $nameKey = 'name:' . $productName;
                $tryKey = isset($layers[$key]) ? $key : (isset($layers[$nameKey]) ? $nameKey : null);
                if ($tryKey === null) {
                    continue;
                }
                [$newLayers, $cost] = $this->consumeFromLayersAndReturnCost($layers[$tryKey], $qty);
                $layers[$tryKey] = $newLayers;
                $totalCogs += $cost;
            }
        }

        return round($totalCogs, 2);
    }

    /**
     * Consume quantity from layers (FIFO), return remaining layers.
     */
    protected function consumeFromLayers(array $layers, float $quantity): array
    {
        $remaining = $quantity;
        $newLayers = [];
        foreach ($layers as [$qty, $cost]) {
            if ($remaining <= 0) {
                $newLayers[] = [$qty, $cost];
                continue;
            }
            if ($remaining >= $qty) {
                $remaining -= $qty;
                continue;
            }
            $newLayers[] = [$qty - $remaining, $cost];
            $remaining = 0;
        }
        return $newLayers;
    }

    /**
     * Consume quantity from layers; return [newLayers, cost].
     */
    protected function consumeFromLayersAndReturnCost(array $layers, float $quantity): array
    {
        $remaining = $quantity;
        $cost = 0;
        $newLayers = [];
        foreach ($layers as [$qty, $unitCost]) {
            if ($remaining <= 0) {
                $newLayers[] = [$qty, $unitCost];
                continue;
            }
            if ($remaining >= $qty) {
                $cost += $qty * $unitCost;
                $remaining -= $qty;
                continue;
            }
            $take = $remaining;
            $cost += $take * $unitCost;
            $newLayers[] = [$qty - $take, $unitCost];
            $remaining = 0;
        }
        return [$newLayers, $cost];
    }

    protected function itemKey(InventoryRecord $record): string
    {
        if ($record->product_id) {
            return (string) $record->product_id;
        }
        return 'name:' . ($record->item_name ?? '');
    }
}
