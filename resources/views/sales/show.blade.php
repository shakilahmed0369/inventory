<x-admin-layout>
    <x-slot name="heading">Sale #{{ $sale->id }}</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <a href="{{ route('sales.index') }}" class="hover:text-zinc-700">Sales</a>
        <span>/</span>
        <span class="font-medium text-zinc-900">#{{ $sale->id }}</span>
    </x-slot>

    {{-- Top row: Sale Details + Customer Info --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Sale details card --}}
        <x-admin.card title="Sale Details">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Sale #</dt>
                    <dd class="mt-1 font-mono text-sm font-medium text-zinc-900">{{ $sale->id }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Date</dt>
                    <dd class="mt-1 text-sm font-medium text-zinc-900">{{ $sale->sale_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Status</dt>
                    <dd class="mt-1">
                        @if ($sale->status === 'paid')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Paid</span>
                        @elseif ($sale->status === 'partial')
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">Partial</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">Unpaid</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Items</dt>
                    <dd class="mt-1 text-sm font-medium text-zinc-900">{{ $sale->items->count() }}</dd>
                </div>
                @if ($sale->notes)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Notes</dt>
                        <dd class="mt-1 text-sm text-zinc-700">{{ $sale->notes }}</dd>
                    </div>
                @endif
            </dl>
        </x-admin.card>

        {{-- Customer info card --}}
        <x-admin.card title="Customer">
            @if ($sale->customer)
                <div class="flex items-start gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-sm font-semibold uppercase text-white">
                        {{ substr($sale->customer->name, 0, 2) }}
                    </div>
                    <dl class="flex-1 grid grid-cols-1 gap-y-3 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Name</dt>
                            <dd class="mt-1 text-sm font-semibold text-zinc-900">
                                <a href="{{ route('customers.edit', $sale->customer) }}"
                                   class="underline decoration-zinc-300 hover:decoration-zinc-600">
                                    {{ $sale->customer->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Email</dt>
                            <dd class="mt-1 text-sm text-zinc-700">
                                @if ($sale->customer->email)
                                    <a href="mailto:{{ $sale->customer->email }}"
                                       class="underline decoration-zinc-300 hover:decoration-zinc-600">
                                        {{ $sale->customer->email }}
                                    </a>
                                @else
                                    <span class="text-zinc-400">—</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Phone</dt>
                            <dd class="mt-1 text-sm text-zinc-700">{{ $sale->customer->phone ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Address</dt>
                            <dd class="mt-1 text-sm text-zinc-700">{{ $sale->customer->address ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-6 text-center">
                    <div class="flex size-10 items-center justify-center rounded-full bg-zinc-100">
                        <img src="{{ asset('assets/icons/users.svg') }}" class="size-5 text-zinc-400 injectable" alt="">
                    </div>
                    <p class="mt-3 text-sm font-medium text-zinc-600">Walk-in Customer</p>
                    <p class="mt-1 text-xs text-zinc-400">No customer was linked to this sale.</p>
                </div>
            @endif
        </x-admin.card>

    </div>

    {{-- Financial summary + line items --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Line items table (2/3 width) --}}
        <div class="lg:col-span-2">
            <h3 class="mb-3 text-base font-semibold text-zinc-900">Items Sold</h3>
            <div class="rounded-lg border border-zinc-200 bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Product</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Unit Price (৳)</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Qty</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Subtotal (৳)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($sale->items as $item)
                                <tr class="hover:bg-zinc-50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-zinc-900">
                                        {{ $item->product?->name ?? '(deleted product)' }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-zinc-600">
                                        {{ number_format((float) $item->unit_price, 2) }}
                                    </td>
                                    <td class="px-5 py-3 text-right text-zinc-600">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-5 py-3 text-right font-semibold text-zinc-900">
                                        {{ number_format((float) $item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Financial summary (1/3 width) --}}
        <div>
            <h3 class="mb-3 text-base font-semibold text-zinc-900">Financial Summary</h3>
            <div class="rounded-lg border border-zinc-200 bg-white">
                <dl class="divide-y divide-zinc-100 px-5 py-1 text-sm">
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-zinc-500">Gross Amount</dt>
                        <dd class="font-medium text-zinc-900">৳ {{ number_format((float) $sale->gross_amount, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-zinc-500">Discount</dt>
                        <dd class="font-medium text-zinc-900">− ৳ {{ number_format((float) $sale->discount, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-zinc-500">VAT ({{ number_format((float) $sale->vat_rate, 2) }}%)</dt>
                        <dd class="font-medium text-zinc-900">+ ৳ {{ number_format((float) $sale->vat_amount, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="font-semibold text-zinc-900">Net Payable</dt>
                        <dd class="font-bold text-zinc-900">৳ {{ number_format((float) $sale->net_payable, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="text-zinc-500">Paid</dt>
                        <dd class="font-semibold text-emerald-700">৳ {{ number_format((float) $sale->paid_amount, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="font-semibold text-zinc-900">Due</dt>
                        <dd class="font-bold {{ $sale->due_amount > 0 ? 'text-red-600' : 'text-emerald-700' }}">
                            ৳ {{ number_format((float) $sale->due_amount, 2) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    {{-- Journal entries linked to this sale --}}
    @if ($sale->journalEntries->isNotEmpty())
        <div class="mt-6">
            <h3 class="mb-3 text-base font-semibold text-zinc-900">Journal Entries</h3>
            <div class="rounded-lg border border-zinc-200 bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">#</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Description</th>
                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Date</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($sale->journalEntries as $entry)
                                <tr class="hover:bg-zinc-50 transition-colors">
                                    <td class="px-5 py-3 font-mono text-xs text-zinc-400">{{ $entry->id }}</td>
                                    <td class="px-5 py-3 font-medium text-zinc-900">{{ $entry->description }}</td>
                                    <td class="px-5 py-3 text-zinc-500">{{ $entry->entry_date->format('M d, Y') }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('journal-entries.show', $entry) }}"
                                           class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                            <img src="{{ asset('assets/icons/circle-info.svg') }}" class="size-3.5 injectable" alt="">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Footer nav --}}
    <div class="mt-6">
        <a href="{{ route('sales.index') }}"
           class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50">
            ← Back to Sales
        </a>
    </div>
</x-admin-layout>
