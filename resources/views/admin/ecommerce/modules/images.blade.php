<x-layouts.admin title="E-Commerce Product Images">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Catalog</p>
            <h2 class="text-2xl font-semibold text-slate-900">Product Images</h2>
            <p class="mt-1 text-sm text-slate-600">
                Image readiness audit from existing product records and current filesystem locations.
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-sm">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Search products</label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Type, name, barcode..."
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
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Preview</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.images', array_merge(request()->query(), ['sort' => 'type', 'direction' => $sort === 'type' ? $nextDirection : 'asc'])) }}">Name</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.images', array_merge(request()->query(), ['sort' => 'name', 'direction' => $sort === 'name' ? $nextDirection : 'asc'])) }}">Type</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.images', array_merge(request()->query(), ['sort' => 'barcode', 'direction' => $sort === 'barcode' ? $nextDirection : 'asc'])) }}">Barcode</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Image Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Source</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->type }}" class="h-11 w-11 rounded-lg object-cover ring-1 ring-slate-200">
                                @else
                                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500 ring-1 ring-slate-200">N/A</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-800">{{ $product->type }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $product->barcode }}</td>
                            <td class="px-4 py-3">
                                @if ($product->has_image)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">Image Found</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 ring-1 ring-amber-200">Missing</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">{{ $product->image_source ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </section>
</x-layouts.admin>
