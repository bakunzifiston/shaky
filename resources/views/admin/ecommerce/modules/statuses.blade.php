<x-layouts.admin title="E-Commerce Order Status Tracking">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Sales</p>
            <h2 class="text-2xl font-semibold text-slate-900">Order Status Tracking</h2>
            <p class="mt-1 text-sm text-slate-600">
                Timeline-oriented monitoring of order progress and operational risk based on existing ERP statuses.
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
                        placeholder="Order ID, customer, invoice..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <div class="w-full max-w-[240px]">
                    <label for="stage" class="mb-1 block text-sm font-medium text-slate-700">Stage Filter</label>
                    <select
                        id="stage"
                        name="stage"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($stage === 'all')>All stages</option>
                        <option value="processing" @selected($stage === 'processing')>Processing</option>
                        <option value="completed" @selected($stage === 'completed')>Completed</option>
                        <option value="at_risk" @selected($stage === 'at_risk')>At risk / exception</option>
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
                            <a href="{{ route('admin.ecommerce.sales.statuses', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.statuses', array_merge(request()->query(), ['sort' => 'sales_id', 'direction' => $sort === 'sales_id' ? $nextDirection : 'asc'])) }}">Order ID</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.statuses', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Payment</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Delivery</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Stage</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Aging (days)</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Timeline Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $order->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $order->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->payment_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->delivery_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->status_stage }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $order->aging_days }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $order->status_note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-500">No status records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </section>
</x-layouts.admin>
