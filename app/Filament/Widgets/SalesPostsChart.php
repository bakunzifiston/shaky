<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class SalesPostsChart extends ChartWidget
{ protected static ?int $navigationSort = 3; 
    protected static ?string $heading = 'Monthly Sales Revenue';

    protected function getData(): array
    {
        $monthlySales = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_revenue) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Fill all 12 months
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthlySales[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (RWF)',
                    'data' => $data,
                    'backgroundColor' => '#003333',
                    'borderRadius' => 5,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Change to 'line' if needed
    }
}
