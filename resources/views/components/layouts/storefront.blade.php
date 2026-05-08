<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SHAKY Ltd' }} - {{ config('app.name', 'SHAKY Ltd') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="sticky top-0 z-[100] border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8">
                <a href="{{ route('storefront.home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/shaky-logo.png') }}" alt="SHAKY Ltd" class="h-10 w-10 rounded-lg object-cover">
                    <div>
                        <p class="text-sm font-semibold tracking-wide">SHAKY Ltd</p>
                        <p class="text-xs text-slate-500">Premium Chili Products</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-5 text-sm font-medium text-slate-700 md:flex">
                    <a href="{{ route('storefront.home') }}" class="hover:text-[#0b4e5b]">Home</a>
                    <a href="{{ route('storefront.about') }}" class="hover:text-[#0b4e5b]">About</a>
                    <a href="{{ route('storefront.shop') }}" class="hover:text-[#0b4e5b]">Shop</a>
                    <a href="{{ route('storefront.contact') }}" class="hover:text-[#0b4e5b]">Contact Us</a>
                    <a href="{{ route('storefront.cart') }}" class="hover:text-[#0b4e5b]">Cart</a>
                    <a href="{{ route('storefront.wishlist') }}" class="hover:text-[#0b4e5b]">Wishlist</a>
                </nav>

                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="relative z-[110] rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white hover:bg-[#083f49]"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('admin.login') }}"
                        class="relative z-[110] rounded-lg bg-[#0b4e5b] px-4 py-2 text-sm font-medium text-white hover:bg-[#083f49]"
                    >
                        Login
                    </a>
                @endauth
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="mt-16 border-t border-[#083f49] bg-[#0b4e5b] text-white">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 md:grid-cols-4 lg:px-8">
                <div>
                    <h3 class="text-base font-semibold">SHAKY Ltd</h3>
                    <p class="mt-3 text-sm text-slate-200">Kamonyi, Rwanda</p>
                    <p class="mt-2 text-sm text-slate-200">+250 7XX XXX XXX</p>
                    <p class="mt-2 text-sm text-slate-200">info@shakyltd.rw</p>
                </div>
                <div>
                    <h3 class="text-base font-semibold">Quick Links</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-200">
                        <li><a href="{{ route('storefront.home') }}" class="hover:text-[#d1b89c]">Home</a></li>
                        <li><a href="{{ route('storefront.about') }}" class="hover:text-[#d1b89c]">About</a></li>
                        <li><a href="{{ route('storefront.shop') }}" class="hover:text-[#d1b89c]">Shop</a></li>
                        <li><a href="{{ route('storefront.contact') }}" class="hover:text-[#d1b89c]">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-base font-semibold">Product Categories</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-200">
                        <li>Neza Chill (Mild Chili Sauce)</li>
                        <li>Neza Heat (Spicy Chili Sauce)</li>
                        <li>Neza Chill Oil (Chili-infused Oil)</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-base font-semibold">Newsletter</h3>
                    <form action="{{ route('storefront.contact.submit') }}" method="POST" class="mt-3 space-y-2">
                        @csrf
                        <input type="hidden" name="name" value="Newsletter Subscriber">
                        <input type="hidden" name="subject" value="Newsletter Subscription">
                        <input type="hidden" name="message" value="Please subscribe me to SHAKY Ltd newsletter updates.">
                        <input type="text" name="phone" placeholder="Phone (optional)" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <input type="email" name="email" required placeholder="Email address" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        <button class="w-full rounded-lg bg-[#0b4e5b] px-3 py-2 text-sm font-medium text-white hover:bg-[#083f49]">Subscribe</button>
                    </form>
                    <p class="mt-3 text-xs text-slate-200">Follow us: Facebook | Instagram | LinkedIn</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
