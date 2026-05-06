<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductionRequest;
use App\Http\Requests\Admin\UpdateProductionRequest;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductionController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->string('search', '');
        $sort = in_array($request->query('sort'), ['batch_id', 'quantity_produced', 'damaged', 'production_date', 'created_at'], true)
            ? $request->query('sort')
            : 'created_at';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        $productions = Production::query()
            ->with('product')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('batch_id', 'like', '%' . $search . '%')
                    ->orWhere('responsible_staff', 'like', '%' . $search . '%')
                    ->orWhere('barcode', 'like', '%' . $search . '%');
            })
            ->orderBy($sort, $direction)
            ->paginate(15)
            ->withQueryString();

        return view('admin.productions.index', compact('productions', 'search', 'sort', 'direction'));
    }

    public function create(): View
    {
        $products = Product::orderBy('type')->pluck('type', 'id');
        $inventoryOptions = InventoryRecord::orderBy('item_name')->pluck('item_name', 'id');

        return view('admin.productions.create', compact('products', 'inventoryOptions'));
    }

    public function store(StoreProductionRequest $request): RedirectResponse
    {
        Production::create($request->validated());

        return redirect()->route('admin.productions.index')->with('status', 'Production created successfully.');
    }

    public function show(Production $production): View
    {
        $production->load('product');
        return view('admin.productions.show', compact('production'));
    }

    public function edit(Production $production): View
    {
        $products = Product::orderBy('type')->pluck('type', 'id');
        $inventoryOptions = InventoryRecord::orderBy('item_name')->pluck('item_name', 'id');

        return view('admin.productions.edit', compact('production', 'products', 'inventoryOptions'));
    }

    public function update(UpdateProductionRequest $request, Production $production): RedirectResponse
    {
        $production->update($request->validated());

        return redirect()->route('admin.productions.show', $production)->with('status', 'Production updated successfully.');
    }

    public function destroy(Production $production): RedirectResponse
    {
        $production->delete();

        return redirect()->route('admin.productions.index')->with('status', 'Production deleted successfully.');
    }
}
