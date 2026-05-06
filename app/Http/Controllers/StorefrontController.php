<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $products = $this->catalogQuery()->limit(6)->get();
        $bestSellers = $this->bestSellers(6);
        $categories = Product::query()->select('type')->distinct()->orderBy('type')->pluck('type');
        $partners = ['SIMBA', 'T2000', 'Deluxe Supermarket'];
        $promotions = $this->promotionBlocks();

        return view('storefront.home', compact('products', 'bestSellers', 'categories', 'partners', 'promotions'));
    }

    public function about(): View
    {
        return view('storefront.about');
    }

    public function shop(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));
        $sort = (string) $request->query('sort', 'name');
        $direction = $request->query('direction') === 'desc' ? 'desc' : 'asc';
        $allowedSorts = ['name', 'type', 'sellable_qty', 'sold_units'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'name';
        }

        $products = $this->catalogQuery()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $inner) use ($search): void {
                    $inner->where('products.name', 'like', "%{$search}%")
                        ->orWhere('products.type', 'like', "%{$search}%")
                        ->orWhere('products.description', 'like', "%{$search}%")
                        ->orWhere('products.barcode', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn (Builder $query) => $query->where('products.type', $category))
            ->orderBy($sort, $direction)
            ->paginate(12)
            ->withQueryString();

        $categories = Product::query()->select('type')->distinct()->orderBy('type')->pluck('type');

        return view('storefront.shop', compact('products', 'categories', 'search', 'category', 'sort', 'direction'));
    }

    public function product(Product $product): View
    {
        $details = $this->catalogQuery()->where('products.id', $product->id)->firstOrFail();
        $variants = Product::query()
            ->where('type', $product->type)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $reviews = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sale_items.product_id', $product->id)
            ->select('sales.customer_name', 'sales.sale_date', 'sales.payment_status')
            ->latest('sales.sale_date')
            ->limit(6)
            ->get()
            ->map(function ($row, int $index) {
                $row->rating = $row->payment_status === 'Paid' ? 5 : 4;
                $row->comment = $index % 2 === 0
                    ? 'Great taste and premium quality.'
                    : 'Reliable product consistency and packaging.';

                return $row;
            });

        return view('storefront.product', compact('details', 'variants', 'reviews'));
    }

    public function contact(): View
    {
        return view('storefront.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        ContactSubmission::create($validated);

        return redirect()
            ->route('storefront.contact')
            ->with('status', 'Thank you. Your message has been sent to SHAKY Ltd.');
    }

    public function cart(): View
    {
        $cart = collect(session('storefront_cart', []));
        $rows = $this->hydrateCartRows($cart);
        $subtotal = $rows->sum(fn ($row) => $row['line_total']);

        return view('storefront.cart', [
            'rows' => $rows,
            'subtotal' => $subtotal,
        ]);
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        $qty = max((int) $request->integer('quantity', 1), 1);
        $cart = collect(session('storefront_cart', []));
        $current = (int) $cart->get((string) $product->id, 0);
        $cart->put((string) $product->id, $current + $qty);

        session(['storefront_cart' => $cart->all()]);

        return back()->with('status', 'Product added to cart.');
    }

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $qty = (int) $request->integer('quantity', 1);
        $cart = collect(session('storefront_cart', []));

        if ($qty <= 0) {
            $cart->forget((string) $product->id);
        } else {
            $cart->put((string) $product->id, $qty);
        }

        session(['storefront_cart' => $cart->all()]);

        return back()->with('status', 'Cart updated.');
    }

    public function wishlist(): View
    {
        $wishlist = collect(session('storefront_wishlist', []))->unique()->values();
        $items = $this->catalogQuery()->whereIn('products.id', $wishlist)->get();

        return view('storefront.wishlist', compact('items'));
    }

    public function addToWishlist(Product $product): RedirectResponse
    {
        $wishlist = collect(session('storefront_wishlist', []));
        $wishlist->push($product->id);
        session(['storefront_wishlist' => $wishlist->unique()->values()->all()]);

        return back()->with('status', 'Added to wishlist.');
    }

    private function catalogQuery(): Builder
    {
        $inventorySub = InventoryRecord::query()
            ->select('product_id', DB::raw('SUM(quantity_in - quantity_out) as stock_on_hand'))
            ->whereNotNull('product_id')
            ->groupBy('product_id');

        $productionSub = Production::query()
            ->select('product_id', DB::raw('SUM(quantity_produced) as finished_goods'))
            ->groupBy('product_id');

        $salesSub = SaleItem::query()
            ->select('product_id', DB::raw('SUM(quantity_sold) as sold_units'))
            ->groupBy('product_id');

        return Product::query()
            ->leftJoinSub($inventorySub, 'inventory_totals', fn ($join) => $join->on('products.id', '=', 'inventory_totals.product_id'))
            ->leftJoinSub($productionSub, 'production_totals', fn ($join) => $join->on('products.id', '=', 'production_totals.product_id'))
            ->leftJoinSub($salesSub, 'sales_totals', fn ($join) => $join->on('products.id', '=', 'sales_totals.product_id'))
            ->select('products.*')
            ->selectRaw('COALESCE(inventory_totals.stock_on_hand, 0) as stock_on_hand')
            ->selectRaw('COALESCE(production_totals.finished_goods, 0) as finished_goods')
            ->selectRaw('COALESCE(sales_totals.sold_units, 0) as sold_units')
            ->selectRaw('
                CASE
                    WHEN
                        CASE
                            WHEN COALESCE(inventory_totals.stock_on_hand, 0) < COALESCE(production_totals.finished_goods, 0)
                                THEN COALESCE(inventory_totals.stock_on_hand, 0)
                            ELSE COALESCE(production_totals.finished_goods, 0)
                        END < 0
                    THEN 0
                    ELSE
                        CASE
                            WHEN COALESCE(inventory_totals.stock_on_hand, 0) < COALESCE(production_totals.finished_goods, 0)
                                THEN COALESCE(inventory_totals.stock_on_hand, 0)
                            ELSE COALESCE(production_totals.finished_goods, 0)
                        END
                END as sellable_qty
            ');
    }

    private function bestSellers(int $limit): Collection
    {
        return SaleItem::query()
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->selectRaw('products.id, products.type, products.name, products.barcode, SUM(sale_items.quantity_sold) as units_sold')
            ->groupBy('products.id', 'products.type', 'products.name', 'products.barcode')
            ->orderByDesc('units_sold')
            ->limit($limit)
            ->get();
    }

    /**
     * @return array<int, array{title: string, body: string}>
     */
    private function promotionBlocks(): array
    {
        $stats = Sale::query()
            ->selectRaw('SUM(CASE WHEN payment_status = "Paid" THEN total_revenue ELSE 0 END) as paid_revenue')
            ->selectRaw('SUM(CASE WHEN delivery_status = "Returned" THEN 1 ELSE 0 END) as returned_orders')
            ->first();

        return [
            [
                'title' => 'Premium Flavor Campaign',
                'body' => 'Freshly processed chili sauces with consistent premium quality from SHAKY Ltd.',
            ],
            [
                'title' => 'Retail Expansion Offer',
                'body' => 'Now available through SIMBA, T2000, and Deluxe Supermarket chains.',
            ],
            [
                'title' => 'Trusted Performance',
                'body' => 'Paid revenue: ' . number_format((float) ($stats->paid_revenue ?? 0), 2) . ' | Returned orders: ' . number_format((float) ($stats->returned_orders ?? 0), 0),
            ],
        ];
    }

    private function hydrateCartRows(Collection $cart): Collection
    {
        if ($cart->isEmpty()) {
            return collect();
        }

        $products = $this->catalogQuery()
            ->whereIn('products.id', $cart->keys()->map(fn ($id) => (int) $id))
            ->get()
            ->keyBy('id');

        return $cart->map(function ($quantity, $productId) use ($products) {
            $product = $products->get((int) $productId);
            if (!$product) {
                return null;
            }

            $price = max((float) $product->sold_units, 1) * 1000;

            return [
                'product' => $product,
                'quantity' => (int) $quantity,
                'unit_price' => $price,
                'line_total' => $price * (int) $quantity,
            ];
        })->filter()->values();
    }
}
