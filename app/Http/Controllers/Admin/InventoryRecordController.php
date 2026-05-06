<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInventoryRecordRequest;
use App\Http\Requests\Admin\UpdateInventoryRecordRequest;
use App\Models\InventoryRecord;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryRecordController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->string('search', '');
        $sort = in_array($request->query('sort'), ['supplier_name', 'quantity_in', 'quantity_out', 'total_amount', 'record_date'], true)
            ? $request->query('sort')
            : 'record_date';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $records = InventoryRecord::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('supplier_name', 'like', '%' . $search . '%')
                        ->orWhere('invoice_number', 'like', '%' . $search . '%')
                        ->orWhere('item_name', 'like', '%' . $search . '%')
                        ->orWhere('storage_location', 'like', '%' . $search . '%');
                });
            })
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->string('payment_status')))
            ->when($request->filled('item_type'), fn ($query) => $query->where('item_type', $request->string('item_type')))
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        return view('admin.inventory-records.index', compact('records', 'search', 'sort', 'direction'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->pluck('name', 'id');
        return view('admin.inventory-records.create', compact('products'));
    }

    public function store(StoreInventoryRecordRequest $request): RedirectResponse
    {
        $data = $this->normalizeData($request->validated());
        InventoryRecord::create($data);

        return redirect()->route('admin.inventory-records.index')->with('status', 'Inventory record created successfully.');
    }

    public function show(InventoryRecord $inventoryRecord): View
    {
        return view('admin.inventory-records.show', compact('inventoryRecord'));
    }

    public function edit(InventoryRecord $inventoryRecord): View
    {
        $products = Product::orderBy('name')->pluck('name', 'id');
        return view('admin.inventory-records.edit', compact('inventoryRecord', 'products'));
    }

    public function update(UpdateInventoryRecordRequest $request, InventoryRecord $inventoryRecord): RedirectResponse
    {
        $data = $this->normalizeData($request->validated());
        $inventoryRecord->update($data);

        return redirect()->route('admin.inventory-records.show', $inventoryRecord)->with('status', 'Inventory record updated successfully.');
    }

    public function destroy(InventoryRecord $inventoryRecord): RedirectResponse
    {
        $inventoryRecord->delete();
        return redirect()->route('admin.inventory-records.index')->with('status', 'Inventory record deleted successfully.');
    }

    private function normalizeData(array $data): array
    {
        $total = (float) ($data['total_amount'] ?? 0);
        $paid = (float) ($data['amount_paid'] ?? 0);
        $qty = (float) ($data['quantity_in'] ?? 0);

        if ($qty > 0 && $total > 0) {
            $data['unit_cost'] = round($total / $qty, 2);
        }

        $data['payment_status'] = match (true) {
            $total <= 0 => 'Unpaid',
            $paid >= $total => 'Paid',
            $paid > 0 => 'Partial',
            default => 'Unpaid',
        };

        if (($data['item_type'] ?? null) !== 'Product') {
            $data['product_id'] = null;
        }

        return $data;
    }
}
