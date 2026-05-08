<x-layouts.storefront title="Checkout">
    <section class="mx-auto max-w-6xl px-4 py-12 lg:px-8">
        <h1 class="text-3xl font-bold">Checkout</h1>
        <p class="mt-2 text-sm text-slate-600">Complete your order request and our team will confirm delivery and payment details.</p>

        @if ($rows->isEmpty())
            <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                Your cart is empty. Add products before checkout.
            </div>
            <a href="{{ route('storefront.shop') }}" class="mt-4 inline-flex rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white">Go to Shop</a>
        @else
            <div class="mt-8 grid gap-8 lg:grid-cols-2">
                <form action="{{ route('storefront.checkout.place') }}" method="POST" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    @csrf
                    <h2 class="text-xl font-semibold">Customer Details</h2>
                    @if ($errors->has('checkout'))
                        <p class="mt-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800">{{ $errors->first('checkout') }}</p>
                    @endif
                    <div class="mt-4 grid gap-3">
                        <input name="name" value="{{ old('name') }}" required placeholder="Full name" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <input name="email" value="{{ old('email') }}" required type="email" placeholder="Email" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <input name="phone" value="{{ old('phone') }}" required placeholder="Phone number" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <input name="address" value="{{ old('address') }}" required placeholder="Delivery address" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <textarea name="notes" rows="4" placeholder="Order notes (optional)" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('notes') }}</textarea>
                        <button class="rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white hover:bg-[#083f49]">Submit Checkout</button>
                    </div>
                </form>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold">Order Summary</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($rows as $row)
                            <div class="flex items-center justify-between text-sm">
                                <p>{{ $row['product']->name }} x {{ $row['quantity'] }}</p>
                                <p class="font-medium">{{ number_format((float) $row['line_total'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 border-t border-slate-200 pt-4">
                        <p class="text-sm text-slate-600">Subtotal</p>
                        <p class="text-2xl font-semibold">{{ number_format((float) $subtotal, 2) }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layouts.storefront>
