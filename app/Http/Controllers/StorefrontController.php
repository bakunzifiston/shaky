<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\InventoryRecord;
use App\Models\Product;
use App\Models\Production;
use App\Models\SaleItem;
use App\Models\StorefrontVideo;
use App\Services\SaleWorkflowService;
use App\Services\StorefrontCheckoutService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        $products = $this->catalogQuery()->limit(6)->get();
        $bestSellers = $this->bestSellers(6);
        $videos = StorefrontVideo::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(6)
            ->get();
        $categories = Product::query()->select('type')->distinct()->orderBy('type')->pluck('type');
        $partners = ['SIMBA', 'T2000', 'Deluxe Supermarket'];
        $promotions = $this->promotionBlocks();

        return view('storefront.home', compact('products', 'bestSellers', 'videos', 'categories', 'partners', 'promotions'));
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

    public function checkout(): View
    {
        $cart = collect(session('storefront_cart', []));
        $rows = $this->hydrateCartRows($cart);
        $subtotal = $rows->sum(fn ($row) => $row['line_total']);

        return view('storefront.checkout', [
            'rows' => $rows,
            'subtotal' => $subtotal,
        ]);
    }

    public function placeOrder(
        Request $request,
        SaleWorkflowService $workflow,
        StorefrontCheckoutService $checkout
    ): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = collect(session('storefront_cart', []));
        $rows = $this->hydrateCartRows($cart);
        if ($rows->isEmpty()) {
            return redirect()->route('storefront.cart')->with('status', 'Your cart is empty.');
        }

        try {
            $items = $checkout->allocateItems($rows);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['checkout' => $e->getMessage()])->withInput();
        }

        if ($items === []) {
            return back()->withErrors(['checkout' => 'No line items could be allocated.'])->withInput();
        }

        $invoicePayload = trim($validated['address'] . (isset($validated['notes']) && $validated['notes'] !== '' ? ' | ' . $validated['notes'] : ''));

        $sale = $workflow->create([
            'customer_name' => $validated['name'],
            'customer_Phone' => $validated['phone'],
            'barcode' => $validated['email'],
            'invoice_number' => Str::limit($invoicePayload, 255),
            'sale_date' => now()->toDateString(),
            'payment_status' => 'Pending',
            'delivery_status' => 'Pending',
            'sales_channel' => 'Online Store',
            'items' => $items,
        ]);

        session()->forget('storefront_cart');

        return redirect()->route('storefront.home')->with(
            'status',
            'Order placed successfully. Reference: ' . $sale->sales_id . '. Our team will confirm delivery details shortly.'
        );
    }

    private function catalogQuery(): Builder
    {
        $productionSub = Production::query()
            ->select('product_id', DB::raw('SUM(quantity_produced) as finished_goods'))
            ->groupBy('product_id');

        $salesSub = SaleItem::query()
            ->select('product_id', DB::raw('SUM(quantity_sold) as sold_units'))
            ->groupBy('product_id');

        $query = Product::query()
            ->leftJoinSub($productionSub, 'production_totals', fn ($join) => $join->on('products.id', '=', 'production_totals.product_id'))
            ->leftJoinSub($salesSub, 'sales_totals', fn ($join) => $join->on('products.id', '=', 'sales_totals.product_id'))
            ->select('products.*')
            ->selectRaw('COALESCE(production_totals.finished_goods, 0) as finished_goods')
            ->selectRaw('COALESCE(sales_totals.sold_units, 0) as sold_units');

        if (Schema::hasColumn('inventory_records', 'product_id')) {
            $inventorySub = InventoryRecord::query()
                ->select('product_id', DB::raw('SUM(quantity_in - quantity_out) as stock_on_hand'))
                ->whereNotNull('product_id')
                ->groupBy('product_id');

            $query->leftJoinSub($inventorySub, 'inventory_totals', fn ($join) => $join->on('products.id', '=', 'inventory_totals.product_id'))
                ->selectRaw('COALESCE(inventory_totals.stock_on_hand, 0) as stock_on_hand')
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
        } else {
            $query->selectRaw('COALESCE(production_totals.finished_goods, 0) as stock_on_hand')
                ->selectRaw('
                    CASE
                        WHEN COALESCE(production_totals.finished_goods, 0) < 0 THEN 0
                        ELSE COALESCE(production_totals.finished_goods, 0)
                    END as sellable_qty
                ');
        }

        return $query;
    }

    private function bestSellers(int $limit): Collection
    {
        return SaleItem::query()
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->selectRaw('products.id, products.name, products.barcode, products.image_path, products.price, SUM(sale_items.quantity_sold) as units_sold')
            ->groupBy('products.id', 'products.name', 'products.barcode', 'products.image_path', 'products.price')
            ->orderByDesc('units_sold')
            ->limit($limit)
            ->get();
    }

    /**
     * @return array<int, array{title: string, body: string}>
     */
    private function promotionBlocks(): array
    {
        return [
            [
                'title' => 'Premium Flavor Campaign',
                'body' => 'Freshly processed chili sauces with consistent premium quality from SHAKY Ltd.',
            ],
            [
                'title' => 'Retail Expansion Offer',
                'body' => 'Now available through SIMBA, T2000, and Deluxe Supermarket chains.',
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

            $price = max((float) $product->price, 0);

            return [
                'product' => $product,
                'quantity' => (int) $quantity,
                'unit_price' => $price,
                'line_total' => $price * (int) $quantity,
            ];
        })->filter()->values();
    }
}
