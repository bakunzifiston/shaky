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
                <div class="max-w-3xl">
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
                </div>

                <p class="pointer-events-none absolute bottom-6 left-1/2 -translate-x-1/2 text-center text-[11px] font-medium uppercase tracking-[0.2em] text-white/55 sm:bottom-8">
                    <span class="sr-only">Background rotates through three photos.</span>
                    <span aria-hidden="true">· · ·</span>
                </p>
            </div>
        </section>

        {{-- Mission & vision --}}
        <section class="border-b border-slate-200/80 bg-gradient-to-b from-[#e8f4f5] via-[#f8fafc] to-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Purpose</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Mission &amp; vision</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">What we deliver today—and the standard we are building toward.</p>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:gap-8">
                    <article class="group relative overflow-hidden rounded-2xl border border-[#0b4e5b]/20 bg-gradient-to-br from-white via-white to-[#0b4e5b]/[0.08] p-8 shadow-md shadow-[#0b4e5b]/[0.06] ring-1 ring-[#0b4e5b]/10 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#0b4e5b]/10">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-[#0b4e5b]/10 blur-2xl transition duration-500 group-hover:bg-[#0b4e5b]/15" aria-hidden="true"></div>
                        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start">
                            <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#0b4e5b] text-white shadow-lg shadow-[#0b4e5b]/30">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.75.75 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.034 8.295a.75.75 0 00-1.06-1.06L10.5 14.44l-1.72-1.72a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-4.5z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-bold tracking-tight text-[#06343d]">Mission</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                    Provide high-quality, flavorful chili products that enhance culinary experiences while supporting local farmers and ensuring sustainable production.
                                </p>
                            </div>
                        </div>
                    </article>
                    <article class="group relative overflow-hidden rounded-2xl border border-[#c4a574]/40 bg-gradient-to-br from-white via-[#faf6f0] to-[#d1b89c]/25 p-8 shadow-md shadow-[#2f2418]/[0.04] ring-1 ring-[#d1b89c]/30 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#d1b89c]/20">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-[#d1b89c]/25 blur-2xl transition duration-500 group-hover:bg-[#d1b89c]/35" aria-hidden="true"></div>
                        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start">
                            <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#e8d4bc] to-[#d1b89c] text-[#2f2418] shadow-lg shadow-[#8a7359]/20 ring-1 ring-white/60">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 .75a8.25 8.25 0 018.25 8.25c0 3.142-.445 5.056-1.817 6.916a10.17 10.17 0 01-1.022 1.113 6.75 6.75 0 00-1.679 3.786 7.5 7.5 0 11-9.852 0 6.75 6.75 0 00-1.679-3.786 10.17 10.17 0 01-1.022-1.113C2.945 13.081 2.5 11.167 2.5 8A8.25 8.25 0 0112 .75zm2.25 12a.75.75 0 00-1.5 0v2.546a12.037 12.037 0 01-2.25.01V12.75a.75.75 0 00-1.5 0v2.272c-.853.084-1.7.22-2.5.407V18.75h15v-3.573c-.8-.188-1.647-.323-2.5-.407V12.75z" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-bold tracking-tight text-[#2f2418]">Vision</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-700">
                                    To become a leading chili processing brand in Rwanda and beyond, known for premium quality and unique flavors.
                                </p>
                            </div>
                        </div>
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
        <section class="border-y border-slate-200/70 bg-gradient-to-b from-white via-[#f7fbfc] to-white">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center lg:gap-16">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Why SHAKY</p>
                        <h2 class="mt-3 max-w-xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Quality, sourcing, and packaging you can stand behind</h2>
                        <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-600 sm:text-base">
                            Standardized recipes, rigorous hygiene, and partnerships with local farmers mean reliable flavor for households and retail shelves alike.
                        </p>

                        <ul class="mt-10 grid gap-4 sm:grid-cols-2">
                            <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/90 p-5 shadow-sm ring-1 ring-slate-900/[0.03] transition duration-200 hover:border-[#0b4e5b]/25 hover:shadow-md">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.415 0z" clip-rule="evenodd" /></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-900">Premium quality control</p>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Batch consistency and strict processing standards.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/90 p-5 shadow-sm ring-1 ring-slate-900/[0.03] transition duration-200 hover:border-[#c4a574]/40 hover:shadow-md">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#e8d4bc] to-[#d1b89c] text-[#2f2418] shadow-md shadow-[#8a7359]/15 ring-1 ring-white/50">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" /></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-900">Locally sourced chili</p>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Freshness and fair impact across the supply chain.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/90 p-5 shadow-sm ring-1 ring-slate-900/[0.03] transition duration-200 hover:border-[#c4a574]/40 hover:shadow-md">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#e8d4bc] to-[#d1b89c] text-[#2f2418] shadow-md shadow-[#8a7359]/15 ring-1 ring-white/50">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" clip-rule="evenodd" /></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-900">Neza product line</p>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Mild, spicy, and oil formats for every kitchen.</p>
                                </div>
                            </li>
                            <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/90 p-5 shadow-sm ring-1 ring-slate-900/[0.03] transition duration-200 hover:border-[#0b4e5b]/25 hover:shadow-md">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M1.503 4.75A1.75 1.75 0 013.253 3h13.494a1.75 1.75 0 011.75 1.75V15a1.75 1.75 0 01-1.75 1.75H3.253A1.75 1.75 0 011.503 15V4.75zM4.003 5.5a.25.25 0 00-.25.25v8.5c0 .138.112.25.25.25h12.494a.25.25 0 00.25-.25v-8.5a.25.25 0 00-.25-.25H4.003z" clip-rule="evenodd" /><path d="M5.503 7.25a.75.75 0 01.75-.75h7.494a.75.75 0 010 1.5H6.253a.75.75 0 01-.75-.75zm0 3a.75.75 0 01.75-.75h4.494a.75.75 0 010 1.5H6.253a.75.75 0 01-.75-.75z" /></svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-900">Safe, attractive packaging</p>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Hygiene and shelf presence built for trust.</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-10 flex flex-wrap gap-3">
                            <a href="{{ route('storefront.shop') }}" class="inline-flex rounded-lg bg-[#0b4e5b] px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[#0b4e5b]/20 transition hover:bg-[#083f49] active:scale-[0.98]">Shop now</a>
                            <a href="{{ route('storefront.contact') }}" class="inline-flex rounded-lg border border-slate-300/90 bg-white px-5 py-2.5 text-sm font-semibold text-slate-800 transition hover:border-[#0b4e5b]/35 hover:bg-[#f7fbfc] active:scale-[0.98]">Request wholesale info</a>
                        </div>
                    </div>
                    <figure class="overflow-hidden rounded-2xl border border-[#0b4e5b]/15 bg-[#0b4e5b]/[0.03] shadow-xl shadow-slate-900/10 ring-1 ring-[#0b4e5b]/10 transition duration-500 hover:shadow-2xl">
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
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    controls
                                    preload="auto"
                                    class="storefront-home-autoplay-video aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]"
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
                                        <video autoplay muted loop playsinline controls preload="auto" class="storefront-home-autoplay-video aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]">
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
                                        <video autoplay muted loop playsinline controls preload="auto" class="storefront-home-autoplay-video aspect-video w-full object-cover transition duration-300 group-hover:brightness-[1.03]">
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
                            var nodes = document.querySelectorAll('#storefront-home .storefront-home-autoplay-video');
                            if (!nodes.length) return;
                            function bind(el) {
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
                                } else {
                                    tryPlay();
                                }
                            }
                            nodes.forEach(bind);
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
