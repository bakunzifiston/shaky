<x-layouts.admin title="E-Commerce Reviews & Ratings">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Customers</p>
            <h2 class="text-2xl font-semibold text-slate-900">Reviews &amp; Ratings</h2>
            <p class="mt-1 text-sm text-slate-600">
                Moderation-ready review opportunity queue derived from completed ERP sales flow.
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
                        placeholder="Customer, phone, product..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <div class="w-full max-w-[220px]">
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Queue Status</label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($status === 'all')>All</option>
                        <option value="ready" @selected($status === 'ready')>Ready for review request</option>
                        <option value="pending" @selected($status === 'pending')>Pending delivery</option>
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
                            <a href="{{ route('admin.ecommerce.customers.reviews', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Sale Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.reviews', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Phone</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.reviews', array_merge(request()->query(), ['sort' => 'product_name', 'direction' => $sort === 'product_name' ? $nextDirection : 'asc'])) }}">Product</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Queue State</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Suggested Rating</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.reviews', array_merge(request()->query(), ['sort' => 'line_total', 'direction' => $sort === 'line_total' ? $nextDirection : 'desc'])) }}">Line Total</a>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reviews as $review)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $review->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $review->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $review->customer_phone }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $review->product_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $review->review_state }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $review->suggested_rating }}/5</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $review->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No review candidates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $reviews->links() }}
    </section>
</x-layouts.admin>
