<x-layouts.admin title="View Sale">
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900">Sale Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.sales.edit', $sale) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.sales.destroy', $sale) }}" onsubmit="return confirm('Delete this sale?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white">Delete</button></form>
            </div>
        </div>
        @if (session('status'))<div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div><dt class="text-sm text-slate-500">Sale ID</dt><dd class="mt-1 text-sm font-medium">{{ $sale->sales_id }}</dd></div>
                <div><dt class="text-sm text-slate-500">Customer</dt><dd class="mt-1 text-sm font-medium">{{ $sale->customer_name }}</dd></div>
                <div><dt class="text-sm text-slate-500">Invoice</dt><dd class="mt-1 text-sm font-medium">{{ $sale->invoice_number ?? '—' }}</dd></div>
                <div><dt class="text-sm text-slate-500">Payment</dt><dd class="mt-1 text-sm font-medium">{{ $sale->payment_status }}</dd></div>
                <div><dt class="text-sm text-slate-500">Delivery</dt><dd class="mt-1 text-sm font-medium">{{ $sale->delivery_status }}</dd></div>
                <div><dt class="text-sm text-slate-500">Revenue</dt><dd class="mt-1 text-sm font-medium">{{ number_format($sale->total_revenue ?? 0, 0) }} RWF</dd></div>
            </dl>
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-800">Items</h3>
                <table class="mt-2 min-w-full text-sm">
                    <thead><tr><th class="px-2 py-1 text-left">Product</th><th class="px-2 py-1 text-left">Batch</th><th class="px-2 py-1 text-left">Qty</th><th class="px-2 py-1 text-left">Price</th><th class="px-2 py-1 text-left">Total</th></tr></thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr><td class="px-2 py-1">{{ $item->product?->type }}</td><td class="px-2 py-1">{{ $item->production?->batch_id }}</td><td class="px-2 py-1">{{ number_format($item->quantity_sold,2) }}</td><td class="px-2 py-1">{{ number_format($item->unit_price,0) }} RWF</td><td class="px-2 py-1">{{ number_format($item->line_total,0) }} RWF</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layouts.admin>
