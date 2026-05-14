<x-layouts.storefront title="About">
    <div id="storefront-about">
        {{-- Hero --}}
        <section class="relative overflow-hidden text-white">
            <div class="absolute inset-0">
                <img
                    src="{{ asset('images/storefront/about-team.png') }}"
                    alt=""
                    class="h-full w-full object-cover"
                    aria-hidden="true"
                >
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-[#0b4e5b]/90 via-[#0b4e5b]/80 to-[#06343d]/95"></div>
            <div class="relative mx-auto flex min-h-[min(52vh,22rem)] max-w-7xl flex-col justify-end px-4 pb-16 pt-20 sm:pb-20 lg:px-8 lg:pb-24 lg:pt-28">
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-[#FFD700]">Our story</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-bold leading-tight sm:text-5xl lg:text-[3.25rem]">
                    About SHAKY Ltd
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-white/90">
                    Based in Kamonyi, Rwanda, we specialize in chili production and processing—bringing premium sauces and infused oils from local farms to supermarkets and kitchens across the country.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="{{ route('storefront.shop') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#FFD700] px-5 py-3 text-sm font-semibold text-[#2f2418] shadow-sm transition hover:bg-[#e6c200]"
                    >
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" /></svg>
                        Shop our products
                    </a>
                    <a
                        href="{{ route('storefront.contact') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/35 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10"
                    >
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a1.99 1.99 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                        Contact us
                    </a>
                </div>
            </div>
        </section>

        {{-- Quick facts --}}
        <section class="border-b border-[#0b4e5b]/10 bg-gradient-to-b from-[#e8f4f5] via-[#f6fbfc] to-[#faf8f4]">
            <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8 lg:py-20">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">At a glance</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">SHAKY in brief</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">Milestones that frame who we are and how we show up for customers and partners.</p>
                </div>
                <div class="mt-10 grid gap-5 sm:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200/90 bg-white/95 p-6 shadow-sm ring-1 ring-slate-900/[0.03] transition hover:border-[#0b4e5b]/20 hover:shadow-md">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z" /></svg>
                        </span>
                        <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Founded</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">June 22, 2023</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Committed to Rwanda’s agri-food sector.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200/90 bg-white/95 p-6 shadow-sm ring-1 ring-slate-900/[0.03] transition hover:border-[#FFD700]/40 hover:shadow-md">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-[#fff4b8] to-[#FFD700] text-[#2f2418] shadow-md shadow-[#c9a227]/20 ring-1 ring-white/60">
                            <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" clip-rule="evenodd" /></svg>
                        </span>
                        <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">First launch</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">Neza Chill — Jan 9, 2024</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Mild chili sauce that started the line-up.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200/90 bg-white/95 p-6 shadow-sm ring-1 ring-slate-900/[0.03] transition hover:border-[#0b4e5b]/20 hover:shadow-md">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z" /></svg>
                        </span>
                        <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Product family</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">Three Neza variants</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">Mild, extra heat, and chili-infused oil.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- Narrative + imagery --}}
        <section class="border-b border-slate-200/80 bg-white">
            <div class="mx-auto max-w-7xl space-y-12 px-4 py-14 lg:space-y-16 lg:px-8 lg:py-20">
                <div class="mx-auto max-w-3xl text-center lg:max-w-4xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Our footprint</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">From Kamonyi to your table</h2>
                    <p class="mt-4 text-base leading-relaxed text-slate-600">
                        SHAKY Ltd operates in trade and processing, scaling from our first bottled sauce to a portfolio that balances everyday mild heat with bold spice options. We distribute through trusted retail partners including SIMBA, T2000, and Deluxe Supermarket—so consistent quality reaches both shelves and chefs.
                    </p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2 lg:items-start lg:gap-8">
                    <figure class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-[#fafafa] shadow-sm ring-1 ring-slate-900/[0.04]">
                        <img
                            src="{{ asset('images/storefront/about-team.png') }}"
                            alt="SHAKY Ltd production team presenting bottled chili products"
                            class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.02] sm:aspect-[16/10]"
                            loading="lazy"
                        >
                        <figcaption class="flex gap-3 border-t border-slate-100 px-5 py-4 text-sm text-slate-600">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#0b4e5b]/10 text-[#0b4e5b]" aria-hidden="true">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" /></svg>
                            </span>
                            <span>Team and products—how we bring Neza sauces from production to presentation.</span>
                        </figcaption>
                    </figure>
                    <figure class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-[#fafafa] shadow-sm ring-1 ring-slate-900/[0.04] lg:mt-10">
                        <img
                            src="{{ asset('images/storefront/about-pitching.png') }}"
                            alt="SHAKY Ltd representative presenting during a pitching day event"
                            class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.02] sm:aspect-[16/10]"
                            loading="lazy"
                        >
                        <figcaption class="flex gap-3 border-t border-slate-100 px-5 py-4 text-sm text-slate-600">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#FFD700]/25 text-[#5c4a00]" aria-hidden="true">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 10-2 0v5.09a1 1 0 00.298.707l2.828 2.829a1 1 0 101.415-1.415L11 10.586V6z" clip-rule="evenodd" /></svg>
                            </span>
                            <span>Outreach and pitching—sharing our story with partners and audiences.</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        {{-- Mission & vision --}}
        <section class="border-b border-[#0b4e5b]/10 bg-gradient-to-b from-[#f6fbfc] via-white to-[#fffef8]">
            <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8 lg:py-20">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Purpose</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Mission &amp; vision</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">What drives us today and where we aim to grow.</p>
                </div>
                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:gap-8">
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
                                    Provide high-quality, flavorful chili products while supporting local farmers and sustainable production.
                                </p>
                            </div>
                        </div>
                    </article>
                    <article class="group relative overflow-hidden rounded-2xl border border-[#FFD700]/35 bg-gradient-to-br from-white via-[#fffef8] to-[#FFD700]/20 p-8 shadow-md shadow-[#2f2418]/[0.04] ring-1 ring-[#FFD700]/25 transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#c9a227]/20">
                        <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-[#FFD700]/20 blur-2xl transition duration-500 group-hover:bg-[#FFD700]/30" aria-hidden="true"></div>
                        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-start">
                            <span class="inline-flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#fff4b8] to-[#FFD700] text-[#2f2418] shadow-lg shadow-[#c9a227]/20 ring-1 ring-white/60">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 .75a8.25 8.25 0 018.25 8.25c0 3.142-.445 5.056-1.817 6.916a10.17 10.17 0 01-1.022 1.113 6.75 6.75 0 00-1.679 3.786 7.5 7.5 0 11-9.852 0 6.75 6.75 0 00-1.679-3.786 10.17 10.17 0 01-1.022-1.113C2.945 13.081 2.5 11.167 2.5 8A8.25 8.25 0 0112 .75zm2.25 12a.75.75 0 00-1.5 0v2.546a12.037 12.037 0 01-2.25.01V12.75a.75.75 0 00-1.5 0v2.272c-.853.084-1.7.22-2.5.407V18.75h15v-3.573c-.8-.188-1.647-.323-2.5-.407V12.75z" />
                                </svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-bold tracking-tight text-[#2f2418]">Vision</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-700">
                                    Become a leading chili processing brand in Rwanda and beyond.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- Value proposition --}}
        <section class="border-b border-slate-200/80 bg-gradient-to-b from-[#fdf6ed] via-[#fef7ef] to-[#faf0e4]">
            <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8 lg:py-20">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#0b4e5b]">Why it matters</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">What sets us apart</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Disciplined processing, trusted sourcing, and packaging you can rely on—from first batch to supermarket shelf.
                    </p>
                </div>
                <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/95 p-5 shadow-sm ring-1 ring-slate-900/[0.02] transition hover:border-[#0b4e5b]/25 hover:shadow-md">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.415 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">Batch consistency</p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">Premium quality control across every batch.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/95 p-5 shadow-sm ring-1 ring-slate-900/[0.02] transition hover:border-[#FFD700]/40 hover:shadow-md">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#fff4b8] to-[#FFD700] text-[#2f2418] shadow-md shadow-[#c9a227]/20 ring-1 ring-white/50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" /></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">Local sourcing</p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">Chili from partner farmers for freshness and impact.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/95 p-5 shadow-sm ring-1 ring-slate-900/[0.02] transition hover:border-[#FFD700]/40 hover:shadow-md">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#fff4b8] to-[#FFD700] text-[#2f2418] shadow-md shadow-[#c9a227]/20 ring-1 ring-white/50">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" clip-rule="evenodd" /></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">Product range</p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">Mild, spicy, and oil formats for every kitchen.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white/95 p-5 shadow-sm ring-1 ring-slate-900/[0.02] transition hover:border-[#0b4e5b]/25 hover:shadow-md">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0b4e5b] text-white shadow-md shadow-[#0b4e5b]/20">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M1.503 4.75A1.75 1.75 0 013.253 3h13.494a1.75 1.75 0 011.75 1.75V15a1.75 1.75 0 01-1.75 1.75H3.253A1.75 1.75 0 011.503 15V4.75zM4.003 5.5a.25.25 0 00-.25.25v8.5c0 .138.112.25.25.25h12.494a.25.25 0 00.25-.25v-8.5a.25.25 0 00-.25-.25H4.003z" clip-rule="evenodd" /><path d="M5.503 7.25a.75.75 0 01.75-.75h7.494a.75.75 0 010 1.5H6.253a.75.75 0 01-.75-.75zm0 3a.75.75 0 01.75-.75h4.494a.75.75 0 010 1.5H6.253a.75.75 0 01-.75-.75z" /></svg>
                        </span>
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-900">Safe packaging</p>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600">Hygiene and shelf presence built for trust.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        {{-- CTA --}}
        <section class="border-t border-[#083f49] bg-[#0b4e5b] px-4 py-14 text-white lg:px-8 lg:py-16">
            <div class="mx-auto flex max-w-7xl flex-col items-center gap-8 text-center md:flex-row md:justify-between md:text-left">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-[#FFD700]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" clip-rule="evenodd" /></svg>
                        Neza range
                    </div>
                    <h2 class="mt-4 text-2xl font-bold sm:text-3xl">Taste the Neza difference</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-200 md:text-base">
                        Explore sauces and oil built for Rwanda’s palate—and bring SHAKY quality to your next meal or menu.
                    </p>
                </div>
                <div class="flex flex-wrap justify-center gap-3 md:justify-end">
                    <a
                        href="{{ route('storefront.shop') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#FFD700] px-5 py-3 text-sm font-semibold text-[#2f2418] shadow-sm transition hover:bg-[#e6c200]"
                    >
                        Shop now
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" /></svg>
                    </a>
                    <a
                        href="{{ route('storefront.contact') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/35 px-5 py-3 text-sm font-semibold transition hover:bg-white/10"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a1.99 1.99 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                        Get in touch
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.storefront>
