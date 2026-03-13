<x-admin-layout>
    <x-slot name="heading">Journal Entry #{{ $journalEntry->id }}</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <a href="{{ route('journal-entries.index') }}" class="hover:text-zinc-700">Journal Entries</a>
        <span>/</span>
        <span class="font-medium text-zinc-900">#{{ $journalEntry->id }}</span>
    </x-slot>

    {{-- Entry header card --}}
    <x-admin.card title="Entry Details">
        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Entry #</dt>
                <dd class="mt-1 font-mono text-sm font-medium text-zinc-900">{{ $journalEntry->id }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Date</dt>
                <dd class="mt-1 text-sm font-medium text-zinc-900">{{ $journalEntry->entry_date->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Description</dt>
                <dd class="mt-1 text-sm text-zinc-900">{{ $journalEntry->description }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase tracking-wider text-zinc-500">Reference</dt>
                <dd class="mt-1 text-sm text-zinc-900">
                    @if ($reference)
                        @php $shortType = class_basename($journalEntry->reference_type); @endphp
                        @if ($shortType === 'Sale')
                            <a href="{{ route('sales.show', $reference) }}"
                               class="font-medium text-zinc-900 underline decoration-zinc-300 hover:decoration-zinc-600">
                                Sale #{{ $reference->id }}
                            </a>
                        @else
                            {{ $shortType }} #{{ $reference->id }}
                        @endif
                    @else
                        <span class="text-zinc-400">—</span>
                    @endif
                </dd>
            </div>
        </dl>
    </x-admin.card>

    {{-- Lines table --}}
    <div class="mt-6">
        <h3 class="mb-3 text-base font-semibold text-zinc-900">Debit / Credit Lines</h3>

        <div class="rounded-lg border border-zinc-200 bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Code</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Account</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Type</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Debit (৳)</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Credit (৳)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($journalEntry->lines as $line)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-5 py-3 font-mono text-xs text-zinc-500">{{ $line->account->code }}</td>
                                <td class="px-5 py-3 font-medium text-zinc-900">{{ $line->account->name }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $line->account->type === 'asset'     ? 'bg-blue-50 text-blue-700'    : '' }}
                                        {{ $line->account->type === 'liability' ? 'bg-amber-50 text-amber-700'  : '' }}
                                        {{ $line->account->type === 'revenue'   ? 'bg-emerald-50 text-emerald-700' : '' }}
                                        {{ $line->account->type === 'expense'   ? 'bg-red-50 text-red-700'      : '' }}">
                                        {{ ucfirst($line->account->type) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right {{ $line->debit > 0 ? 'font-medium text-zinc-900' : 'text-zinc-300' }}">
                                    {{ $line->debit > 0 ? number_format((float) $line->debit, 2) : '—' }}
                                </td>
                                <td class="px-5 py-3 text-right {{ $line->credit > 0 ? 'font-medium text-zinc-900' : 'text-zinc-300' }}">
                                    {{ $line->credit > 0 ? number_format((float) $line->credit, 2) : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- Totals row --}}
                    @php
                        $totalDebit  = $journalEntry->lines->sum('debit');
                        $totalCredit = $journalEntry->lines->sum('credit');
                        $balanced    = round((float) $totalDebit, 2) === round((float) $totalCredit, 2);
                    @endphp
                    <tfoot>
                        <tr class="border-t-2 border-zinc-200 bg-zinc-50">
                            <td colspan="3" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                Total
                                @if ($balanced)
                                    <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Balanced</span>
                                @else
                                    <span class="ml-2 inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700">Unbalanced</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right text-sm font-bold text-zinc-900">{{ number_format((float) $totalDebit, 2) }}</td>
                            <td class="px-5 py-3 text-right text-sm font-bold text-zinc-900">{{ number_format((float) $totalCredit, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Footer nav --}}
    <div class="mt-6">
        <a href="{{ route('journal-entries.index') }}"
           class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50">
            ← Back to Journal Entries
        </a>
    </div>
</x-admin-layout>
