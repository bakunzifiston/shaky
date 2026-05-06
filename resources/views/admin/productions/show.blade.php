<x-layouts.admin title="View Production">
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-900">Production Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.productions.edit', $production) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.productions.destroy', $production) }}" onsubmit="return confirm('Delete this production?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white">Delete</button></form>
            </div>
        </div>
        @if (session('status'))<div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div><dt class="text-sm text-slate-500">Batch</dt><dd class="mt-1 text-sm font-medium">{{ $production->batch_id }}</dd></div>
                <div><dt class="text-sm text-slate-500">Product</dt><dd class="mt-1 text-sm font-medium">{{ $production->product?->type }}</dd></div>
                <div><dt class="text-sm text-slate-500">Produced</dt><dd class="mt-1 text-sm font-medium">{{ number_format($production->quantity_produced, 2) }} bottles</dd></div>
                <div><dt class="text-sm text-slate-500">Damaged</dt><dd class="mt-1 text-sm font-medium">{{ number_format($production->damaged, 2) }}</dd></div>
                <div><dt class="text-sm text-slate-500">Date</dt><dd class="mt-1 text-sm font-medium">{{ \Illuminate\Support\Carbon::parse($production->production_date)->format('Y-m-d') }}</dd></div>
                <div><dt class="text-sm text-slate-500">Staff</dt><dd class="mt-1 text-sm font-medium">{{ $production->responsible_staff ?: '—' }}</dd></div>
                <div><dt class="text-sm text-slate-500">Barcode</dt><dd class="mt-1 text-sm font-medium">{{ $production->barcode }}</dd></div>
            </dl>
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-800">Raw Materials & Qty Used</h3>
                @php($materials = is_array($production->inventory_record_id) ? $production->inventory_record_id : (json_decode($production->inventory_record_id ?? '[]', true) ?? []))
                <ul class="mt-2 list-disc pl-6 text-sm text-slate-700">
                    @forelse($materials as $item)
                        <li>{{ \App\Models\InventoryRecord::find($item['inventory_id'] ?? null)?->item_name ?? 'Unknown' }}: {{ $item['quantity_used'] ?? 0 }}</li>
                    @empty
                        <li>—</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
</x-layouts.admin>
