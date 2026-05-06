@csrf

<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    <div><label class="mb-1 block text-sm">Batch ID</label><input name="batch_id" value="{{ old('batch_id', $production->batch_id ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div>
        <label class="mb-1 block text-sm">Product</label>
        <select name="product_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">Select product</option>
            @foreach($products as $id => $label)
                <option value="{{ $id }}" @selected((string) old('product_id', $production->product_id ?? '') === (string) $id)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm">Barcode</label>
        <select name="barcode" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @php($barcodes = ['6784293819719','5781429281069','5675098214278','3078055640615'])
            @foreach($barcodes as $barcode)
                <option value="{{ $barcode }}" @selected(old('barcode', $production->barcode ?? '') === $barcode)>{{ $barcode }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="mb-1 block text-sm">Quantity Produced</label><input name="quantity_produced" type="number" step="0.01" required value="{{ old('quantity_produced', $production->quantity_produced ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Damaged</label><input name="damaged" type="number" step="0.01" required value="{{ old('damaged', $production->damaged ?? 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Production Date</label><input name="production_date" type="date" required value="{{ old('production_date', isset($production) && $production->production_date ? \Illuminate\Support\Carbon::parse($production->production_date)->format('Y-m-d') : now()->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Responsible Staff</label><input name="responsible_staff" value="{{ old('responsible_staff', $production->responsible_staff ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div class="lg:col-span-2"><label class="mb-1 block text-sm">Quality Control Notes</label><textarea name="quality_control_notes" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('quality_control_notes', $production->quality_control_notes ?? '') }}</textarea></div>
</div>

<div class="mt-6">
    <div class="mb-2 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-800">Raw Materials Used</h3>
        <button id="addMaterialRow" type="button" class="rounded border border-slate-300 px-2 py-1 text-xs">Add Material</button>
    </div>
    <div id="materialsRows" class="space-y-2"></div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">{{ $submitLabel }}</button>
    <a href="{{ route('admin.productions.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Cancel</a>
</div>

<script>
(() => {
    const options = @json($inventoryOptions);
    const existing = @json(old('inventory_record_id', $production->inventory_record_id ?? []));
    const container = document.getElementById('materialsRows');
    const addButton = document.getElementById('addMaterialRow');

    const rowTemplate = (idx, material = {}) => {
        const selectedId = String(material.inventory_id ?? '');
        const qty = material.quantity_used ?? '';
        const optionsHtml = Object.entries(options).map(([id, name]) =>
            `<option value="${id}" ${String(id) === selectedId ? 'selected' : ''}>${name}</option>`
        ).join('');

        return `
            <div class="grid grid-cols-1 gap-2 md:grid-cols-[1fr_220px_auto] material-row">
                <select name="inventory_record_id[${idx}][inventory_id]" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="">Select Raw Material</option>
                    ${optionsHtml}
                </select>
                <input name="inventory_record_id[${idx}][quantity_used]" type="number" step="0.01" min="0.01" value="${qty}" required class="rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Quantity Used">
                <button type="button" class="remove-row rounded border border-slate-300 px-2 py-1 text-xs">Remove</button>
            </div>
        `;
    };

    const render = () => {
        const rows = container.querySelectorAll('.material-row');
        rows.forEach((row, idx) => {
            row.querySelector('select').name = `inventory_record_id[${idx}][inventory_id]`;
            row.querySelector('input').name = `inventory_record_id[${idx}][quantity_used]`;
        });
    };

    const appendRow = (material = {}) => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = rowTemplate(container.querySelectorAll('.material-row').length, material);
        const row = wrapper.firstElementChild;
        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();
            render();
        });
        container.appendChild(row);
        render();
    };

    if (Array.isArray(existing) && existing.length) existing.forEach((m) => appendRow(m));
    else appendRow({});

    addButton.addEventListener('click', () => appendRow({}));
})();
</script>
