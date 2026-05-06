<x-layouts.admin title="Dashboard">
    <section class="space-y-6">
        <div class="grid gap-4 lg:grid-cols-[1.1fr_1fr]">
            <div>
                <h2 class="text-5xl font-semibold tracking-tight text-slate-900">Welcome, {{ auth()->user()?->name ?? 'User' }}</h2>
                <p class="mt-3 max-w-xl text-base text-slate-500">Create, track, and review operations with quick access to your ERP analytics.</p>
            </div>
            <form method="GET" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="mb-3 text-sm font-semibold text-slate-700">Quick Filters</p>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <select name="period" class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                        @foreach (['today'=>'Today','yesterday'=>'Yesterday','last_7_days'=>'Last 7 Days','last_30_days'=>'Last 30 Days','this_month'=>'This Month','last_month'=>'Last Month','this_year'=>'This Year','all_time'=>'All Time'] as $key => $label)
                            <option value="{{ $key }}" @selected($period === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-xl border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Apply</button>
                    <input name="start_date" type="date" value="{{ $start_date }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <input name="end_date" type="date" value="{{ $end_date }}" class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <x-admin.kpi-card label="Employees" :value="number_format($stats['employees'])" icon="users" tone="teal" />
            <x-admin.kpi-card label="Products" :value="number_format($stats['products'])" icon="box" tone="violet" />
            <x-admin.kpi-card label="Produced Quantity" :value="number_format($stats['produced_quantity'], 2) . ' units'" icon="factory" tone="teal" />
            <x-admin.kpi-card label="Inventory Stock" :value="number_format($stats['inventory_stock'], 2) . ' units'" icon="box" tone="slate" />
            <x-admin.kpi-card label="Stock Value (FIFO)" :value="number_format($stats['fifo_stock_value'], 0) . ' RWF'" icon="banknotes" tone="gold" />
            <x-admin.kpi-card label="Total Sales" :value="number_format($stats['total_sales_qty'], 2) . ' units'" icon="chart" tone="violet" />
            <x-admin.kpi-card label="Total Revenue" :value="number_format($stats['total_revenue'], 0) . ' RWF'" icon="banknotes" tone="emerald" />
            <x-admin.kpi-card label="Gross Profit" :value="number_format($stats['gross_profit'], 0) . ' RWF'" icon="chart" tone="emerald" />
            <x-admin.kpi-card label="Pending Payments" :value="number_format($stats['pending_payments'], 0) . ' RWF'" icon="clock" tone="rose" />
            <x-admin.kpi-card label="Supplier Balance" :value="number_format($stats['supplier_balance'], 0) . ' RWF'" icon="banknotes" tone="gold" />
        </div>

        @if (count($production_by_product))
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800">Production by Product</h3>
                <div class="mt-3 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($production_by_product as $item)
                        <x-admin.kpi-card :label="'Produced: ' . $item['label']" :value="number_format($item['value'], 2) . ' units'" icon="factory" tone="teal" />
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800">Monthly Production Quantity</h3>
                @php($maxProd = max(1, ...$monthly_production))
                <div class="mt-4 flex h-48 items-end gap-2">
                    @foreach ($monthly_production as $i => $value)
                        <div class="flex-1">
                            <div class="w-full rounded-t bg-[#0b4e5b]" style="height: {{ ($value / $maxProd) * 100 }}%"></div>
                            <p class="mt-1 text-center text-[10px] text-slate-500">{{ ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][$i] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800">Monthly Sales Revenue</h3>
                @php($maxSales = max(1, ...$monthly_sales_revenue))
                <div class="mt-4 flex h-48 items-end gap-2">
                    @foreach ($monthly_sales_revenue as $i => $value)
                        <div class="flex-1">
                            <div class="w-full rounded-t bg-[#d1b89c]" style="height: {{ ($value / $maxSales) * 100 }}%"></div>
                            <p class="mt-1 text-center text-[10px] text-slate-500">{{ ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][$i] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.admin>
