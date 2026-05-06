<x-layouts.admin title="Sales">
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-2xl font-semibold text-slate-900">Sales</h2><p class="mt-1 text-sm text-slate-500">Manage multi-item sales invoices.</p></div>
            <a href="{{ route('admin.sales.create') }}" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">New Sale</a>
        </div>
        @if (session('status'))<div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex gap-3"><input name="search" value="{{ $search }}" placeholder="Search sale/customer/invoice..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"><button class="rounded-lg border border-slate-300 px-4 py-2 text-sm">Apply</button></div>
        </form>
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50"><tr><th class="px-3 py-2 text-left">Sale ID</th><th class="px-3 py-2 text-left">Customer</th><th class="px-3 py-2 text-left">Invoice</th><th class="px-3 py-2 text-left">Items</th><th class="px-3 py-2 text-left">Total Revenue</th><th class="px-3 py-2 text-left">Payment</th><th class="px-3 py-2 text-left">Delivery</th><th class="px-3 py-2 text-left">Sale Date</th><th class="px-3 py-2 text-left">Actions</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                        <tr>
                            <td class="px-3 py-2">{{ $sale->sales_id }}</td>
                            <td class="px-3 py-2">{{ $sale->customer_name }}</td>
                            <td class="px-3 py-2">{{ $sale->invoice_number }}</td>
                            <td class="px-3 py-2">{{ $sale->items_count }}</td>
                            <td class="px-3 py-2">{{ number_format($sale->total_revenue ?? 0, 0) }} RWF</td>
                            <td class="px-3 py-2">{{ $sale->payment_status }}</td>
                            <td class="px-3 py-2">{{ $sale->delivery_status }}</td>
                            <td class="px-3 py-2">{{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.sales.show', $sale) }}" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">View</a>
                                    <a href="{{ route('admin.sales.edit', $sale) }}" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">Edit</a>
                                    <form method="POST" action="{{ route('admin.sales.destroy', $sale) }}" onsubmit="return confirm('Delete this sale?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs font-medium text-rose-700 hover:bg-rose-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-6 text-center text-slate-500">No sales found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $sales->links() }}
    </section>
</x-layouts.admin>
