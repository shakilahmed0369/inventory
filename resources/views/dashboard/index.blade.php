<x-admin-layout>
    <x-slot name="heading">Dashboard</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Dashboard</span>
    </x-slot>

    @php
        $revDiff   = $revenueLastMonth > 0 ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100 : null;
        $salesDiff = $salesCountLast  > 0 ? $salesCountThis - $salesCountLast : null;
    @endphp

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Revenue this month --}}
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Revenue (This Month)</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/revenue.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">৳ {{ number_format($revenueThisMonth, 2) }}</p>
            @if ($revDiff !== null)
                <p class="mt-1 flex items-center gap-1 text-xs {{ $revDiff >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 injectable {{ $revDiff < 0 ? 'rotate-180' : '' }}" alt="">
                    {{ $revDiff >= 0 ? '+' : '' }}{{ number_format($revDiff, 1) }}% vs last month
                </p>
            @else
                <p class="mt-1 text-xs text-zinc-400">No data for last month</p>
            @endif
        </div>

        {{-- Sales this month --}}
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Sales (This Month)</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/orders.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">{{ number_format($salesCountThis) }}</p>
            @if ($salesDiff !== null)
                <p class="mt-1 flex items-center gap-1 text-xs {{ $salesDiff >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 injectable {{ $salesDiff < 0 ? 'rotate-180' : '' }}" alt="">
                    {{ $salesDiff >= 0 ? '+' : '' }}{{ $salesDiff }} vs last month
                </p>
            @else
                <p class="mt-1 text-xs text-zinc-400">No data for last month</p>
            @endif
        </div>

        {{-- Outstanding due --}}
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Outstanding Due</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-red-50">
                    <img src="{{ asset('assets/icons/credit-card.svg') }}" class="size-4 text-red-500 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold {{ $totalDue > 0 ? 'text-red-600' : 'text-zinc-900' }}">
                ৳ {{ number_format($totalDue, 2) }}
            </p>
            <p class="mt-1 text-xs text-zinc-400">Across all unpaid / partial sales</p>
        </div>

        {{-- Low stock --}}
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Low Stock Products</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-amber-50">
                    <img src="{{ asset('assets/icons/warning.svg') }}" class="size-4 text-amber-500 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-zinc-900' }}">
                {{ $lowStockCount }}
            </p>
            <p class="mt-1 text-xs text-zinc-400">{{ $totalProducts }} total · {{ $totalCustomers }} customers</p>
        </div>
    </div>

    {{-- Lower section: Recent sales + Top products / Low stock --}}
    <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-7">

        {{-- Recent Sales table (4 cols) --}}
        <div class="col-span-1 rounded-lg border border-zinc-200 bg-white lg:col-span-4">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900">Recent Sales</h2>
                    <p class="mt-0.5 text-xs text-zinc-500">Last 8 transactions</p>
                </div>
                <a href="{{ route('sales.index') }}"
                   class="text-xs font-medium text-zinc-500 hover:text-zinc-900 transition-colors">
                    View all →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100">
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Customer</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Date</th>
                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-400">Net (৳)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($recentSales as $sale)
                            @php $status = $sale->status; $name = $sale->customer?->name ?? 'Walk-in'; @endphp
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-[10px] font-semibold uppercase text-white">
                                            {{ substr($name, 0, 2) }}
                                        </div>
                                        <span class="font-medium text-zinc-900">{{ $name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        {{ $status === 'paid'    ? 'bg-emerald-50 text-emerald-700' : '' }}
                                        {{ $status === 'partial' ? 'bg-amber-50 text-amber-700'     : '' }}
                                        {{ $status === 'unpaid'  ? 'bg-red-50 text-red-700'         : '' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-zinc-500">{{ $sale->sale_date->format('M d, Y') }}</td>
                                <td class="px-5 py-3 text-right font-medium text-zinc-900">{{ number_format($sale->net_payable, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-sm text-zinc-400">No sales yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right panel: Top products + Low stock --}}
        <div class="col-span-1 flex flex-col gap-4 lg:col-span-3">

            {{-- Top 5 products by units sold --}}
            <div class="rounded-lg border border-zinc-200 bg-white">
                <div class="border-b border-zinc-100 px-5 py-4">
                    <h2 class="text-sm font-semibold text-zinc-900">Top Products</h2>
                    <p class="mt-0.5 text-xs text-zinc-500">By units sold (all time)</p>
                </div>
                <ul class="divide-y divide-zinc-100">
                    @forelse ($topProducts as $item)
                        <li class="flex items-center justify-between px-5 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-zinc-900">{{ $item->product?->name ?? '—' }}</p>
                                <p class="text-xs text-zinc-400">Stock: {{ $item->product?->current_stock ?? '—' }}</p>
                            </div>
                            <div class="ml-4 shrink-0 text-right">
                                <p class="text-sm font-semibold text-zinc-900">{{ number_format($item->total_qty) }} units</p>
                                <p class="text-xs text-zinc-400">৳ {{ number_format($item->total_revenue, 0) }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="px-5 py-6 text-center text-sm text-zinc-400">No sales data yet.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Low stock alert --}}
            @if ($lowStockProducts->isNotEmpty())
                <div class="rounded-lg border border-amber-200 bg-amber-50">
                    <div class="border-b border-amber-100 px-5 py-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/warning.svg') }}" class="size-4 text-amber-600 injectable" alt="">
                            <h2 class="text-sm font-semibold text-amber-900">Low Stock Alert</h2>
                        </div>
                        <p class="mt-0.5 text-xs text-amber-700">Products with ≤ 5 units remaining</p>
                    </div>
                    <ul class="divide-y divide-amber-100">
                        @foreach ($lowStockProducts as $product)
                            <li class="flex items-center justify-between px-5 py-2.5">
                                <span class="truncate text-sm font-medium text-amber-900">{{ $product->name }}</span>
                                <span class="ml-3 shrink-0 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                                    {{ $product->current_stock }} left
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ route('sales.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition-colors">
            <img src="{{ asset('assets/icons/arrow-right.svg') }}" class="size-4 injectable" alt="">
            New Sale
        </a>
        <a href="{{ route('reports.index') }}"
           class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <img src="{{ asset('assets/icons/revenue.svg') }}" class="size-4 injectable" alt="">
            View Reports
        </a>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <img src="{{ asset('assets/icons/products.svg') }}" class="size-4 injectable" alt="">
            Add Product
        </a>
    </div>

</x-admin-layout>

