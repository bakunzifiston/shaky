<x-layouts.admin title="E-Commerce Payments">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Sales</p>
            <h2 class="text-2xl font-semibold text-slate-900">Payments</h2>
            <p class="mt-1 text-sm text-slate-600">
                Settlement and follow-up queue based on current ERP payment status and sales totals.
            </p>
        </header>

        <div class="grid gap-4 md:grid-cols-4">
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Orders</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format((float) $totals->total_orders, 0) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Gross Revenue</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">{{ number_format((float) $totals->gross_revenue, 2) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Paid Amount</p>
                <p class="mt-2 text-xl font-semibold text-emerald-700">{{ number_format((float) $totals->paid_amount, 2) }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Outstanding</p>
                <p class="mt-2 text-xl font-semibold text-amber-700">{{ number_format((float) $totals->outstanding_amount, 2) }}</p>
            </article>
        </div>

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
                <div class="w-full max-w-[220px]">
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Payment Status</label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($status === 'all')>All</option>
                        <option value="Paid" @selected($status === 'Paid')>Paid</option>
                        <option value="Pending" @selected($status === 'Pending')>Pending</option>
                        <option value="Credit" @selected($status === 'Credit')>Credit</option>
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
                            <a href="{{ route('admin.ecommerce.sales.payments', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.payments', array_merge(request()->query(), ['sort' => 'sales_id', 'direction' => $sort === 'sales_id' ? $nextDirection : 'asc'])) }}">Order ID</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.payments', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.payments', array_merge(request()->query(), ['sort' => 'total_revenue', 'direction' => $sort === 'total_revenue' ? $nextDirection : 'desc'])) }}">Order Total</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Outstanding</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Priority</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.sales.payments', array_merge(request()->query(), ['sort' => 'payment_status', 'direction' => $sort === 'payment_status' ? $nextDirection : 'asc'])) }}">Payment</a>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($payments as $paymentRow)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $paymentRow->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $paymentRow->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $paymentRow->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $paymentRow->total_revenue, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $paymentRow->outstanding_amount, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $paymentRow->settlement_priority }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $paymentRow->payment_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $payments->links() }}
    </section>
</x-layouts.admin>
