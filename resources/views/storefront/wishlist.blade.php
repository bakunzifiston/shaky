<x-layouts.storefront title="Wishlist">
    <section class="mx-auto max-w-6xl px-4 py-12 lg:px-8">
        <h1 class="text-3xl font-bold">Wishlist</h1>
        <p class="mt-2 text-sm text-slate-600">Saved products for future purchase.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($items as $product)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-slate-500">{{ $product->type }}</p>
                    <h2 class="mt-2 text-lg font-semibold">{{ $product->name }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $product->description ?: 'Premium SHAKY product.' }}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('storefront.product', $product->id) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700">Details</a>
                        <form method="POST" action="{{ route('storefront.cart.add', $product->id) }}">
                            @csrf
                            <button class="rounded-lg bg-[#0b4e5b] px-3 py-2 text-xs font-medium text-white">Add to Cart</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="text-sm text-slate-500">No wishlist items yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.storefront>
