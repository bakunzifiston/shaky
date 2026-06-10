@php
    $formatRwf = fn (float $amount): string => number_format($amount, 0, '.', ',') . ' RWF';
    $items = $breakdown['items'];
    $total = (float) $breakdown['total'];
@endphp

<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-3">
        <div>
            <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
            <p class="text-sm text-slate-500">{{ $monthLabel }} {{ $year }}</p>
        </div>
        <x-admin.expense-type-badge :type="$type" />
    </div>
    <table class="min-w-full divide-y divide-slate-200 text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Item</th>
                <th class="px-4 py-3 text-right font-semibold text-slate-600">Amount (RWF)</th>
                <th class="px-4 py-3 text-right font-semibold text-slate-600">% of total</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($items as $row)
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $row['name'] }}</td>
                    <td class="px-4 py-3 text-right text-slate-900">{{ $formatRwf($row['amount']) }}</td>
                    <td class="px-4 py-3 text-right text-slate-600">{{ number_format($row['percent'], 1) }}%</td>
                    <td class="px-4 py-3">
                        <x-admin.expense-spend-badge :amount="$row['amount']" />
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-slate-50 font-semibold text-slate-900">
            <tr>
                <td class="px-4 py-3">Total</td>
                <td class="px-4 py-3 text-right">{{ $formatRwf($total) }}</td>
                <td class="px-4 py-3 text-right">{{ $total > 0 ? '100%' : '—' }}</td>
                <td class="px-4 py-3"></td>
            </tr>
        </tfoot>
    </table>
</div>
