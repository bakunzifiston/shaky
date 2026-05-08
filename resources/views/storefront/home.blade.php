<x-layouts.storefront title="Home">
    <style>
        .hero-slide {
            animation: heroFade 15s infinite;
            opacity: 0;
        }

        .hero-slide:nth-child(1) {
            animation-delay: 0s;
        }

        .hero-slide:nth-child(2) {
            animation-delay: 5s;
        }

        .hero-slide:nth-child(3) {
            animation-delay: 10s;
        }

        @keyframes heroFade {
            0%, 28% {
                opacity: 1;
            }
            33%, 100% {
                opacity: 0;
            }
        }
    </style>

    <section class="relative overflow-hidden text-white">
        <div class="absolute inset-0">
            <img src="{{ asset('images/storefront/team.png') }}" alt="SHAKY team with chili products" class="hero-slide absolute inset-0 h-full w-full object-cover">
            <img src="{{ asset('images/storefront/award.png') }}" alt="SHAKY founder receiving award recognition" class="hero-slide absolute inset-0 h-full w-full object-cover">
            <img src="{{ asset('images/storefront/pitching.png') }}" alt="SHAKY pitching event presentation" class="hero-slide absolute inset-0 h-full w-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#0b4e5b]/85 to-[#06343d]/90"></div>
        <div class="relative mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-[#d1b89c]">Premium Chili Brand</p>
                <h1 class="mt-4 text-4xl font-bold leading-tight lg:text-5xl">Premium Chili Flavor from Kamonyi, Rwanda</h1>
                <p class="mt-5 text-base text-slate-100/90">Founded on June 22, 2023, SHAKY Ltd specializes in chili production and processing. Our first product, Neza Chill, launched on January 9, 2024, and our portfolio now includes Neza Heat and Neza Chill Oil.</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('storefront.shop') }}" class="rounded-lg bg-[#d1b89c] px-5 py-3 text-sm font-semibold text-[#2f2418]">Shop Now</a>
                    <a href="{{ route('storefront.about') }}" class="rounded-lg border border-white/30 px-5 py-3 text-sm font-semibold">Our Story</a>
                </div>
            </div>
            <div class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-sm">
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

    <section class="bg-[#f8fafc]">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
            <h2 class="text-2xl font-bold">Mission & Vision</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <h3 class="font-semibold">Mission</h3>
                    <p class="mt-2 text-sm text-slate-600">Provide high-quality, flavorful chili products that enhance culinary experiences while supporting local farmers and ensuring sustainable production.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <h3 class="font-semibold">Vision</h3>
                    <p class="mt-2 text-sm text-slate-600">To become a leading chili processing brand in Rwanda and beyond, known for premium quality and unique flavors.</p>
                </article>
            </div>
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
                    @if ($best->image_path)
                        <img src="{{ asset('storage/' . $best->image_path) }}" alt="{{ $best->name }}" class="h-[18.75rem] w-full rounded-lg object-cover">
                    @else
                        <div class="flex h-[18.75rem] w-full items-center justify-center rounded-lg bg-slate-100 text-xs text-slate-500">No image</div>
                    @endif
                    <h3 class="mt-1 font-semibold">{{ $best->name }}</h3>
                    <p class="mt-2 text-sm font-medium text-[#0b4e5b]">Price: RWF {{ number_format((float) $best->price, 2) }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-14 lg:grid-cols-2 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900">Why SHAKY Ltd Stands Out</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Shaky Ltd offers high-quality, standardized chili products that cater to diverse spice preferences while maintaining consistent flavor, nutritional value, and hygiene standards.
                </p>
                <div class="mt-5 space-y-3 text-sm text-slate-700">
                    <p>The company stands out due to:</p>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-teal-100 text-teal-700">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.415 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <p><span class="font-semibold">Premium quality control:</span> Each batch is processed using strict quality measures to maintain uniformity.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path d="M10 2a.75.75 0 01.75.75v.783c1.21.087 2.224.46 3.07 1.07.96.692 1.6 1.72 1.944 2.97a.75.75 0 01-1.447.398c-.26-.945-.724-1.675-1.374-2.144-.675-.487-1.552-.76-2.69-.826V6a.75.75 0 11-1.5 0v-.77c-1.07.11-1.916.45-2.558 1.012-.772.675-1.25 1.64-1.457 2.85a.75.75 0 01-1.478-.252c.25-1.47.862-2.73 1.95-3.68.95-.831 2.177-1.298 3.543-1.406V2.75A.75.75 0 0110 2zm-4 10a.75.75 0 01.75.75c0 .938.244 1.705.733 2.257.507.573 1.31.935 2.517 1.027v-.784a.75.75 0 011.5 0v.765c1.17-.11 2.043-.487 2.648-1.08.683-.669 1.102-1.592 1.262-2.671a.75.75 0 011.484.22c-.197 1.328-.734 2.573-1.698 3.518-.876.858-2.042 1.395-3.696 1.525v.748a.75.75 0 01-1.5 0v-.758c-1.57-.12-2.74-.631-3.59-1.593C5.652 15.53 5.25 14.427 5.25 12.75A.75.75 0 016 12z" /></svg>
                        </span>
                        <p><span class="font-semibold">Locally sourced ingredients:</span> Chili is procured from multiple farmers, ensuring freshness and sustainability.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" /></svg>
                        </span>
                        <p><span class="font-semibold">Diverse product line:</span> Customers can choose from Neza Chill (Mild), Neza Heat (Spicy), and Neza Chill Oil (Chili-infused oil) to match their preferred spice levels.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-lime-100 text-lime-700">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11a.75.75 0 10-1.5 0v3.25c0 .199.079.39.22.53l2.25 2.25a.75.75 0 101.06-1.06l-2.03-2.03V7z" clip-rule="evenodd" /></svg>
                        </span>
                        <p><span class="font-semibold">Sustainable sourcing & production:</span> Partnerships with local farmers provide economic benefits while ensuring a steady supply of chili.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-sky-100 text-sky-700">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.414 7.414a1 1 0 01-1.414 0L3.293 9.536a1 1 0 011.414-1.414l3.879 3.878 6.707-6.707a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <p><span class="font-semibold">Safe and well-packaged products:</span> Unlike some local chili products with poor quality control, Shaky Ltd ensures proper storage, hygiene, and attractive packaging.</p>
                    </div>
                </div>
            </div>
            <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                <img src="{{ asset('images/storefront/team.png') }}" alt="Shaky Ltd quality team with chili products" class="h-full min-h-[18.75rem] w-full object-cover">
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
        <h2 class="text-2xl font-bold">Short Videos</h2>
        <p class="mt-2 text-sm text-slate-600">Quick highlights from SHAKY Ltd production, events, and product stories.</p>
        @if ($videos->isEmpty())
            <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-500">
                Videos will appear here after upload from Admin -> E-Commerce -> Catalog -> Videos.
            </div>
        @else
            @php
                $featuredVideo = $videos->first();
                $sideVideos = $videos->skip(1)->take(2);
                $extraVideos = $videos->skip(3);
            @endphp

            <div class="mt-6 grid gap-5 lg:grid-cols-3">
                <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:col-span-2">
                    <video autoplay muted loop playsinline controls preload="metadata" class="h-72 w-full rounded-xl object-cover bg-slate-900 md:h-[22rem] lg:h-[30rem]">
                        <source src="{{ asset('storage/' . $featuredVideo->video_path) }}">
                        Your browser does not support HTML video.
                    </video>
                    <h3 class="mt-3 text-sm font-semibold text-slate-900">{{ $featuredVideo->title }}</h3>
                </article>

                <div class="space-y-5">
                    @foreach ($sideVideos as $video)
                        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <video autoplay muted loop playsinline controls preload="metadata" class="h-40 w-full rounded-xl object-cover bg-slate-900">
                                <source src="{{ asset('storage/' . $video->video_path) }}">
                                Your browser does not support HTML video.
                            </video>
                            <h3 class="mt-3 text-sm font-semibold text-slate-900">{{ $video->title }}</h3>
                        </article>
                    @endforeach
                </div>
            </div>

            @if ($extraVideos->isNotEmpty())
                <div class="mt-5 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($extraVideos as $video)
                        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <video autoplay muted loop playsinline controls preload="metadata" class="h-56 w-full rounded-xl object-cover bg-slate-900">
                                <source src="{{ asset('storage/' . $video->video_path) }}">
                                Your browser does not support HTML video.
                            </video>
                            <h3 class="mt-3 text-sm font-semibold text-slate-900">{{ $video->title }}</h3>
                        </article>
                    @endforeach
                </div>
            @endif
        @endif
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
        <h2 class="text-2xl font-bold">Featured Products</h2>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $product)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-[18.75rem] w-full rounded-xl object-cover">
                    @else
                        <div class="flex h-[18.75rem] w-full items-center justify-center rounded-xl bg-slate-100 text-sm text-slate-500">No image</div>
                    @endif
                    <h3 class="mt-2 text-lg font-semibold">{{ $product->name }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $product->description ?: 'Premium SHAKY chili product.' }}</p>
                    <p class="mt-3 text-sm font-medium text-[#0b4e5b]">Price: RWF {{ number_format((float) $product->price, 2) }}</p>
                    <p class="mt-3 text-sm font-medium text-[#0b4e5b]">Stock: {{ number_format((float) $product->sellable_qty, 2) }}</p>
                    <a href="{{ route('storefront.product', $product->id) }}" class="mt-4 inline-flex text-sm font-semibold text-[#0b4e5b]">View details</a>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-[#fef7ef]">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8">
            <h2 class="text-2xl font-bold">Why Choose SHAKY Ltd</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Premium Quality Control</h3><p class="mt-2 text-sm text-slate-600">Each batch is processed with strict quality measures for consistent flavor, nutritional value, and hygiene standards.</p></article>
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Locally Sourced Ingredients</h3><p class="mt-2 text-sm text-slate-600">Chili is procured from multiple local farmers, ensuring freshness, sustainability, and strong community impact.</p></article>
                <article class="rounded-xl bg-white p-5 shadow-sm"><h3 class="font-semibold">Safe, Premium Packaging</h3><p class="mt-2 text-sm text-slate-600">Products are hygienically processed, properly stored, and attractively packaged for reliable consumer confidence.</p></article>
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
