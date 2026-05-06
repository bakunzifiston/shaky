<x-layouts.admin title="E-Commerce Orders Management">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Sales</p>
            <h2 class="text-2xl font-semibold text-slate-900">Orders Management</h2>
            <p class="mt-1 text-sm text-slate-600">
                Unified order ledger reusing ERP sales transactions with payment and delivery status controls.
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
                        placeholder="Sale ID, invoice, customer..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <div class="w-full max-w-[200px]">
                    <label for="payment" class="mb-1 block text-sm font-medium text-slate-700">Payment</label>
                    <select
                        id="payment"
                        name="payment"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($payment === 'all')>All</option>
                        <option value="Paid" @selected($payment === 'Paid')>Paid</option>
                        <option value="Pending" @selected($payment === 'Pending')>Pending</option>
                        <option value="Credit" @selected($payment === 'Credit')>Credit</option>
                    </select>
                </div>
                <div class="w-full max-w-[200px]">
                    <label for="delivery" class="mb-1 block text-sm font-medium text-slate-700">Delivery</label>
                    <select
                        id="delivery"
                        name="delivery"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($delivery === 'all')>All</option>
                        <option value="Delivered" @selected($delivery === 'Delivered')>Delivered</option>
                        <option value="Pending" @selected($delivery === 'Pending')>Pending</option>
                        <option value="Returned" @selected($delivery === 'Returned')>Returned</option>
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
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'sales_id', 'direction' => $sort === 'sales_id' ? $nextDirection : 'asc'])) }}">Order ID</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'items_count', 'direction' => $sort === 'items_count' ? $nextDirection : 'desc'])) }}">Items</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'order_total', 'direction' => $sort === 'order_total' ? $nextDirection : 'desc'])) }}">Order Total</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'payment_status', 'direction' => $sort === 'payment_status' ? $nextDirection : 'asc'])) }}">Payment</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.orders', array_merge(request()->query(), ['sort' => 'delivery_status', 'direction' => $sort === 'delivery_status' ? $nextDirection : 'asc'])) }}">Delivery</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $order->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $order->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $order->items_count, 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $order->order_total, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->payment_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->delivery_status }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.sales.show', $order->id) }}" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Open ERP Sale
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </section>
</x-layouts.admin>
