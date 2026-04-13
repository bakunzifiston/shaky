<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Production;
use App\Models\InventoryRecord;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\InventoryValuationService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;

        // These don't change with date filter
        $totalEmployees = Employee::count();
        $totalProducts = Product::count();

        // Production filtered by date
        $productionQuery = Production::query();
        if ($startDate && $endDate) {
            $productionQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $totalQuantityProduced = $productionQuery->sum('quantity_produced');

        // Inventory - always show current stock (not filtered)
        $totalInventoryIn = InventoryRecord::sum('quantity_in');
        $totalInventoryOut = InventoryRecord::sum('quantity_out');
        $currentStock = $totalInventoryIn - $totalInventoryOut;

        // Supplier payments (filtered by record_date)
        $inventoryQuery = InventoryRecord::query();
        if ($startDate && $endDate) {
            $inventoryQuery->whereBetween('record_date', [$startDate, $endDate]);
        }
        $supplierTotalOwed = (clone $inventoryQuery)->whereIn('payment_status', ['Unpaid', 'Partial'])->sum('total_amount');
        $supplierTotalPaid = (clone $inventoryQuery)->whereIn('payment_status', ['Unpaid', 'Partial'])->sum('amount_paid');
        $supplierPending = $supplierTotalOwed - $supplierTotalPaid;

        // Sales filtered by sale_date
        $salesQuery = Sale::query();
        $saleItemsQuery = SaleItem::query();
        
        if ($startDate && $endDate) {
            $salesQuery->whereBetween('sale_date', [$startDate, $endDate]);
            $saleItemsQuery->whereHas('sale', fn($q) => $q->whereBetween('sale_date', [$startDate, $endDate]));
        }

        $totalSales = (clone $saleItemsQuery)->sum('quantity_sold');
        
        // Only count revenue from PAID sales
        $totalRevenue = (clone $salesQuery)->where('payment_status', 'Paid')->sum('total_revenue');
        
        // Pending payments: Pending + Credit
        $totalPendingPayment = (clone $salesQuery)
            ->whereIn('payment_status', ['Pending', 'Credit'])
            ->sum('total_revenue');

        // Production by product (filtered)
        $productionByProductQuery = Production::select(
                'product_id',
                DB::raw('SUM(quantity_produced) as total')
            )
            ->with('product:id,name')
            ->groupBy('product_id');
        
        if ($startDate && $endDate) {
            $productionByProductQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $productionByProduct = $productionByProductQuery->get();

        // FIFO stock value (current, not filtered by date)
        $valuationService = app(InventoryValuationService::class);
        $fifoStockValue = $valuationService->getFifoTotalValue(null);

        // COGS and Gross Profit for the period (when date range is set)
        $totalCogs = 0;
        $grossProfit = 0;
        if ($startDate && $endDate) {
            $totalCogs = $valuationService->getCogsForSalesInPeriod($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
            $grossProfit = $totalRevenue - $totalCogs;
        }

        // Date range label for descriptions
        $dateLabel = ($startDate && $endDate) 
            ? $startDate->format('M d') . ' - ' . $endDate->format('M d, Y')
            : 'All time';

        $stats = [
            Stat::make('Employees', $totalEmployees)
                ->description('Total number of staff')
                ->icon('heroicon-o-user-group')
                ->color('primary')
                ->extraAttributes(['class' => 'bg-[#d9f99d]']),

            Stat::make('Products', $totalProducts)
                ->description('Types of finished goods')
                ->icon('heroicon-o-cube')
                ->color('success')
                ->extraAttributes(['class' => 'bg-[#bae6fd]']),

            Stat::make('Produced Quantity', number_format($totalQuantityProduced, 2) . ' units')
                ->description($dateLabel)
                ->icon('heroicon-o-beaker')
                ->color('info')
                ->extraAttributes(['class' => 'bg-[#ddd6fe]']),

            Stat::make('Inventory Stock', number_format($currentStock, 2) . ' units')
                ->description('Current available stock')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->extraAttributes(['class' => 'bg-[#fde68a]']),

            Stat::make('Stock Value (FIFO)', number_format($fifoStockValue, 0) . ' RWF')
                ->description('Total inventory value at cost')
                ->icon('heroicon-o-currency-dollar')
                ->color('info')
                ->extraAttributes(['class' => 'bg-[#e0e7ff]']),

            Stat::make('Total Sales', number_format($totalSales, 2) . ' units')
                ->description($dateLabel)
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->extraAttributes(['class' => 'bg-[#fef08a]']),

            Stat::make('Total Revenue', number_format($totalRevenue, 0) . ' RWF')
                ->description('Paid sales • ' . $dateLabel)
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->extraAttributes(['class' => 'bg-[#bbf7d0]']),

            Stat::make('Gross Profit', number_format($grossProfit, 0) . ' RWF')
                ->description($startDate && $endDate ? 'Revenue − COGS • ' . $dateLabel : 'Select date range')
                ->icon('heroicon-o-calculator')
                ->color($grossProfit >= 0 ? 'success' : 'danger')
                ->extraAttributes(['class' => $grossProfit >= 0 ? 'bg-[#bbf7d0]' : 'bg-[#fecaca]']),

            Stat::make('Pending Payments', number_format($totalPendingPayment, 0) . ' RWF')
                ->description('Unpaid sales • ' . $dateLabel)
                ->icon('heroicon-o-clock')
                ->color('danger')
                ->extraAttributes(['class' => 'bg-[#fecaca]']),

            Stat::make('Supplier Balance', number_format($supplierPending, 0) . ' RWF')
                ->description('Owed to suppliers • ' . $dateLabel)
                ->icon('heroicon-o-truck')
                ->color('warning')
                ->extraAttributes(['class' => 'bg-[#fed7aa]']),
        ];

        foreach ($productionByProduct as $item) {
            $productName = $item->product?->name ?? 'Unknown Product';
            $stats[] = Stat::make(
                "Produced: {$productName}",
                number_format($item->total, 2) . ' units'
            )
                ->description($dateLabel)
                ->icon('heroicon-o-beaker')
                ->color('secondary')
                ->extraAttributes(['class' => 'bg-[#fbcfe8]']);
        }

        return $stats;
    }
}
