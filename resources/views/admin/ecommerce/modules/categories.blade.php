<x-layouts.admin title="E-Commerce Product Categories">
    <section class="space-y-6">
        <header>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">E-Commerce / Catalog</p>
            <h2 class="text-2xl font-semibold text-slate-900">Product Categories</h2>
            <p class="mt-1 text-sm text-slate-600">
                Category-like grouping derived from your existing product type structure, ready for storefront mapping.
            </p>
        </header>

        <form method="GET" class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-3">
                <div class="w-full max-w-sm">
                    <label for="search" class="mb-1 block text-sm font-medium text-slate-700">Search category</label>
                    <input
                        id="search"
                        name="search"
                        type="text"
                        value="{{ $search }}"
                        placeholder="Category name..."
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
                            <a href="{{ route('admin.ecommerce.catalog.categories', array_merge(request()->query(), ['sort' => 'category', 'direction' => $sort === 'category' ? $nextDirection : 'asc'])) }}">Category</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.categories', array_merge(request()->query(), ['sort' => 'products_count', 'direction' => $sort === 'products_count' ? $nextDirection : 'desc'])) }}">Products</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.categories', array_merge(request()->query(), ['sort' => 'stock_on_hand', 'direction' => $sort === 'stock_on_hand' ? $nextDirection : 'desc'])) }}">Stock On Hand</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">
                            <a href="{{ route('admin.ecommerce.catalog.categories', array_merge(request()->query(), ['sort' => 'sold_units', 'direction' => $sort === 'sold_units' ? $nextDirection : 'desc'])) }}">Sold Units</a>
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $category->category }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $category->products_count, 0) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $category->stock_on_hand, 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $category->sold_units, 2) }}</td>
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('admin.ecommerce.catalog.products', ['category' => $category->category === 'Uncategorized' ? '' : $category->category]) }}"
                                    class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50"
                                >
                                    View Products
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}
    </section>
</x-layouts.admin>
