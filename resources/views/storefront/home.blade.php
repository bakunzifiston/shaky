<x-layouts.storefront title="Home">
    <div id="storefront-home">
        <style>
            #storefront-home .hero-slide {
                animation: storefrontHeroFade 15s infinite;
                opacity: 0;
                will-change: opacity;
            }

            #storefront-home .hero-slide:nth-child(1) {
                animation-delay: 0s;
            }

            #storefront-home .hero-slide:nth-child(2) {
                animation-delay: 5s;
            }

            #storefront-home .hero-slide:nth-child(3) {
                animation-delay: 10s;
            }

            @keyframes storefrontHeroFade {
                0%,
                28% {
                    opacity: 1;
                }
                33%,
                100% {
                    opacity: 0;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #storefront-home .hero-slide {
                    animation: none !important;
                    opacity: 0;
                }
                #storefront-home .hero-slide:nth-child(1) {
                    opacity: 1;
                }
            }
        </style>

        {{-- Hero --}}
        <section class="relative overflow-hidden text-white">
            <div class="absolute inset-0">
                <img
                    src="{{ asset('images/storefront/team.png') }}"
                    alt=""
                    width="1920"
                    height="1080"
                    fetchpriority="high"
                    decoding="async"
                    class="hero-slide pointer-events-none absolute inset-0 h-full w-full object-cover"
                    aria-hidden="true"
                >
                <img
                    src="{{ asset('images/storefront/award.png') }}"
                    alt=""
                    width="1920"
                    height="1080"
                    loading="lazy"
                    decoding="async"
                    class="hero-slide pointer-events-none absolute inset-0 h-full w-full object-cover"
                    aria-hidden="true"
                >
                <img
                    src="{{ asset('images/storefront/pitching.png') }}"
                    alt=""
                    width="1920"
                    height="1080"
                    loading="lazy"
                    decoding="async"
                    class="hero-slide pointer-events-none absolute inset-0 h-full w-full object-cover"
                    aria-hidden="true"
                >
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-[#0b4e5b]/88 via-[#0b4e5b]/78 to-[#06343d]/92"></div>

            <div class="relative mx-auto flex min-h-[min(88vh,44rem)] max-w-7xl flex-col justify-center px-4 py-20 sm:py-24 lg:px-8 lg:py-28">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-12 lg:items-center">
                    <div class="lg:col-span-7">
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-[#d1b89c]">Premium chili brand · Kamonyi, Rwanda</p>
                        <h1 class="mt-4 text-4xl font-bold leading-[1.1] tracking-tight sm:text-5xl lg:text-[3.25rem]">
                            Flavor you can trust, from farm to bottle
                        </h1>
                        <p class="mt-5 max-w-xl text-base leading-relaxed text-white/90 sm:text-lg">
                            SHAKY Ltd produces Neza sauces and chili-infused oil with strict quality control, local sourcing, and packaging built for retail confidence—so every meal gets consistent heat and depth.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a
                                href="{{ route('storefront.shop') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-[#d1b89c] px-6 py-3 text-sm font-semibold text-[#2f2418] shadow-sm transition duration-200 hover:bg-[#c9ab8f] hover:shadow-md active:scale-[0.98]"
                            >
                                Shop Neza range
                            </a>
                            <a
                                href="{{ route('storefront.about') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-white/35 bg-white/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition duration-200 hover:border-white/50 hover:bg-white/10 active:scale-[0.98]"
                            >
                                Our story
                            </a>
                            <a
                                href="{{ route('storefront.contact') }}"
                                class="inline-flex items-center justify-center rounded-lg px-6 py-3 text-sm font-semibold text-white/95 underline decoration-white/40 underline-offset-4 transition hover:decoration-white"
                            >
                                Partner with us
                            </a>
                        </div>
                        <dl class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 sm:gap-6">
                            <div class="rounded-xl border border-white/15 bg-white/5 px-4 py-3 backdrop-blur-sm transition hover:border-white/25">
                                <dt class="text-xs font-medium uppercase tracking-wide text-[#d1b89c]/90">Founded</dt>
                                <dd class="mt-1 text-sm font-semibold">June 2023</dd>
                            </div>
                            <div class="rounded-xl border border-white/15 bg-white/5 px-4 py-3 backdrop-blur-sm transition hover:border-white/25">
                                <dt class="text-xs font-medium uppercase tracking-wide text-[#d1b89c]/90">First launch</dt>
                                <dd class="mt-1 text-sm font-semibold">Neza Chill · Jan 2024</dd>
                            </div>
                            <div class="col-span-2 rounded-xl border border-white/15 bg-white/5 px-4 py-3 backdrop-blur-sm transition hover:border-white/25 sm:col-span-1">
                                <dt class="text-xs font-medium uppercase tracking-wide text-[#d1b89c]/90">Retail partners</dt>
                                <dd class="mt-1 text-sm font-semibold">SIMBA · T2000 · Deluxe</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="rounded-2xl border border-white/20 bg-white/10 p-6 shadow-lg ring-1 ring-white/10 backdrop-blur-md transition duration-300 hover:border-white/30 hover:bg-white/[0.12]">
                            <div class="flex items-center justify-between gap-2">
                                <h2 class="text-lg font-semibold">Featured offers</h2>
                                <span class="rounded-full bg-[#d1b89c]/25 px-2.5 py-0.5 text-xs font-medium text-[#f5eadc]">Live</span>
                            </div>
                            <div class="mt-5 space-y-3">
                                @foreach ($promotions as $promo)
                                    <article class="rounded-xl border border-white/10 bg-white/5 p-4 transition duration-200 hover:border-white/20 hover:bg-white/10">
                                        <h3 class="font-semibold leading-snug">{{ $promo['title'] }}</h3>
                                        <p class="mt-1.5 text-sm leading-relaxed text-white/85">{{ $promo['body'] }}</p>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <p class="pointer-events-none absolute bottom-6 left-1/2 -translate-x-1/2 text-center text-[11px] font-medium uppercase tracking-[0.2em] text-white/55 sm:bottom-8">
                    <span class="sr-only">Background rotates through three photos.</span>
                    <span aria-hidden="true">· · ·</span>
                </p>
            </div>
        </section>

        {{-- Mission & vision --}}
        <section class="border-b border-slate-200/80 bg-[#f8fafc]">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Purpose</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Mission &amp; vision</h2>
                    <p class="mt-3 text-sm text-slate-600">What we deliver today—and the standard we are building toward.</p>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    <article class="group rounded-2xl border border-slate-200/90 bg-white p-8 shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="inline-flex rounded-lg bg-[#0b4e5b]/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Mission</div>
                        <p class="mt-4 text-sm leading-relaxed text-slate-600">
                            Provide high-quality, flavorful chili products that enhance culinary experiences while supporting local farmers and ensuring sustainable production.
                        </p>
                    </article>
                    <article class="group rounded-2xl border border-slate-200/90 bg-white p-8 shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="inline-flex rounded-lg bg-[#d1b89c]/35 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#2f2418]">Vision</div>
                        <p class="mt-4 text-sm leading-relaxed text-slate-600">
                            To become a leading chili processing brand in Rwanda and beyond, known for premium quality and unique flavors.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        {{-- Categories --}}
        <section class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-20">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Browse</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Product categories</h2>
                    </div>
                    <a href="{{ route('storefront.shop') }}" class="text-sm font-semibold text-[#0b4e5b] transition hover:text-[#083f49]">View all products →</a>
                </div>
                <div class="mt-10 flex flex-wrap gap-2.5">
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('storefront.shop', ['category' => $category]) }}"
                            class="rounded-full border border-slate-200 bg-slate-50 px-5 py-2.5 text-sm font-medium text-slate-800 transition duration-200 hover:border-[#0b4e5b]/30 hover:bg-[#0b4e5b]/5 hover:text-[#0b4e5b] active:scale-[0.98]"
                        >
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Best sellers --}}
        <section class="border-y border-slate-200/80 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Customer favorites</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Best sellers</h2>
                    </div>
                    <a href="{{ route('storefront.shop') }}" class="text-sm font-semibold text-[#0b4e5b] transition hover:text-[#083f49]">Shop full catalog →</a>
                </div>
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($bestSellers as $best)
                        <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <a href="{{ route('storefront.product', $best->id) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                @if ($best->image_path)
                                    <img
                                        src="{{ asset('storage/' . $best->image_path) }}"
                                        alt="{{ $best->name }}"
                                        width="600"
                                        height="750"
                                        loading="lazy"
                                        decoding="async"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-xs text-slate-500">No image</div>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="font-semibold text-slate-900">{{ $best->name }}</h3>
                                <p class="mt-2 text-sm font-medium text-[#0b4e5b]">RWF {{ number_format((float) $best->price, 2) }}</p>
                                <a href="{{ route('storefront.product', $best->id) }}" class="mt-4 inline-flex text-sm font-semibold text-[#0b4e5b] transition hover:text-[#083f49]">View product</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Value proposition + image --}}
        <section class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center lg:gap-16">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Why SHAKY</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Quality, sourcing, and packaging you can stand behind</h2>
                        <p class="mt-4 text-sm leading-relaxed text-slate-600 sm:text-base">
                            Standardized recipes, rigorous hygiene, and partnerships with local farmers mean reliable flavor for households and retail shelves alike.
                        </p>
                        <ul class="mt-8 space-y-4 text-sm text-slate-700">
                            <li class="flex gap-3">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-teal-100 text-teal-700">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.415 0z" clip-rule="evenodd" /></svg>
                                </span>
                                <span><strong class="text-slate-900">Premium quality control</strong> — batch consistency and strict processing standards.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M10 2a.75.75 0 01.75.75v.783c1.21.087 2.224.46 3.07 1.07.96.692 1.6 1.72 1.944 2.97a.75.75 0 01-1.447.398c-.26-.945-.724-1.675-1.374-2.144-.675-.487-1.552-.76-2.69-.826V6a.75.75 0 11-1.5 0v-.77c-1.07.11-1.916.45-2.558 1.012-.772.675-1.25 1.64-1.457 2.85a.75.75 0 01-1.478-.252c.25-1.47.862-2.73 1.95-3.68.95-.831 2.177-1.298 3.543-1.406V2.75A.75.75 0 0110 2z" /></svg>
                                </span>
                                <span><strong class="text-slate-900">Locally sourced chili</strong> — freshness and fair impact across the supply chain.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" /></svg>
                                </span>
                                <span><strong class="text-slate-900">Neza product line</strong> — mild, spicy, and oil formats for every kitchen.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-700">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.414 7.414a1 1 0 01-1.414 0L3.293 9.536a1 1 0 011.414-1.414l3.879 3.878 6.707-6.707a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                </span>
                                <span><strong class="text-slate-900">Safe, attractive packaging</strong> — hygiene and shelf presence built for trust.</span>
                            </li>
                        </ul>
                        <div class="mt-10 flex flex-wrap gap-3">
                            <a href="{{ route('storefront.shop') }}" class="inline-flex rounded-lg bg-[#0b4e5b] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#083f49] active:scale-[0.98]">Shop now</a>
                            <a href="{{ route('storefront.contact') }}" class="inline-flex rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-800 transition hover:border-[#0b4e5b]/40 hover:bg-slate-50 active:scale-[0.98]">Request wholesale info</a>
                        </div>
                    </div>
                    <figure class="overflow-hidden rounded-2xl border border-slate-200/90 shadow-lg ring-1 ring-slate-900/[0.06] transition duration-500 hover:shadow-xl">
                        <img
                            src="{{ asset('images/storefront/team.png') }}"
                            alt="SHAKY Ltd team with chili products"
                            width="960"
                            height="720"
                            loading="lazy"
                            decoding="async"
                            class="aspect-[4/3] h-full w-full object-cover transition duration-700 hover:scale-[1.02]"
                        >
                    </figure>
                </div>
            </div>
        </section>

        {{-- Videos --}}
        <section class="border-t border-slate-200/80 bg-[#f8fafc]">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Behind the bottle</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Short videos</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">Production highlights, events, and product moments from SHAKY Ltd.</p>
                </div>
                @if ($videos->isEmpty())
                    <div class="mt-10 rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-sm text-slate-500">
                        Videos will appear here after upload from Admin → E-Commerce → Catalog → Videos.
                    </div>
                @else
                    @php
                        $featuredVideo = $videos->first();
                        $sideVideos = $videos->skip(1)->take(2);
                        $extraVideos = $videos->skip(3);
                    @endphp

                    <div class="mt-12 grid gap-6 lg:grid-cols-3">
                        <article class="group overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-4 shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:shadow-lg lg:col-span-2">
                            <div class="overflow-hidden rounded-xl bg-slate-900">
                                <video
                                    id="storefront-home-featured-video"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    controls
                                    preload="auto"
                                    class="aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]"
                                >
                                    <source src="{{ asset('storage/' . $featuredVideo->video_path) }}">
                                    Your browser does not support HTML video.
                                </video>
                            </div>
                            <h3 class="mt-4 text-sm font-semibold text-slate-900">{{ $featuredVideo->title }}</h3>
                        </article>

                        <div class="space-y-6">
                            @foreach ($sideVideos as $video)
                                <article class="group overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-4 shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:shadow-lg">
                                    <div class="overflow-hidden rounded-xl bg-slate-900">
                                        <video muted loop playsinline controls preload="none" class="aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]">
                                            <source src="{{ asset('storage/' . $video->video_path) }}">
                                            Your browser does not support HTML video.
                                        </video>
                                    </div>
                                    <h3 class="mt-4 text-sm font-semibold text-slate-900">{{ $video->title }}</h3>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    @if ($extraVideos->isNotEmpty())
                        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($extraVideos as $video)
                                <article class="group overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-4 shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:shadow-lg">
                                    <div class="overflow-hidden rounded-xl bg-slate-900">
                                        <video muted loop playsinline controls preload="none" class="aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]">
                                            <source src="{{ asset('storage/' . $video->video_path) }}">
                                            Your browser does not support HTML video.
                                        </video>
                                    </div>
                                    <h3 class="mt-4 text-sm font-semibold text-slate-900">{{ $video->title }}</h3>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    <script>
                        (function () {
                            var el = document.getElementById('storefront-home-featured-video');
                            if (!el) return;
                            function tryPlay() {
                                var p = el.play();
                                if (p && typeof p.catch === 'function') p.catch(function () {});
                            }
                            if (el.readyState >= 2) tryPlay();
                            else el.addEventListener('canplay', tryPlay, { once: true });
                            if ('IntersectionObserver' in window) {
                                var io = new IntersectionObserver(function (entries) {
                                    entries.forEach(function (e) {
                                        if (e.isIntersecting) tryPlay();
                                    });
                                }, { threshold: 0.2 });
                                io.observe(el);
                            }
                        })();
                    </script>
                @endif
            </div>
        </section>

        {{-- Featured products --}}
        <section class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Spotlight</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Featured products</h2>
                    </div>
                    <a href="{{ route('storefront.shop') }}" class="text-sm font-semibold text-[#0b4e5b] transition hover:text-[#083f49]">See everything →</a>
                </div>
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm ring-1 ring-slate-900/[0.04] transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <a href="{{ route('storefront.product', $product->id) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-100">
                                @if ($product->image_path)
                                    <img
                                        src="{{ asset('storage/' . $product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        width="600"
                                        height="750"
                                        loading="lazy"
                                        decoding="async"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm text-slate-500">No image</div>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-5">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                                <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $product->description ?: 'Premium SHAKY chili product.' }}</p>
                                <p class="mt-3 text-sm font-medium text-[#0b4e5b]">RWF {{ number_format((float) $product->price, 2) }}</p>
                                <p class="mt-1 text-xs text-slate-500">In stock: {{ number_format((float) $product->sellable_qty, 2) }}</p>
                                <a href="{{ route('storefront.product', $product->id) }}" class="mt-4 inline-flex text-sm font-semibold text-[#0b4e5b] transition hover:text-[#083f49]">View details</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Testimonials --}}
        <section class="border-y border-slate-200/80 bg-[#fef7ef]">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Social proof</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">What people say</h2>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    <figure class="flex h-full flex-col rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <blockquote class="flex-1 text-sm leading-relaxed text-slate-600">“Neza Chill is balanced and flavorful. Perfect for family meals.”</blockquote>
                        <figcaption class="mt-5 text-sm font-semibold text-slate-900">Retail customer</figcaption>
                    </figure>
                    <figure class="flex h-full flex-col rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <blockquote class="flex-1 text-sm leading-relaxed text-slate-600">“Reliable supply and premium packaging quality for shelves.”</blockquote>
                        <figcaption class="mt-5 text-sm font-semibold text-slate-900">Supermarket manager</figcaption>
                    </figure>
                    <figure class="flex h-full flex-col rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <blockquote class="flex-1 text-sm leading-relaxed text-slate-600">“SHAKY Ltd creates meaningful market opportunities for farmers.”</blockquote>
                        <figcaption class="mt-5 text-sm font-semibold text-slate-900">Farmer partner</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        {{-- Partners --}}
        <section class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-20">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Trusted presence</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Partner supermarkets</h2>
                    </div>
                </div>
                <div class="mt-10 flex flex-wrap gap-3">
                    @foreach ($partners as $partner)
                        <span class="rounded-xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-sm font-medium text-slate-800 transition duration-200 hover:border-[#0b4e5b]/25 hover:bg-[#0b4e5b]/[0.04]">{{ $partner }}</span>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Closing CTA --}}
        <section class="border-t border-[#083f49] bg-[#0b4e5b] px-4 py-16 text-white lg:px-8 lg:py-20">
            <div class="mx-auto flex max-w-7xl flex-col items-start gap-8 md:flex-row md:items-center md:justify-between">
                <div class="max-w-xl">
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Ready to stock or cook with Neza?</h2>
                    <p class="mt-4 text-sm leading-relaxed text-slate-200 sm:text-base">
                        Order online for home or reach out for retail and partnership questions—we respond quickly.
                    </p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:flex-wrap">
                    <a href="{{ route('storefront.shop') }}" class="inline-flex items-center justify-center rounded-lg bg-[#d1b89c] px-6 py-3 text-sm font-semibold text-[#2f2418] shadow-sm transition hover:bg-[#c9ab8f] active:scale-[0.98]">Shop now</a>
                    <a href="{{ route('storefront.contact') }}" class="inline-flex items-center justify-center rounded-lg border border-white/35 px-6 py-3 text-sm font-semibold transition hover:bg-white/10 active:scale-[0.98]">Contact us</a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.storefront>
