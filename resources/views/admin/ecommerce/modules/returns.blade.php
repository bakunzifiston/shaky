<x-layouts.admin title="E-Commerce Returns & Refunds">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Sales</p>
            <h2 class="text-2xl font-semibold text-slate-900">Returns &amp; Refunds</h2>
            <p class="mt-1 text-sm text-slate-600">
                Exception queue for returned deliveries, refund candidates, and credit reversal scenarios.
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
                        placeholder="Order ID, invoice, customer..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <div class="w-full max-w-[260px]">
                    <label for="scope" class="mb-1 block text-sm font-medium text-slate-700">Scope</label>
                    <select
                        id="scope"
                        name="scope"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($scope === 'all')>All exceptions</option>
                        <option value="returned_only" @selected($scope === 'returned_only')>Returned only</option>
                        <option value="refund_candidates" @selected($scope === 'refund_candidates')>Refund candidates (paid + returned)</option>
                        <option value="credit_reversals" @selected($scope === 'credit_reversals')>Credit reversals (returned + pending/credit)</option>
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
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'sales_id', 'direction' => $sort === 'sales_id' ? $nextDirection : 'asc'])) }}">Order ID</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'total_revenue', 'direction' => $sort === 'total_revenue' ? $nextDirection : 'desc'])) }}">Order Total</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'delivery_status', 'direction' => $sort === 'delivery_status' ? $nextDirection : 'asc'])) }}">Delivery</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.returns', array_merge(request()->query(), ['sort' => 'payment_status', 'direction' => $sort === 'payment_status' ? $nextDirection : 'asc'])) }}">Payment</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Recommended Action</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Estimated Refund</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($returns as $return)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $return->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $return->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $return->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $return->total_revenue, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $return->delivery_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $return->payment_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $return->recommended_action }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $return->estimated_refund, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-500">No return/refund records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $returns->links() }}
    </section>
</x-layouts.admin>
