@csrf

<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    <div><label class="mb-1 block text-sm">Supplier Name</label><input name="supplier_name" value="{{ old('supplier_name', $inventoryRecord->supplier_name ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">@error('supplier_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror</div>
    <div><label class="mb-1 block text-sm">Invoice Number</label><input name="invoice_number" value="{{ old('invoice_number', $inventoryRecord->invoice_number ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div>
        <label class="mb-1 block text-sm">Item Type</label>
        <select id="item_type" name="item_type" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="Product" @selected(old('item_type', $inventoryRecord->item_type ?? '') === 'Product')>Product</option>
            <option value="Raw Material" @selected(old('item_type', $inventoryRecord->item_type ?? '') === 'Raw Material')>Raw Material</option>
        </select>
    </div>
    <div><label class="mb-1 block text-sm">Item Name</label><input name="item_name" value="{{ old('item_name', $inventoryRecord->item_name ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div id="productWrap">
        <label class="mb-1 block text-sm">Link to Product</label>
        <select name="product_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">Select product</option>
            @foreach ($products as $id => $label)
                <option value="{{ $id }}" @selected((string) old('product_id', $inventoryRecord->product_id ?? '') === (string) $id)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="mb-1 block text-sm">Quantity In</label><input id="quantity_in" name="quantity_in" type="number" step="0.01" value="{{ old('quantity_in', $inventoryRecord->quantity_in ?? 0) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Quantity Out</label><input name="quantity_out" type="number" step="0.01" value="{{ old('quantity_out', $inventoryRecord->quantity_out ?? 0) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Unit Cost (RWF)</label><input id="unit_cost" name="unit_cost" type="number" step="0.01" value="{{ old('unit_cost', $inventoryRecord->unit_cost ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Damaged</label><input name="damaged" type="number" step="0.01" value="{{ old('damaged', $inventoryRecord->damaged ?? 0) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Storage Location</label><input name="storage_location" value="{{ old('storage_location', $inventoryRecord->storage_location ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Record Date</label><input name="record_date" type="date" value="{{ old('record_date', isset($inventoryRecord) && $inventoryRecord->record_date ? $inventoryRecord->record_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Total Amount (RWF)</label><input id="total_amount" name="total_amount" type="number" step="0.01" value="{{ old('total_amount', $inventoryRecord->total_amount ?? 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Amount Paid (RWF)</label><input id="amount_paid" name="amount_paid" type="number" step="0.01" value="{{ old('amount_paid', $inventoryRecord->amount_paid ?? 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div>
        <label class="mb-1 block text-sm">Payment Status</label>
        <select id="payment_status" name="payment_status" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="Paid" @selected(old('payment_status', $inventoryRecord->payment_status ?? 'Unpaid') === 'Paid')>Paid</option>
            <option value="Partial" @selected(old('payment_status', $inventoryRecord->payment_status ?? 'Unpaid') === 'Partial')>Partially Paid</option>
            <option value="Unpaid" @selected(old('payment_status', $inventoryRecord->payment_status ?? 'Unpaid') === 'Unpaid')>Unpaid</option>
        </select>
    </div>
    <div><label class="mb-1 block text-sm">Payment Due Date</label><input name="payment_due_date" type="date" value="{{ old('payment_due_date', isset($inventoryRecord) && $inventoryRecord->payment_due_date ? $inventoryRecord->payment_due_date->format('Y-m-d') : '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">{{ $submitLabel }}</button>
    <a href="{{ route('admin.inventory-records.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Cancel</a>
</div>

<script>
(() => {
    const itemTypeEl = document.getElementById('item_type');
    const productWrap = document.getElementById('productWrap');
    const qtyInEl = document.getElementById('quantity_in');
    const totalEl = document.getElementById('total_amount');
    const paidEl = document.getElementById('amount_paid');
    const statusEl = document.getElementById('payment_status');
    const unitCostEl = document.getElementById('unit_cost');

    const syncItemType = () => productWrap.style.display = itemTypeEl.value === 'Product' ? 'block' : 'none';
    const syncCostAndStatus = () => {
        const qty = parseFloat(qtyInEl.value || 0);
        const total = parseFloat(totalEl.value || 0);
        const paid = parseFloat(paidEl.value || 0);
        if (qty > 0 && total > 0) unitCostEl.value = (total / qty).toFixed(2);
        if (total <= 0) statusEl.value = 'Unpaid';
        else if (paid >= total) statusEl.value = 'Paid';
        else if (paid > 0) statusEl.value = 'Partial';
        else statusEl.value = 'Unpaid';
    };
    syncItemType();
    syncCostAndStatus();
    itemTypeEl.addEventListener('change', syncItemType);
    qtyInEl.addEventListener('blur', syncCostAndStatus);
    totalEl.addEventListener('blur', syncCostAndStatus);
    paidEl.addEventListener('blur', syncCostAndStatus);
})();
</script>
