<x-layouts.storefront title="Cart">
    <section class="mx-auto max-w-6xl px-4 py-12 lg:px-8">
        <h1 class="text-3xl font-bold">Cart</h1>
        <p class="mt-2 text-sm text-slate-600">Your selected items connected to ERP product availability.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Product</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Qty</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Unit Price</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Line Total</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($rows as $row)
                        <tr>
                            <td class="px-4 py-3 text-slate-800">{{ $row['product']->name }}</td>
                            <td class="px-4 py-3 text-slate-700">
                                <form method="POST" action="{{ route('storefront.cart.update', $row['product']->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" min="0" name="quantity" value="{{ $row['quantity'] }}" class="w-16 rounded-lg border border-slate-300 px-2 py-1 text-sm">
                                    <button class="rounded-lg border border-slate-300 px-2 py-1 text-xs text-slate-700">Update</button>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row['unit_price'], 2) }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format((float) $row['line_total'], 2) }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('storefront.cart.update', $row['product']->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="0">
                                    <button class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1 text-xs text-rose-700">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Your cart is empty.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 rounded-xl border border-slate-200 bg-white p-4 text-right">
            <p class="text-sm text-slate-600">Subtotal</p>
            <p class="text-2xl font-semibold">{{ number_format((float) $subtotal, 2) }}</p>
            @if ($rows->isNotEmpty())
                <a href="{{ route('storefront.checkout') }}" class="mt-3 inline-flex rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white hover:bg-[#083f49]">
                    Proceed to Checkout
                </a>
            @endif
        </div>
    </section>
</x-layouts.storefront>
