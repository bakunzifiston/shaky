<x-layouts.admin title="E-Commerce Notifications">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Customers</p>
            <h2 class="text-2xl font-semibold text-slate-900">Notifications</h2>
            <p class="mt-1 text-sm text-slate-600">
                Operational notification queue generated from existing sales, payment, and delivery workflow signals.
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
                <div class="w-full max-w-[250px]">
                    <label for="event" class="mb-1 block text-sm font-medium text-slate-700">Event Filter</label>
                    <select
                        id="event"
                        name="event"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($event === 'all')>All events</option>
                        <option value="delivery_pending" @selected($event === 'delivery_pending')>Delivery pending</option>
                        <option value="delivered" @selected($event === 'delivered')>Delivered</option>
                        <option value="payment_pending" @selected($event === 'payment_pending')>Payment pending/credit</option>
                        <option value="payment_received" @selected($event === 'payment_received')>Payment received</option>
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
                            <a href="{{ route('admin.ecommerce.customers.notifications', array_merge(request()->query(), ['sort' => 'sale_date', 'direction' => $sort === 'sale_date' ? $nextDirection : 'desc'])) }}">Sale Date</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Sale ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.customers.notifications', array_merge(request()->query(), ['sort' => 'customer_name', 'direction' => $sort === 'customer_name' ? $nextDirection : 'asc'])) }}">Customer</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Contact</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Event Type</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Message Template</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($notifications as $notification)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $notification->sale_date }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $notification->sales_id }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $notification->customer_name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $notification->customer_Phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $notification->event_type }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">{{ $notification->event_message }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $notification->total_revenue, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No notification events found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $notifications->links() }}
    </section>
</x-layouts.admin>
