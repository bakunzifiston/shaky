<x-layouts.storefront :title="$details->name">
    <section class="mx-auto max-w-6xl px-4 py-12 lg:px-8">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="grid gap-8 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-8">
                @if ($details->image_path)
                    <img src="{{ asset('storage/' . $details->image_path) }}" alt="{{ $details->name }}" class="h-72 w-full rounded-xl object-cover">
                @else
                    <div class="flex h-72 items-center justify-center rounded-xl bg-gradient-to-br from-[#fef7ef] to-[#f8fafc] text-center text-slate-500">
                        Premium SHAKY Product Visual
                    </div>
                @endif
            </div>
            <div>
                <h1 class="mt-2 text-3xl font-bold">{{ $details->name }}</h1>
                <p class="mt-4 text-slate-600">{{ $details->description ?: 'Premium chili product by SHAKY Ltd.' }}</p>
                <div class="mt-5 space-y-2 text-sm">
                    <p><span class="font-medium">Price:</span> RWF {{ number_format((float) $details->price, 2) }}</p>
                    <p><span class="font-medium">Stock available:</span> {{ number_format((float) $details->sellable_qty, 2) }}</p>
                    <p><span class="font-medium">Barcode:</span> {{ $details->barcode }}</p>
                </div>
                <div class="mt-6 flex gap-3">
                    <form method="POST" action="{{ route('storefront.cart.add', $details->id) }}" class="flex items-center gap-2">
                        @csrf
                        <input type="number" min="1" name="quantity" value="1" class="w-16 rounded-lg border border-slate-300 px-2 py-2 text-sm">
                        <button class="rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white">Add to Cart</button>
                    </form>
                    <form method="POST" action="{{ route('storefront.wishlist.add', $details->id) }}">
                        @csrf
                        <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Wishlist</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="text-xl font-semibold">Product Variants</h2>
                <div class="mt-3 space-y-2 text-sm text-slate-700">
                    @forelse ($variants as $variant)
                        <p>{{ $variant->name }} ({{ $variant->barcode }})</p>
                    @empty
                        <p>No additional variants available yet.</p>
                    @endforelse
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-6">
                <h2 class="text-xl font-semibold">Reviews & Ratings</h2>
                <div class="mt-3 space-y-3 text-sm">
                    @forelse ($reviews as $review)
                        <article class="rounded-lg bg-slate-50 p-3">
                            <p class="font-medium">{{ $review->customer_name }} - {{ $review->rating }}/5</p>
                            <p class="text-slate-600">{{ $review->comment }}</p>
                        </article>
                    @empty
                        <p class="text-slate-600">No reviews yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.storefront>
