<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryRecord;
use App\Models\SaleItem;
use App\Services\AdminDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __invoke(Request $request, AdminDashboardService $dashboard): View
    {
        $period = (string) $request->query('period', 'all_time');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $analytics = $dashboard->build($period, $startDate, $endDate);

        $salesByProduct = SaleItem::query()
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->select('products.type as product_name', DB::raw('SUM(sale_items.quantity_sold) as total_qty'), DB::raw('SUM(sale_items.line_total) as total_revenue'))
            ->when($analytics['start_date'] && $analytics['end_date'], function ($query) use ($analytics) {
                $query->whereHas('sale', fn ($q) => $q->whereBetween('sale_date', [$analytics['start_date'], $analytics['end_date']]));
            })
            ->groupBy('products.type')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        $inventoryValuation = InventoryRecord::query()
            ->select('item_name', DB::raw('SUM(quantity_in - quantity_out) as qty_on_hand'), DB::raw('AVG(unit_cost) as avg_cost'))
            ->groupBy('item_name')
            ->orderByDesc('qty_on_hand')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'item_name' => $row->item_name,
                'qty_on_hand' => (float) $row->qty_on_hand,
                'avg_cost' => (float) $row->avg_cost,
                'value' => round(((float) $row->qty_on_hand) * ((float) $row->avg_cost), 2),
            ]);

        return view('admin.reports.index', array_merge($analytics, [
            'sales_by_product' => $salesByProduct,
            'inventory_valuation' => $inventoryValuation,
        ]));
    }
}
