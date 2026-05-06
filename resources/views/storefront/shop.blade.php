<x-layouts.storefront title="Shop">
    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h1 class="text-3xl font-bold">Shop</h1>
                <p class="mt-1 text-sm text-slate-600">Browse SHAKY Ltd products with live ERP-connected stock data.</p>
            </div>
        </div>

        <form method="GET" class="mt-6 rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex flex-wrap items-end gap-3">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search products..." class="w-full max-w-sm rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <select name="category" class="w-full max-w-xs rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">All categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white">Apply</button>
            </div>
        </form>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-slate-500">{{ $product->type }}</p>
                    <h2 class="mt-2 text-lg font-semibold">{{ $product->name }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $product->description ?: 'Premium SHAKY chili product.' }}</p>
                    <div class="mt-3 space-y-1 text-sm">
                        <p><span class="font-medium">Stock:</span> {{ number_format((float) $product->sellable_qty, 2) }}</p>
                        <p><span class="font-medium">Sold units:</span> {{ number_format((float) $product->sold_units, 2) }}</p>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('storefront.product', $product->id) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700">Details</a>
                        <form method="POST" action="{{ route('storefront.cart.add', $product->id) }}">
                            @csrf
                            <button class="rounded-lg bg-[#0b4e5b] px-3 py-2 text-xs font-medium text-white">Add to Cart</button>
                        </form>
                        <form method="POST" action="{{ route('storefront.wishlist.add', $product->id) }}">
                            @csrf
                            <button class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700">Wishlist</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </section>
</x-layouts.storefront>
