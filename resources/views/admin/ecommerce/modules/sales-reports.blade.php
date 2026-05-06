<x-layouts.admin title="E-Commerce Sales Reports">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Analytics</p>
            <h2 class="text-2xl font-semibold text-slate-900">Sales Reports</h2>
            <p class="mt-1 text-sm text-slate-600">
                Performance reporting for orders, channels, products, payment mix, and return behavior.
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-[180px]">
                    <label for="period" class="mb-1 block text-sm font-medium text-slate-700">Period</label>
                    <select
                        id="period"
                        name="period"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="7d" @selected($period === '7d')>Last 7 days</option>
                        <option value="30d" @selected($period === '30d')>Last 30 days</option>
                        <option value="90d" @selected($period === '90d')>Last 90 days</option>
                        <option value="365d" @selected($period === '365d')>Last 12 months</option>
                    </select>
                </div>
                <button type="submit" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Apply
                </button>
                <p class="text-xs text-slate-500">Range: {{ $startDate }} to {{ $endDate }}</p>
            </div>
        </form>

        <div class="grid gap-4 md:grid-cols-5">
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Orders</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format((float) $kpis->orders_count, 0) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Gross Revenue</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format((float) $kpis->gross_revenue, 2) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Avg Order</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format((float) $kpis->avg_order_value, 2) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Paid Revenue</p>
                <p class="mt-2 text-xl font-semibold text-emerald-700">{{ number_format((float) $kpis->paid_revenue, 2) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Returned Orders</p>
                <p class="mt-2 text-xl font-semibold text-amber-700">{{ number_format((float) $kpis->returned_orders, 0) }}</p>
            </article>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-4 py-3">
                    <h3 class="text-sm font-semibold text-slate-900">Channel Performance</h3>
                </div>
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Channel</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Orders</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Revenue</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Avg Order</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Returns</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($channelPerformance as $row)
                            <tr>
                                <td class="px-4 py-3 text-slate-800">{{ $row->sales_channel }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->orders_count, 0) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->revenue, 2) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->avg_order_value, 2) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->returned_orders, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">No channel data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-4 py-3">
                    <h3 class="text-sm font-semibold text-slate-900">Top Products</h3>
                </div>
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Product</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Units Sold</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($topProducts as $row)
                            <tr>
                                <td class="px-4 py-3 text-slate-800">{{ $row->product_name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->units_sold, 2) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-500">No product data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-4 py-3">
                <h3 class="text-sm font-semibold text-slate-900">Payment Mix</h3>
            </div>
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Payment Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Orders</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($paymentMix as $row)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $row->payment_status }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->orders_count, 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row->revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-500">No payment mix data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.admin>
