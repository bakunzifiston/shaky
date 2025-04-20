<?php

namespace App\Filament\Widgets;

use App\Models\Production;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AdminPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Production Quantity';

    protected function getData(): array
    {
        // Query: Sum quantity per month
        $monthlyProduction = Production::selectRaw('MONTH(production_date) as month, SUM(quantity_produced) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Prepare chart data (ensure all 12 months are covered)
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthlyProduction[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Production (Units)',
                    'data' => $data,
                    'backgroundColor' => '#006666',
                    'borderRadius' => 5,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Can be 'line', 'bar', 'pie', etc.
    }
}
