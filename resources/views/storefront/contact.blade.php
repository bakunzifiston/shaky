<x-layouts.storefront title="Contact Us">
    <section class="mx-auto max-w-6xl px-4 py-12 lg:px-8">
        <h1 class="text-3xl font-bold">Contact Us</h1>
        <p class="mt-2 text-slate-600">Reach SHAKY Ltd for business inquiries, partnerships, and product information.</p>

        @if (session('status'))
            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <form action="{{ route('storefront.contact.submit') }}" method="POST" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                <h2 class="text-xl font-semibold">Send a Message</h2>
                <div class="mt-4 grid gap-3">
                    <input name="name" required placeholder="Your name" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <input name="email" type="email" required placeholder="Your email" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <input name="phone" placeholder="Phone number" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <input name="subject" placeholder="Subject" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <textarea name="message" rows="5" required placeholder="Your message" class="rounded-lg border border-slate-300 px-3 py-2 text-sm"></textarea>
                    <button class="rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white">Send Message</button>
                </div>
            </form>

            <div class="space-y-4">
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <h2 class="text-xl font-semibold">Company Details</h2>
                    <p class="mt-3 text-sm text-slate-600">SHAKY Ltd, Kamonyi, Rwanda</p>
                    <p class="mt-2 text-sm text-slate-600">Phone: +250 7XX XXX XXX</p>
                    <p class="mt-2 text-sm text-slate-600">Email: info@shakyltd.rw</p>
                    <p class="mt-2 text-sm text-slate-600">Business inquiries: business@shakyltd.rw</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <h2 class="text-xl font-semibold">Google Maps</h2>
                    <div class="mt-3 flex h-40 items-center justify-center rounded-lg bg-slate-100 text-sm text-slate-500">Kamonyi, Rwanda Map Placeholder</div>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <h2 class="text-xl font-semibold">Social Media</h2>
                    <p class="mt-3 text-sm text-slate-600">Facebook | Instagram | LinkedIn | YouTube</p>
                </article>
            </div>
        </div>
    </section>
</x-layouts.storefront>
