<?php

namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Production;
use App\Models\InventoryRecord;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends BaseWidget
{

    protected function getStats(): array
    {
        $totalQuantityProduced = Production::sum('quantity_produced');
        $totalInventoryIn = InventoryRecord::sum('quantity_in');
        $totalInventoryOut = InventoryRecord::sum('quantity_out');
        $currentStock = $totalInventoryIn - $totalInventoryOut;

        $totalSales = Sale::sum('quantity_sold');
        $totalRevenue = Sale::sum('total_revenue');

        return [
            Stat::make('Employees', Employee::count())
                ->description('Total number of staff')
                ->icon('heroicon-o-user-group')
                ->color('primary')
                ->extraAttributes(['class' => 'bg-[#d9f99d]']), // Light green

            Stat::make('Products', Product::count())
                ->description('Types of finished goods')
                ->icon('heroicon-o-cube')
                ->color('success')
                ->extraAttributes(['class' => 'bg-[#bae6fd]']), // Light blue

            Stat::make('Produced Quantity', number_format($totalQuantityProduced, 2) . ' units')
                ->description('Total units produced')
                ->icon('heroicon-o-beaker')
                ->color('info')
                ->extraAttributes(['class' => 'bg-[#ddd6fe]']), // Light violet

            Stat::make('Inventory Stock', number_format($currentStock, 2) . ' units')
                ->description('Current available stock')
                ->icon('heroicon-o-archive-box')
                ->color('warning')
                ->extraAttributes(['class' => 'bg-[#fde68a]']), // Light yellow

            Stat::make('Total Sales', number_format($totalSales, 2) . ' units')
                ->description('Quantity sold')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->extraAttributes(['class' => 'bg-[#fef08a]']), // Light gold

            Stat::make('Total Revenue', number_format($totalRevenue, 2) . ' RWF')
                ->description('From all sales')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->extraAttributes(['class' => 'bg-[#bbf7d0]']), // Light green
        ];
    }
}
