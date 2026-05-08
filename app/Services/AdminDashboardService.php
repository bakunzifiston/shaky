<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function build(?string $period, ?string $startDate, ?string $endDate): array
    {
        [$start, $end] = $this->resolveDates($period, $startDate, $endDate);

        $productionQuery = Production::query();
        if ($start && $end) {
            $productionQuery->whereBetween('created_at', [$start, $end]);
        }

        $inventoryQuery = InventoryRecord::query();
        if ($start && $end) {
            $inventoryQuery->whereBetween('record_date', [$start, $end]);
        }

        $salesQuery = Sale::query();
        $saleItemsQuery = SaleItem::query();
        if ($start && $end) {
            $salesQuery->whereBetween('sale_date', [$start, $end]);
            $saleItemsQuery->whereHas('sale', fn ($q) => $q->whereBetween('sale_date', [$start, $end]));
        }

        $valuationService = app(InventoryValuationService::class);
        $totalRevenue = (clone $salesQuery)->where('payment_status', 'Paid')->sum('total_revenue');
        $cogs = ($start && $end) ? $valuationService->getCogsForSalesInPeriod($start->format('Y-m-d'), $end->format('Y-m-d')) : 0;

        $stats = [
            'employees' => Employee::count(),
            'products' => Product::count(),
            'produced_quantity' => (float) $productionQuery->sum('quantity_produced'),
            'inventory_stock' => (float) InventoryRecord::sum('quantity_in') - (float) InventoryRecord::sum('quantity_out'),
            'fifo_stock_value' => $valuationService->getFifoTotalValue(null),
            'total_sales_qty' => (float) $saleItemsQuery->sum('quantity_sold'),
            'total_revenue' => (float) $totalRevenue,
            'gross_profit' => (float) ($totalRevenue - $cogs),
            'pending_payments' => (float) (clone $salesQuery)->whereIn('payment_status', ['Pending', 'Credit'])->sum('total_revenue'),
            'supplier_balance' => (float) ((clone $inventoryQuery)->whereIn('payment_status', ['Unpaid', 'Partial'])->sum('total_amount')
                - (clone $inventoryQuery)->whereIn('payment_status', ['Unpaid', 'Partial'])->sum('amount_paid')),
        ];

        $productionByProduct = Production::select('product_id', DB::raw('SUM(quantity_produced) as total'))
            ->with('product:id,name')
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]))
            ->groupBy('product_id')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->product?->name ?? 'Unknown Product',
                'value' => (float) $item->total,
            ])->values()->all();

        return [
            'period' => $period ?? 'all_time',
            'start_date' => $start?->format('Y-m-d'),
            'end_date' => $end?->format('Y-m-d'),
            'stats' => $stats,
            'production_by_product' => $productionByProduct,
            'monthly_production' => $this->monthlyProduction($start, $end),
            'monthly_sales_revenue' => $this->monthlySalesRevenue($start, $end),
        ];
    }

    private function resolveDates(?string $period, ?string $startDate, ?string $endDate): array
    {
        if ($period && $period !== 'all_time') {
            return match ($period) {
                'today' => [now()->startOfDay(), now()->endOfDay()],
                'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
                'last_7_days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
                'last_30_days' => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
                'this_month' => [now()->startOfMonth(), now()->endOfMonth()],
                'last_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
                'this_year' => [now()->startOfYear(), now()->endOfYear()],
                default => [null, null],
            };
        }

        if ($startDate && $endDate) {
            return [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()];
        }

        return [null, null];
    }

    private function monthlyProduction(?Carbon $start = null, ?Carbon $end = null): array
    {
        $rows = Production::query()
            ->selectRaw('MONTH(production_date) as month, SUM(quantity_produced) as total')
            ->when($start && $end, fn ($query) => $query->whereBetween('production_date', [$start, $end]))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return collect(range(1, 12))->map(fn ($i) => (float) ($rows[$i] ?? 0))->all();
    }

    private function monthlySalesRevenue(?Carbon $start = null, ?Carbon $end = null): array
    {
        $rows = Sale::query()
            ->selectRaw('MONTH(sale_date) as month, SUM(total_revenue) as total')
            ->when($start && $end, fn ($query) => $query->whereBetween('sale_date', [$start, $end]))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return collect(range(1, 12))->map(fn ($i) => (float) ($rows[$i] ?? 0))->all();
    }
}
