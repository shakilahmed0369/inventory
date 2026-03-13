<x-admin-layout>
    <x-slot name="heading">Financial Report</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Reports</span>
    </x-slot>

    {{-- Date-range filter --}}
    <form method="GET" action="{{ route('reports.index') }}" class="mb-6">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <x-admin.label for="from" value="From" />
                <x-admin.input id="from" name="from" type="date" :value="$from" class="mt-1" />
            </div>
            <div>
                <x-admin.label for="to" value="To" />
                <x-admin.input id="to" name="to" type="date" :value="$to" class="mt-1" />
            </div>
            <x-admin.button type="submit">Apply Filter</x-admin.button>
            @if ($from || $to)
                <a href="{{ route('reports.index') }}"
                   class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Summary cards --}}
    <div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7">
        @php
            $cards = [
                ['label' => 'Sales',    'value' => number_format($totals->total_sales),                         'color' => 'text-zinc-900', 'icon' => 'orders.svg'],
                ['label' => 'Gross',    'value' => '৳ ' . number_format($totals->total_gross, 2),               'color' => 'text-zinc-900', 'icon' => 'revenue.svg'],
                ['label' => 'Discount', 'value' => '৳ ' . number_format($totals->total_discount, 2),            'color' => 'text-amber-600', 'icon' => 'trending-up.svg'],
                ['label' => 'VAT',      'value' => '৳ ' . number_format($totals->total_vat, 2),                 'color' => 'text-blue-600',  'icon' => 'circle-info.svg'],
                ['label' => 'Net',      'value' => '৳ ' . number_format($totals->total_net, 2),                 'color' => 'text-zinc-900', 'icon' => 'activity.svg'],
                ['label' => 'Collected','value' => '৳ ' . number_format($totals->total_paid, 2),                'color' => 'text-emerald-600','icon' => 'credit-card.svg'],
                ['label' => 'Due',      'value' => '৳ ' . number_format($totals->total_due, 2),                 'color' => 'text-red-600',   'icon' => 'warning.svg'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-lg border border-zinc-200 bg-white p-4">
                <div class="mb-2 flex items-center gap-2">
                    <img src="{{ asset('assets/icons/' . $card['icon']) }}"
                         class="size-4 {{ $card['color'] }} injectable" alt="">
                    <span class="text-xs font-medium text-zinc-500">{{ $card['label'] }}</span>
                </div>
                <p class="text-lg font-semibold {{ $card['color'] }}">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Sales table --}}
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">Sale Transactions</h2>
            <p class="mt-0.5 text-sm text-zinc-500">{{ $sales->total() }} records{{ ($from || $to) ? ' in selected range' : '' }}</p>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Date</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Customer</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Gross (৳)</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Discount (৳)</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 lg:table-cell">VAT (৳)</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Net (৳)</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Paid (৳)</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Due (৳)</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3 text-zinc-500">{{ $sale->sale_date->format('M d, Y') }}</td>
                            <td class="px-5 py-3 font-medium text-zinc-900">{{ $sale->customer?->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-right text-zinc-600">{{ number_format($sale->gross_amount, 2) }}</td>
                            <td class="hidden px-5 py-3 text-right text-amber-600 md:table-cell">
                                {{ $sale->discount > 0 ? number_format($sale->discount, 2) : '—' }}
                            </td>
                            <td class="hidden px-5 py-3 text-right text-blue-600 lg:table-cell">
                                {{ $sale->vat_amount > 0 ? number_format($sale->vat_amount, 2) : '—' }}
                            </td>
                            <td class="px-5 py-3 text-right font-medium text-zinc-900">{{ number_format($sale->net_payable, 2) }}</td>
                            <td class="hidden px-5 py-3 text-right text-emerald-600 md:table-cell">{{ number_format($sale->paid_amount, 2) }}</td>
                            <td class="hidden px-5 py-3 text-right md:table-cell {{ $sale->due_amount > 0 ? 'text-red-600 font-medium' : 'text-zinc-400' }}">
                                {{ $sale->due_amount > 0 ? number_format($sale->due_amount, 2) : '—' }}
                            </td>
                            <td class="px-5 py-3">
                                @php $status = $sale->status; @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    {{ $status === 'paid'    ? 'bg-emerald-50 text-emerald-700' : '' }}
                                    {{ $status === 'partial' ? 'bg-amber-50 text-amber-700'     : '' }}
                                    {{ $status === 'unpaid'  ? 'bg-red-50 text-red-700'         : '' }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-12 text-center text-sm text-zinc-400">
                                <img src="{{ asset('assets/icons/insights.svg') }}" class="mx-auto mb-3 size-10 text-zinc-300 injectable" alt="">
                                No sales found{{ ($from || $to) ? ' for the selected date range.' : '.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sales->hasPages())
            <div class="border-t border-zinc-100 px-5 py-3">
                {{ $sales->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
