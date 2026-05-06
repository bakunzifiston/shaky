<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Models\Production;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SaleWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct(private readonly SaleWorkflowService $workflow)
    {
    }

    public function index(Request $request): View
    {
        $search = (string) $request->string('search', '');
        $sales = Sale::query()
            ->withCount('items')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('sales_id', 'like', '%' . $search . '%')
                    ->orWhere('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('invoice_number', 'like', '%' . $search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sales.index', compact('sales', 'search'));
    }

    public function create(): View
    {
        return view('admin.sales.create', $this->formData());
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        $this->workflow->create($request->validated());
        return redirect()->route('admin.sales.index')->with('status', 'Sale created successfully.');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['items.product', 'items.production']);
        return view('admin.sales.show', compact('sale'));
    }

    public function edit(Sale $sale): View
    {
        $sale->load('items');
        return view('admin.sales.edit', array_merge($this->formData(), compact('sale')));
    }

    public function update(UpdateSaleRequest $request, Sale $sale): RedirectResponse
    {
        $this->workflow->update($sale->load('items'), $request->validated());
        return redirect()->route('admin.sales.show', $sale)->with('status', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();
        return redirect()->route('admin.sales.index')->with('status', 'Sale deleted successfully.');
    }

    private function formData(): array
    {
        $products = Product::orderBy('type')->get(['id', 'type']);
        $productions = Production::query()
            ->where('quantity_produced', '>', 0)
            ->get(['id', 'product_id', 'batch_id']);

        return compact('products', 'productions');
    }
}
