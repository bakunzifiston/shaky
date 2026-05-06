<x-layouts.admin title="E-Commerce Customer Management">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Customers</p>
            <h2 class="text-2xl font-semibold text-slate-900">Customer Management</h2>
            <p class="mt-1 text-sm text-slate-600">
                Customer ledger derived from existing sales history, with quick linkage to internal user accounts.
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-sm">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Search customers</label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Customer name or phone..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
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
                            <a href="{{ route('admin.ecommerce.customers.profiles', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Phone</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.profiles', array_merge(request()->query(), ['sort' => 'orders_count', 'direction' => $sort === 'orders_count' ? $nextDirection : 'desc'])) }}">Orders</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.profiles', array_merge(request()->query(), ['sort' => 'total_revenue', 'direction' => $sort === 'total_revenue' ? $nextDirection : 'desc'])) }}">Total Revenue</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Paid Revenue</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.profiles', array_merge(request()->query(), ['sort' => 'last_sale_date', 'direction' => $sort === 'last_sale_date' ? $nextDirection : 'desc'])) }}">Last Sale</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Account Link</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $customer->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->customer_phone }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $customer->orders_count, 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $customer->total_revenue, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $customer->paid_revenue, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->last_sale_date }}</td>
                            <td class="px-4 py-3">
                                @if ($customer->has_user_account)
                                    <a href="{{ route('admin.users.show', $customer->user_id) }}" class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">
                                        Linked User
                                    </a>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-200">
                                        External Customer
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $customers->links() }}
    </section>
</x-layouts.admin>
