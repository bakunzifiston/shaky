@csrf

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div><label class="mb-1 block text-sm">Customer Name</label><input name="customer_name" required value="{{ old('customer_name', $sale->customer_name ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Customer Phone</label><input name="customer_Phone" value="{{ old('customer_Phone', $sale->customer_Phone ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Invoice Number</label><input name="invoice_number" value="{{ old('invoice_number', $sale->invoice_number ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div><label class="mb-1 block text-sm">Sale Date</label><input name="sale_date" type="date" required value="{{ old('sale_date', isset($sale) ? \Illuminate\Support\Carbon::parse($sale->sale_date)->format('Y-m-d') : now()->format('Y-m-d')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"></div>
    <div>
        <label class="mb-1 block text-sm">Payment Status</label>
        <select name="payment_status" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @foreach(['Paid','Pending','Credit'] as $status)<option value="{{ $status }}" @selected(old('payment_status', $sale->payment_status ?? '') === $status)>{{ $status }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm">Delivery Status</label>
        <select name="delivery_status" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @foreach(['Delivered','Pending','In Transit'] as $status)<option value="{{ $status }}" @selected(old('delivery_status', $sale->delivery_status ?? '') === $status)>{{ $status }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm">Sales Channel</label>
        <select name="sales_channel" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @foreach(['Momo Pay','Card','Cash'] as $channel)<option value="{{ $channel }}" @selected(old('sales_channel', $sale->sales_channel ?? '') === $channel)>{{ $channel }}</option>@endforeach
        </select>
    </div>
</div>

<div class="mt-6">
    <div class="mb-2 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-800">Products</h3>
        <button id="addItemRow" type="button" class="rounded border border-slate-300 px-2 py-1 text-xs">Add Product</button>
    </div>
    <div id="saleItemsRows" class="space-y-2"></div>
    <p class="mt-3 text-sm text-slate-600">Invoice Total: <span id="invoiceTotal">0 RWF</span></p>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">{{ $submitLabel }}</button>
    <a href="{{ route('admin.sales.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Cancel</a>
</div>

<script>
(() => {
    const products = @json($products);
    const productions = @json($productions);
    const existing = @json(old('items', isset($sale) ? $sale->items->map(fn($i)=>['product_id'=>$i->product_id,'production_id'=>$i->production_id,'quantity_sold'=>$i->quantity_sold,'unit_price'=>$i->unit_price])->values()->all() : []));
    const container = document.getElementById('saleItemsRows');
    const addButton = document.getElementById('addItemRow');
    const totalLabel = document.getElementById('invoiceTotal');

    const productOptions = products.map(p => `<option value="${p.id}">${p.type}</option>`).join('');

    const batchesFor = (productId, selected='') => {
        return productions.filter(b => String(b.product_id) === String(productId))
            .map(b => `<option value="${b.id}" ${String(b.id)===String(selected)?'selected':''}>${b.batch_id}</option>`)
            .join('');
    };

    const computeTotal = () => {
        let total = 0;
        container.querySelectorAll('.sale-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value || 0);
            const price = parseFloat(row.querySelector('.price').value || 0);
            const line = Math.round((qty * price) * 100) / 100;
            row.querySelector('.line-total').value = line.toFixed(2);
            total += line;
        });
        totalLabel.textContent = `${Math.round(total).toLocaleString()} RWF`;
    };

    const renderRow = (idx, item = {}) => {
        const productId = item.product_id ?? '';
        const productionId = item.production_id ?? '';
        const qty = item.quantity_sold ?? '';
        const price = item.unit_price ?? '';
        return `
            <div class="sale-row grid grid-cols-1 gap-2 md:grid-cols-[1fr_1fr_170px_170px_170px_auto]">
                <select name="items[${idx}][product_id]" class="product-select rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="">Product</option>
                    ${products.map(p => `<option value="${p.id}" ${String(p.id)===String(productId)?'selected':''}>${p.type}</option>`).join('')}
                </select>
                <select name="items[${idx}][production_id]" class="batch-select rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="">Batch</option>${batchesFor(productId, productionId)}
                </select>
                <input name="items[${idx}][quantity_sold]" value="${qty}" type="number" step="0.01" min="0.01" class="qty rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Qty" required>
                <input name="items[${idx}][unit_price]" value="${price}" type="number" step="0.01" min="0" class="price rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Price" required>
                <input class="line-total rounded-lg border border-slate-300 px-3 py-2 text-sm bg-slate-50" readonly placeholder="Total">
                <button type="button" class="remove-row rounded border border-slate-300 px-2 py-1 text-xs">Remove</button>
            </div>
        `;
    };

    const reindex = () => {
        container.querySelectorAll('.sale-row').forEach((row, idx) => {
            row.querySelector('.product-select').name = `items[${idx}][product_id]`;
            row.querySelector('.batch-select').name = `items[${idx}][production_id]`;
            row.querySelector('.qty').name = `items[${idx}][quantity_sold]`;
            row.querySelector('.price').name = `items[${idx}][unit_price]`;
        });
    };

    const attachRowHandlers = (row) => {
        row.querySelector('.remove-row').addEventListener('click', () => { row.remove(); reindex(); computeTotal(); });
        row.querySelector('.qty').addEventListener('blur', computeTotal);
        row.querySelector('.price').addEventListener('blur', computeTotal);
        row.querySelector('.product-select').addEventListener('change', (e) => {
            const batch = row.querySelector('.batch-select');
            batch.innerHTML = `<option value="">Batch</option>${batchesFor(e.target.value)}`;
        });
    };

    const appendRow = (item = {}) => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = renderRow(container.querySelectorAll('.sale-row').length, item);
        const row = wrapper.firstElementChild;
        attachRowHandlers(row);
        container.appendChild(row);
        reindex();
        computeTotal();
    };

    if (Array.isArray(existing) && existing.length) existing.forEach(appendRow); else appendRow({});
    addButton.addEventListener('click', () => appendRow({}));
})();
</script>
