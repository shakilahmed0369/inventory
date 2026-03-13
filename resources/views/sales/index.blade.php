<x-admin-layout>
    <x-slot name="heading">Sales</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Sales</span>
    </x-slot>

    {{-- Header row --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">All Sales</h2>
            <p class="mt-0.5 text-sm text-zinc-500">{{ $sales->total() }} total records</p>
        </div>
        <a href="{{ route('sales.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition-colors">
            <img src="{{ asset('assets/icons/arrow-right.svg') }}" class="size-4 injectable" alt="">
            New Sale
        </a>
    </div>

    {{-- Table card --}}
    <div class="rounded-lg border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Date</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Customer</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Items</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Gross</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Discount</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 lg:table-cell">VAT</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Net Payable</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Paid</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Due</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3 text-zinc-700">
                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-3 text-zinc-700">
                                {{ $sale->customer?->name ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-right text-zinc-500">
                                {{ $sale->items->count() }}
                            </td>
                            <td class="px-5 py-3 text-right font-medium text-zinc-900">
                                {{ number_format($sale->gross_amount, 2) }}
                            </td>
                            <td class="hidden px-5 py-3 text-right text-zinc-500 md:table-cell">
                                {{ number_format($sale->discount, 2) }}
                            </td>
                            <td class="hidden px-5 py-3 text-right text-zinc-500 lg:table-cell">
                                {{ number_format($sale->vat_amount, 2) }}
                            </td>
                            <td class="px-5 py-3 text-right font-semibold text-zinc-900">
                                {{ number_format($sale->net_payable, 2) }}
                            </td>
                            <td class="hidden px-5 py-3 text-right text-emerald-700 md:table-cell">
                                {{ number_format($sale->paid_amount, 2) }}
                            </td>
                            <td class="hidden px-5 py-3 text-right text-red-600 md:table-cell">
                                {{ number_format($sale->due_amount, 2) }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php $status = $sale->status; @endphp
                                @if ($status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Paid</span>
                                @elseif ($status === 'partial')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">Partial</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('sales.show', $sale) }}"
                                   class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                    <img src="{{ asset('assets/icons/circle-info.svg') }}" class="size-3.5 injectable" alt="">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-5 py-12 text-center text-sm text-zinc-400">
                                <img src="{{ asset('assets/icons/orders.svg') }}" class="mx-auto mb-3 size-10 text-zinc-300 injectable" alt="">
                                No sales recorded yet.
                                <a href="{{ route('sales.create') }}" class="font-medium text-zinc-900 underline">Record the first sale.</a>
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
