<x-layouts.admin title="E-Commerce Shopping Cart">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Sales</p>
            <h2 class="text-2xl font-semibold text-slate-900">Shopping Cart</h2>
            <p class="mt-1 text-sm text-slate-600">
                Cart-staging queue inferred from existing sales and line items for checkout lifecycle tracking.
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-sm">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Search</label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Customer, sale ID, invoice..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <div class="w-full max-w-[220px]">
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Cart Status</label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($status === 'all')>All</option>
                        <option value="active" @selected($status === 'active')>Active checkout</option>
                        <option value="checked_out" @selected($status === 'checked_out')>Checked out</option>
                        <option value="returned" @selected($status === 'returned')>Returned flow</option>
                    </select>
                </div>
                <button type="submit" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Apply
                </button>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    @php($nextDirection = $direction === 'asc' ? 'desc' : 'asc')
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.carts', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Sale Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Sale ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.carts', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.carts', array_merge(request()->query(), ['sort' => 'items_count', 'direction' => $sort === 'items_count' ? $nextDirection : 'desc'])) }}">Items</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.carts', array_merge(request()->query(), ['sort' => 'cart_total', 'direction' => $sort === 'cart_total' ? $nextDirection : 'desc'])) }}">Cart Total</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.carts', array_merge(request()->query(), ['sort' => 'payment_status', 'direction' => $sort === 'payment_status' ? $nextDirection : 'asc'])) }}">Payment</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Delivery</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($carts as $cart)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $cart->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $cart->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $cart->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $cart->items_count, 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $cart->cart_total, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $cart->payment_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $cart->delivery_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No cart records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $carts->links() }}
    </section>
</x-layouts.admin>
