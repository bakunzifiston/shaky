<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
</head>
<body class="h-full text-slate-900 antialiased">
    <div class="admin-shell">
        <div class="admin-frame">
        <aside id="adminSidebar" class="admin-sidebar">
            <div class="px-4 py-5 border-b border-white/10">
                <img src="{{ asset('images/shaky-logo.png') }}" alt="Shaky LTD" class="mb-3 h-20 w-20 rounded-xl object-cover ring-1 ring-white/20">
                <p class="admin-brand-badge">Shaky LTD</p>
                <h1 class="mt-3 text-lg font-semibold">Admin Panel</h1>
            </div>

            <nav class="p-3 space-y-2">
                @php($coreOpen = request()->routeIs('admin.dashboard') || request()->routeIs('admin.users.*') || request()->routeIs('admin.employees.*') || request()->routeIs('admin.products.*') || request()->routeIs('admin.inventory-records.*') || request()->routeIs('admin.productions.*') || request()->routeIs('admin.sales.*') || request()->routeIs('admin.reports.*') || request()->routeIs('admin.contact-submissions.*'))
                <details class="admin-nav-group" @if($coreOpen) open @endif>
                    <summary class="admin-nav-group-summary">
                        <span>Core ERP</span>
                        <span class="admin-nav-group-chevron">▾</span>
                    </summary>
                    <div class="mt-1 space-y-1">
                        <x-admin.nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                            Employees
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            Products
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.inventory-records.index')" :active="request()->routeIs('admin.inventory-records.*')">
                            Inventory
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.productions.index')" :active="request()->routeIs('admin.productions.*')">
                            Production
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.*')">
                            Sales
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            Reports
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            Users
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.contact-submissions.index')" :active="request()->routeIs('admin.contact-submissions.*')">
                            Contact Messages
                        </x-admin.nav-link>
                    </div>
                </details>

                @php($ecommerceOpen = request()->routeIs('admin.ecommerce.*'))
                <details class="admin-nav-group" @if($ecommerceOpen) open @endif>
                    <summary class="admin-nav-group-summary">
                        <span>E-Commerce</span>
                        <span class="admin-nav-group-chevron">▾</span>
                    </summary>
                    <div class="mt-1 space-y-1">
                        <x-admin.nav-link :href="route('admin.ecommerce.catalog')" :active="request()->routeIs('admin.ecommerce.catalog')">
                            Catalog
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.ecommerce.customers')" :active="request()->routeIs('admin.ecommerce.customers')">
                            Customers
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.ecommerce.sales')" :active="request()->routeIs('admin.ecommerce.sales')">
                            Sales
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.ecommerce.fulfillment')" :active="request()->routeIs('admin.ecommerce.fulfillment')">
                            Fulfillment
                        </x-admin.nav-link>
                        <x-admin.nav-link :href="route('admin.ecommerce.analytics')" :active="request()->routeIs('admin.ecommerce.analytics')">
                            Analytics
                        </x-admin.nav-link>
                    </div>
                </details>
            </nav>

            <div class="mt-6 rounded-2xl border border-white/15 bg-white/8 p-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/shaky-logo.png') }}" alt="Business Profile" class="h-11 w-11 rounded-xl object-cover ring-1 ring-white/20">
                    <div>
                        <p class="text-xs text-slate-200/70">Business Profile</p>
                        <p class="text-sm font-semibold text-white">Shaky LTD</p>
                    </div>
                </div>

                @if (auth()->check() && auth()->user())
                    <a
                        href="{{ route('admin.users.edit', auth()->user()) }}"
                        class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-white/20 bg-white/10 px-3 py-2 text-xs font-medium text-white transition hover:bg-white/20"
                    >
                        Edit Profile
                    </a>
                @endif
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="flex items-center gap-2">
                    <button id="sidebarToggle" type="button" class="admin-icon-button lg:hidden" aria-label="Toggle sidebar">
                        <span class="block h-0.5 w-5 bg-slate-700"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-700"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-700"></span>
                    </button>
                    <p class="text-sm text-slate-500">Overview</p>
                </div>

                <div class="flex items-center gap-3">
                    <button id="themeToggle" type="button" class="admin-icon-button" aria-label="Toggle theme">Theme</button>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="admin-icon-button">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-0">
                <div class="admin-canvas">
                    {{ $slot }}
                </div>
            </main>
        </div>
        </div>
    </div>
</body>
</html>
