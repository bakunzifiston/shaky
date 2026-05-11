<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-900 antialiased">
    <div class="admin-shell">
        <aside id="adminSidebar" class="admin-sidebar">
            <div class="px-4 py-5 border-b border-white/10">
                <p class="text-xs uppercase tracking-[0.2em] text-teal-100/70">ERP</p>
                <h1 class="text-lg font-semibold">Admin Panel</h1>
            </div>

            <nav class="p-3 space-y-1">
                <x-admin.nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-admin.nav-link>
                <x-admin.nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    Users
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
                <x-admin.nav-link href="#">Reports</x-admin.nav-link>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="flex items-center gap-2">
                    <button id="sidebarToggle" type="button" class="admin-icon-button lg:hidden" aria-label="Toggle sidebar">
                        <span class="block h-0.5 w-5 bg-slate-700"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-700"></span>
                        <span class="mt-1 block h-0.5 w-5 bg-slate-700"></span>
                    </button>
                    <p class="text-sm text-slate-500">New Laravel admin foundation</p>
                </div>

                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="admin-icon-button">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
