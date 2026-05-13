<x-layouts.storefront title="Your Cart">
    <section class="border-b border-slate-200/80 bg-[#f8fafc]">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:py-12 lg:px-8">
            <nav class="text-xs font-medium text-[#0b4e5b]" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-x-2 gap-y-1">
                    <li><a href="{{ route('storefront.home') }}" class="text-slate-600 transition hover:text-[#0b4e5b]">Home</a></li>
                    <li class="text-slate-400" aria-hidden="true">/</li>
                    <li><a href="{{ route('storefront.shop') }}" class="text-slate-600 transition hover:text-[#0b4e5b]">Shop</a></li>
                    <li class="text-slate-400" aria-hidden="true">/</li>
                    <li class="font-semibold text-slate-900" aria-current="page">Cart</li>
                </ol>
            </nav>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Your cart</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600 sm:text-base">
                Review quantities and line totals—stock reflects live ERP data. Continue shopping anytime or proceed when you’re ready.
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 lg:flex lg:gap-10 lg:px-8 lg:py-14">
        <div class="min-w-0 flex-1">
            @if (session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.872l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.061l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($rows->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-200 bg-white px-8 py-16 text-center shadow-sm ring-1 ring-slate-900/[0.03]">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#0b4e5b]/10 text-[#0b4e5b]" aria-hidden="true">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <p class="mt-6 text-lg font-semibold text-slate-900">Your cart is empty</p>
                    <p class="mt-2 text-sm text-slate-600">Add Neza sauces or chili oil from the shop—your selections will appear here.</p>
                    <a href="{{ route('storefront.shop') }}" class="mt-8 inline-flex items-center rounded-xl bg-[#0b4e5b] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#083f49] active:scale-[0.98]">
                        Browse products
                    </a>
                    <a href="{{ route('storefront.home') }}" class="mt-3 block text-center text-sm font-semibold text-[#0b4e5b] underline-offset-2 hover:underline">
                        Back to home
                    </a>
                </div>
            @else
                <ul class="space-y-4">
                    @foreach ($rows as $row)
                        @php
                            $product = $row['product'];
                            $qty = (int) $row['quantity'];
                            $unit = (float) $row['unit_price'];
                            $line = (float) $row['line_total'];
                            $available = max(0, (float) ($product->sellable_qty ?? 0));
                            $maxQty = $available > 0 ? max(1, (int) floor($available)) : PHP_INT_MAX;
                            $atCap = $available > 0 && $qty >= $maxQty;
                            $canDec = $qty > 1;
                        @endphp
                        <li class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm ring-1 ring-slate-900/[0.04] transition hover:shadow-md">
                            <div class="flex flex-col gap-4 p-4 sm:flex-row sm:items-start sm:gap-5 sm:p-5">
                                <a href="{{ route('storefront.product', $product->id) }}" class="relative shrink-0 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-200/80 transition hover:ring-[#0b4e5b]/25 sm:h-28 sm:w-28">
                                    @if ($product->image_path)
                                        <img
                                            src="{{ asset('storage/' . $product->image_path) }}"
                                            alt="{{ $product->name }}"
                                            width="224"
                                            height="224"
                                            class="h-32 w-full object-cover transition duration-300 hover:scale-[1.02] sm:h-28 sm:w-28"
                                        >
                                    @else
                                        <div class="flex h-32 w-full items-center justify-center text-xs text-slate-500 sm:h-28 sm:w-28">No image</div>
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <a href="{{ route('storefront.product', $product->id) }}" class="text-lg font-semibold text-slate-900 transition hover:text-[#0b4e5b]">{{ $product->name }}</a>
                                            @if (!empty($product->type))
                                                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500">{{ $product->type }}</p>
                                            @endif
                                        </div>
                                        <div class="text-left sm:text-right">
                                            <p class="text-sm text-slate-500">Line total</p>
                                            <p class="text-xl font-bold text-[#0b4e5b] tabular-nums">RWF {{ number_format($line, 2) }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Quantity</span>
                                            <div class="inline-flex items-stretch rounded-xl border border-slate-200 bg-slate-50/80 shadow-sm">
                                                <form method="POST" action="{{ route('storefront.cart.update', $product->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $qty - 1) }}">
                                                    <button
                                                        type="submit"
                                                        class="flex h-10 w-10 items-center justify-center rounded-l-xl border-r border-slate-200 text-slate-600 transition hover:bg-white hover:text-[#0b4e5b] disabled:cursor-not-allowed disabled:opacity-40"
                                                        aria-label="Decrease quantity"
                                                        @disabled(!$canDec)
                                                    >
                                                        −
                                                    </button>
                                                </form>
                                                <span class="flex min-w-[2.75rem] items-center justify-center px-2 text-sm font-semibold tabular-nums text-slate-900" aria-live="polite">{{ $qty }}</span>
                                                <form method="POST" action="{{ route('storefront.cart.update', $product->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $atCap ? $qty : $qty + 1 }}">
                                                    <button
                                                        type="submit"
                                                        class="flex h-10 w-10 items-center justify-center rounded-r-xl border-l border-slate-200 text-slate-600 transition hover:bg-white hover:text-[#0b4e5b] disabled:cursor-not-allowed disabled:opacity-40"
                                                        aria-label="Increase quantity"
                                                        @disabled($atCap)
                                                    >
                                                        +
                                                    </button>
                                                </form>
                                            </div>
                                            <form method="POST" action="{{ route('storefront.cart.update', $product->id) }}" class="flex flex-wrap items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <label class="sr-only" for="qty-{{ $product->id }}">Set quantity directly</label>
                                                <input
                                                    id="qty-{{ $product->id }}"
                                                    type="number"
                                                    name="quantity"
                                                    min="1"
                                                    @if ($available > 0) max="{{ $maxQty }}" @endif
                                                    value="{{ $qty }}"
                                                    class="w-16 rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-center text-sm font-medium tabular-nums focus:border-[#0b4e5b]/40 focus:outline-none focus:ring-2 focus:ring-[#0b4e5b]/20 sm:w-[4.25rem]"
                                                >
                                                <button type="submit" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-[#0b4e5b]/30 hover:bg-[#0b4e5b]/5">
                                                    Update
                                                </button>
                                            </form>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                                            <div class="text-sm text-slate-600 tabular-nums">
                                                @ RWF {{ number_format($unit, 2) }} <span class="text-slate-400">each</span>
                                            </div>
                                            <form method="POST" action="{{ route('storefront.cart.update', $product->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="0">
                                                <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-rose-700 underline decoration-rose-200 underline-offset-2 transition hover:bg-rose-50 hover:text-rose-800">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if ($available > 0)
                                        <p class="mt-3 text-xs text-slate-500">
                                            Available to ship now: <span class="font-medium text-emerald-800 tabular-nums">{{ number_format($available, 2) }}</span> units.
                                            @if ($qty > $available)
                                                <span class="ml-1 font-medium text-amber-800">Your quantity exceeds availability—checkout may prompt you to adjust.</span>
                                            @endif
                                        </p>
                                    @else
                                        <p class="mt-3 rounded-lg bg-amber-50 px-3 py-2 text-xs font-medium text-amber-900 ring-1 ring-amber-200/80">
                                            No sellable quantity on record—checkout will validate allocations.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50/80 px-4 py-3 text-sm">
                    <a href="{{ route('storefront.shop') }}" class="font-semibold text-[#0b4e5b] underline-offset-2 transition hover:underline">&larr; Continue shopping</a>
                    @if ($rows->count() > 0)
                        <p class="text-slate-600">{{ $rows->count() }} {{ \Illuminate\Support\Str::plural('item', $rows->count()) }} in cart</p>
                    @endif
                </div>
            @endif
        </div>

        @if ($rows->isNotEmpty())
            <aside class="mt-10 lg:mt-0 lg:w-[340px] lg:shrink-0">
                <div class="lg:sticky lg:top-[5.25rem]">
                    <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-lg shadow-slate-900/5 ring-1 ring-slate-900/[0.04]">
                        <div class="border-b border-slate-100 bg-gradient-to-br from-[#0b4e5b] to-[#06343d] px-5 py-5 text-white">
                            <p class="text-xs font-semibold uppercase tracking-[0.15em] text-[#d1b89c]/90">Summary</p>
                            <p class="mt-1 text-lg font-semibold">Order totals</p>
                        </div>
                        <div class="space-y-3 px-5 py-5">
                            @foreach ($rows as $row)
                                <div class="flex gap-3 text-sm">
                                    <span class="min-w-0 flex-1 truncate text-slate-700">{{ $row['product']->name }}</span>
                                    <span class="shrink-0 tabular-nums text-slate-600">× {{ (int) $row['quantity'] }}</span>
                                    <span class="shrink-0 font-medium tabular-nums text-slate-900">RWF {{ number_format((float) $row['line_total'], 2) }}</span>
                                </div>
                            @endforeach
                            <div class="my-4 border-t border-dashed border-slate-200"></div>
                            <div class="flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Subtotal (excl. delivery)</p>
                                    <p class="mt-1 text-xs text-slate-500">Taxes &amp; delivery confirmed at checkout</p>
                                </div>
                                <p class="text-2xl font-bold tracking-tight text-[#0b4e5b] tabular-nums">RWF {{ number_format((float) $subtotal, 2) }}</p>
                            </div>
                            <a
                                href="{{ route('storefront.checkout') }}"
                                class="mt-4 flex w-full items-center justify-center rounded-xl bg-[#d1b89c] px-5 py-3.5 text-sm font-semibold text-[#2f2418] shadow-sm transition hover:bg-[#c9ab8f] active:scale-[0.99]"
                            >
                                Proceed to checkout
                            </a>
                            <a href="{{ route('storefront.shop') }}" class="mt-3 block text-center text-sm font-medium text-[#0b4e5b] hover:underline">
                                Add more items
                            </a>
                        </div>
                        <div class="border-t border-slate-100 bg-slate-50/80 px-5 py-3 text-[11px] leading-relaxed text-slate-500">
                            Checkout opens a secure form for delivery details. Our team confirms payment before dispatch.
                        </div>
                    </div>
                </div>
            </aside>
        @endif
    </div>
</x-layouts.storefront>
