<x-layouts.storefront title="About">
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
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:py-20 lg:px-8 lg:py-24">
            <p class="text-sm uppercase tracking-[0.2em] text-[#FFD700]">Our story</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-bold leading-tight sm:text-5xl lg:text-[3.25rem]">
                About SHAKY Ltd
            </h1>
            <p class="mt-5 max-w-2xl text-base leading-relaxed text-slate-100/90">
                Based in Kamonyi, Rwanda, we specialize in chili production and processing—bringing premium sauces and infused oils from local farms to supermarkets and kitchens across the country.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a
                    href="{{ route('storefront.shop') }}"
                    class="rounded-lg bg-[#FFD700] px-5 py-3 text-sm font-semibold text-[#2f2418] transition hover:bg-[#e6c200]"
                >
                    Shop our products
                </a>
                <a
                    href="{{ route('storefront.contact') }}"
                    class="rounded-lg border border-white/35 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/10"
                >
                    Contact us
                </a>
            </div>
        </div>
    </section>

    {{-- Quick facts --}}
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:grid-cols-3 lg:px-8">
            <div class="text-center sm:text-left">
                <p class="text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Founded</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">June 22, 2023</p>
                <p class="mt-1 text-sm text-slate-600">Committed to Rwanda’s agri-food sector</p>
            </div>
            <div class="text-center sm:text-left">
                <p class="text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">First launch</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">Neza Chill — Jan 9, 2024</p>
                <p class="mt-1 text-sm text-slate-600">Mild chili sauce that started the line-up</p>
            </div>
            <div class="text-center sm:text-left">
                <p class="text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Product family</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">Three Neza variants</p>
                <p class="mt-1 text-sm text-slate-600">Mild, extra heat, and chili-infused oil</p>
            </div>
        </div>
    </section>

    {{-- Narrative + imagery --}}
    <section class="bg-slate-50">
        <div class="mx-auto max-w-7xl space-y-12 px-4 py-14 lg:space-y-16 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-3xl text-center lg:max-w-4xl">
                <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">From Kamonyi to your table</h2>
                <p class="mt-4 text-base leading-relaxed text-slate-600">
                    SHAKY Ltd operates in trade and processing, scaling from our first bottled sauce to a portfolio that balances everyday mild heat with bold spice options. We distribute through trusted retail partners including SIMBA, T2000, and Deluxe Supermarket—so consistent quality reaches both shelves and chefs.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8 lg:items-start">
                <figure class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm ring-1 ring-slate-900/5">
                    <img
                        src="{{ asset('images/storefront/about-team.png') }}"
                        alt="SHAKY Ltd production team presenting bottled chili products"
                        class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.02] sm:aspect-[16/10]"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-slate-100 px-5 py-4 text-sm text-slate-600">
                        Team and products—how we bring Neza sauces from production to presentation.
                    </figcaption>
                </figure>
                <figure class="group overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm ring-1 ring-slate-900/5 lg:mt-12">
                    <img
                        src="{{ asset('images/storefront/about-pitching.png') }}"
                        alt="SHAKY Ltd representative presenting during a pitching day event"
                        class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-[1.02] sm:aspect-[16/10]"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-slate-100 px-5 py-4 text-sm text-slate-600">
                        Outreach and pitching—sharing our story with partners and audiences.
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    {{-- Mission & vision --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">Mission &amp; vision</h2>
                <p class="mt-3 text-sm text-slate-600">What drives us today and where we aim to grow.</p>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <article class="rounded-2xl border border-slate-200 bg-[#fafafa] p-8 shadow-sm">
                    <div class="inline-flex rounded-lg bg-[#0b4e5b]/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#0b4e5b]">Mission</div>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        Provide high-quality, flavorful chili products while supporting local farmers and sustainable production.
                    </p>
                </article>
                <article class="rounded-2xl border border-slate-200 bg-[#fafafa] p-8 shadow-sm">
                    <div class="inline-flex rounded-lg bg-[#FFD700]/30 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#2f2418]">Vision</div>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">
                        Become a leading chili processing brand in Rwanda and beyond.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- Value proposition (checklist, matches home rhythm) --}}
    <section class="border-y border-slate-200 bg-[#fef7ef]">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:px-8 lg:py-20">
            <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">What sets us apart</h2>
            <p class="mt-3 max-w-2xl text-sm text-slate-600">
                Our value proposition rests on disciplined processing, trusted sourcing, and packaging you can rely on—from first batch to supermarket shelf.
            </p>
            <ul class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <li class="flex gap-3 rounded-xl bg-white/80 p-5 shadow-sm ring-1 ring-slate-900/5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-teal-100 text-teal-700">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.415 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.415 0z" clip-rule="evenodd" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Batch consistency</p>
                        <p class="mt-1 text-sm text-slate-600">Premium quality control and strict measures across every batch.</p>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl bg-white/80 p-5 shadow-sm ring-1 ring-slate-900/5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M10 2a.75.75 0 01.75.75v.783c1.21.087 2.224.46 3.07 1.07.96.692 1.6 1.72 1.944 2.97a.75.75 0 01-1.447.398c-.26-.945-.724-1.675-1.374-2.144-.675-.487-1.552-.76-2.69-.826V6a.75.75 0 11-1.5 0v-.77c-1.07.11-1.916.45-2.558 1.012-.772.675-1.25 1.64-1.457 2.85a.75.75 0 01-1.478-.252c.25-1.47.862-2.73 1.95-3.68.95-.831 2.177-1.298 3.543-1.406V2.75A.75.75 0 0110 2z" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Local sourcing</p>
                        <p class="mt-1 text-sm text-slate-600">Chili from multiple farmers for freshness and sustainability.</p>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl bg-white/80 p-5 shadow-sm ring-1 ring-slate-900/5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path d="M10.868 2.884c.321-.772 1.443-.772 1.764 0l1.553 3.735a1 1 0 00.843.616l4.032.323c.833.067 1.17 1.108.536 1.654l-3.072 2.64a1 1 0 00-.323.997l.938 3.935c.194.815-.703 1.46-1.416 1.02l-3.455-2.11a1 1 0 00-1.043 0l-3.455 2.11c-.713.44-1.61-.205-1.416-1.02l.938-3.935a1 1 0 00-.323-.997l-3.072-2.64c-.634-.546-.297-1.587.536-1.654l4.032-.323a1 1 0 00.843-.616l1.553-3.735z" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Product range</p>
                        <p class="mt-1 text-sm text-slate-600">Mild, spicy, and oil formats for different tastes and occasions.</p>
                    </div>
                </li>
                <li class="flex gap-3 rounded-xl bg-white/80 p-5 shadow-sm ring-1 ring-slate-900/5">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-700">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.414 7.414a1 1 0 01-1.414 0L3.293 9.536a1 1 0 011.414-1.414l3.879 3.878 6.707-6.707a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Safe packaging</p>
                        <p class="mt-1 text-sm text-slate-600">Hygiene, storage, and presentation built for consumer confidence.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    {{-- CTA --}}
    <section class="border-t border-[#083f49] bg-[#0b4e5b] px-4 py-14 text-white lg:px-8 lg:py-16">
        <div class="mx-auto flex max-w-7xl flex-col items-center gap-8 text-center md:flex-row md:justify-between md:text-left">
            <div class="max-w-xl">
                <h2 class="text-2xl font-bold sm:text-3xl">Taste the Neza difference</h2>
                <p class="mt-3 text-sm text-slate-200 md:text-base">
                    Explore sauces and oil built for Rwanda’s palate—and bring SHAKY quality to your next meal or menu.
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-3 md:justify-end">
                <a
                    href="{{ route('storefront.shop') }}"
                    class="rounded-lg bg-[#FFD700] px-5 py-3 text-sm font-semibold text-[#2f2418] transition hover:bg-[#e6c200]"
                >
                    Shop now
                </a>
                <a
                    href="{{ route('storefront.contact') }}"
                    class="rounded-lg border border-white/35 px-5 py-3 text-sm font-semibold transition hover:bg-white/10"
                >
                    Get in touch
                </a>
            </div>
        </div>
    </section>
</x-layouts.storefront>
