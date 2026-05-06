<x-layouts.admin title="View Inventory Record">
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900">Inventory Record Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.inventory-records.edit', $inventoryRecord) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.inventory-records.destroy', $inventoryRecord) }}" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white">Delete</button></form>
            </div>
        </div>
        @if (session('status'))<div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><dt class="text-sm text-slate-500">Supplier</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->supplier_name }}</dd></div>
                <div><dt class="text-sm text-slate-500">Invoice</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->invoice_number ?? '—' }}</dd></div>
                <div><dt class="text-sm text-slate-500">Item Type</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->item_type }}</dd></div>
                <div><dt class="text-sm text-slate-500">Item Name</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->item_name }}</dd></div>
                <div><dt class="text-sm text-slate-500">Unit Cost</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->unit_cost ? number_format($inventoryRecord->unit_cost, 0).' RWF' : '-' }}</dd></div>
                <div><dt class="text-sm text-slate-500">Line Value</dt><dd class="mt-1 text-sm font-medium">{{ number_format($inventoryRecord->line_value, 0) }} RWF</dd></div>
                <div><dt class="text-sm text-slate-500">Payment Status</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->payment_status }}</dd></div>
                <div><dt class="text-sm text-slate-500">Overdue</dt><dd class="mt-1 text-sm font-medium">{{ $inventoryRecord->is_overdue ? 'Yes' : 'No' }}</dd></div>
            </dl>
        </div>
    </section>
</x-layouts.admin>
