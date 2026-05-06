<x-layouts.storefront title="Home">
    <section class="bg-gradient-to-br from-[#0b4e5b] to-[#06343d] text-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-[#d1b89c]">Premium Chili Brand</p>
                <h1 class="mt-4 text-4xl font-bold leading-tight lg:text-5xl">Flavor That Elevates Every Meal</h1>
                <p class="mt-5 text-base text-slate-100/90">SHAKY Ltd produces and processes high-quality chili products in Kamonyi, Rwanda, empowering local farmers with sustainable value chains.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('storefront.shop') }}" class="rounded-lg bg-[#d1b89c] px-5 py-3 text-sm font-semibold text-[#2f2418]">Shop Now</a>
                    <a href="{{ route('storefront.about') }}" class="rounded-lg border border-white/30 px-5 py-3 text-sm font-semibold">Our Story</a>
                </div>
            </div>
            <div class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/20">
                <h2 class="text-xl font-semibold">Featured Promotions</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($promotions as $promo)
                        <article class="rounded-xl bg-white/10 p-4">
                            <h3 class="font-semibold">{{ $promo['title'] }}</h3>
                            <p class="mt-1 text-sm text-white/85">{{ $promo['body'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
        <h2 class="text-2xl font-bold">Featured Products</h2>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-slate-500">{{ $product->type }}</p>
                    <h3 class="mt-2 text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $product->description ?: 'Premium SHAKY chili product.' }}</p>
                    <p class="mt-3 text-sm font-medium text-[#0b4e5b]">Stock: {{ number_format((float) $product->sellable_qty, 2) }}</p>
                    <a href="{{ route('storefront.product', $product->id) }}" class="mt-4 inline-flex text-sm font-semibold text-[#0b4e5b]">View details</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
            <h2 class="text-2xl font-bold">Product Categories</h2>
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach ($categories as $category)
                    <a href="{{ route('storefront.shop', ['category' => $category]) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ $category }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
        <h2 class="text-2xl font-bold">Best Selling Products</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @foreach ($bestSellers as $best)
                <article class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="text-sm text-slate-500">{{ $best->type }}</p>
                    <h3 class="mt-1 font-semibold">{{ $best->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600">Units sold: {{ number_format((float) $best->units_sold, 2) }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-[#fef7ef]">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
            <h2 class="text-2xl font-bold">Why Choose SHAKY Ltd</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Locally Sourced Chili</h3><p class="mt-2 text-sm text-slate-600">Partnering with local farmers for traceable ingredients.</p></article>
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Premium Quality</h3><p class="mt-2 text-sm text-slate-600">Strict hygiene and consistent processing standards.</p></article>
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Digital Transformation</h3><p class="mt-2 text-sm text-slate-600">ERP-connected operations for accurate stock and order flow.</p></article>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
        <h2 class="text-2xl font-bold">Testimonials</h2>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <article class="rounded-xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-600">“Neza Chill is balanced and flavorful. Perfect for family meals.”</p><p class="mt-3 text-sm font-semibold">Retail customer</p></article>
            <article class="rounded-xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-600">“Reliable supply and premium packaging quality for shelves.”</p><p class="mt-3 text-sm font-semibold">Supermarket manager</p></article>
            <article class="rounded-xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-600">“SHAKY Ltd creates meaningful market opportunities for farmers.”</p><p class="mt-3 text-sm font-semibold">Farmer partner</p></article>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
            <h2 class="text-2xl font-bold">Partner Supermarkets</h2>
            <div class="mt-5 flex flex-wrap gap-3">
                @foreach ($partners as $partner)
                    <span class="rounded-lg border border-slate-300 bg-slate-50 px-4 py-2 text-sm font-medium">{{ $partner }}</span>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.storefront>
