<x-layouts.admin title="E-Commerce Product Variants">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Catalog</p>
            <h2 class="text-2xl font-semibold text-slate-900">Product Variants</h2>
            <p class="mt-1 text-sm text-slate-600">
                Variant-style grouping inferred from existing ERP product attributes (barcode, type, naming).
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-sm">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Search variant data</label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Barcode, name, type..."
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
                            <a href="{{ route('admin.ecommerce.catalog.variants', array_merge(request()->query(), ['sort' => 'variant_label', 'direction' => $sort === 'variant_label' ? $nextDirection : 'asc'])) }}">Variant</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Type Preview</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.variants', array_merge(request()->query(), ['sort' => 'products_count', 'direction' => $sort === 'products_count' ? $nextDirection : 'desc'])) }}">Products</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.variants', array_merge(request()->query(), ['sort' => 'stock_on_hand', 'direction' => $sort === 'stock_on_hand' ? $nextDirection : 'desc'])) }}">Stock On Hand</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.variants', array_merge(request()->query(), ['sort' => 'sold_units', 'direction' => $sort === 'sold_units' ? $nextDirection : 'desc'])) }}">Sold Units</a>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($variants as $variant)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $variant['variant_label'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $variant['type_preview'] ?: 'N/A' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $variant['products_count'], 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $variant['stock_on_hand'], 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $variant['sold_units'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No variants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $variants->links() }}
    </section>
</x-layouts.admin>
