<x-layouts.admin title="E-Commerce Product Management">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Catalog</p>
            <h2 class="text-2xl font-semibold text-slate-900">Product Management</h2>
            <p class="mt-1 text-sm text-slate-600">
                ERP-linked product index for storefront readiness, stock visibility, and sales movement.
            </p>
            @if ($category !== '')
                <p class="mt-2 text-xs font-medium text-sky-700">
                    Category filter active: {{ $category }}
                </p>
            @endif
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
                        placeholder="Name, type, barcode, description..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                </div>
                <input type="hidden" name="category" value="{{ $category }}">

                <div class="w-full max-w-[220px]">
                    <label for="stock" class="mb-1 block text-sm font-medium text-slate-700">Stock Filter</label>
                    <select
                        id="stock"
                        name="stock"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-teal-600 focus:outline-none"
                    >
                        <option value="all" @selected($stockFilter === 'all')>All</option>
                        <option value="in_stock" @selected($stockFilter === 'in_stock')>In stock</option>
                        <option value="out_of_stock" @selected($stockFilter === 'out_of_stock')>Out of stock</option>
                    </select>
                </div>

                <button type="submit" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    Apply
                </button>
                @if ($category !== '')
                    <a href="{{ route('admin.ecommerce.catalog.products', request()->except('category')) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        Clear Category
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    @php($nextDirection = $direction === 'asc' ? 'desc' : 'asc')
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.products', array_merge(request()->query(), ['sort' => 'type', 'direction' => $sort === 'type' ? $nextDirection : 'asc'])) }}">Name</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.products', array_merge(request()->query(), ['sort' => 'name', 'direction' => $sort === 'name' ? $nextDirection : 'asc'])) }}">Type</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Barcode</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.products', array_merge(request()->query(), ['sort' => 'stock_on_hand', 'direction' => $sort === 'stock_on_hand' ? $nextDirection : 'desc'])) }}">Stock On Hand</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.products', array_merge(request()->query(), ['sort' => 'available_finished_goods', 'direction' => $sort === 'available_finished_goods' ? $nextDirection : 'desc'])) }}">Finished Goods</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.products', array_merge(request()->query(), ['sort' => 'sold_units', 'direction' => $sort === 'sold_units' ? $nextDirection : 'desc'])) }}">Sold Units</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $product->type }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $product->barcode ?: 'N/A' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $product->stock_on_hand, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $product->available_finished_goods, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $product->sold_units, 2) }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.products.show', $product) }}" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Open ERP Product
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </section>
</x-layouts.admin>
