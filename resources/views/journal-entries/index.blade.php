<x-admin-layout>
    <x-slot name="heading">Journal Entries</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Journal Entries</span>
    </x-slot>

    {{-- Date-range filter --}}
    <form method="GET" action="{{ route('journal-entries.index') }}" class="mb-6">
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
                <a href="{{ route('journal-entries.index') }}"
                   class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Header row --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">All Journal Entries</h2>
            <p class="mt-0.5 text-sm text-zinc-500">{{ $entries->total() }} total entries</p>
        </div>
    </div>

    {{-- Table card --}}
    <div class="rounded-lg border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">#</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Date</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Description</th>
                        <th class="hidden px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500 sm:table-cell">Lines</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Total DR (৳)</th>
                        <th class="hidden px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Total CR (৳)</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Balanced</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($entries as $entry)
                        @php $balanced = round((float) $entry->total_debit, 2) === round((float) $entry->total_credit, 2); @endphp
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3 font-mono text-xs text-zinc-400">{{ $entry->id }}</td>
                            <td class="px-5 py-3 text-zinc-600">{{ $entry->entry_date->format('M d, Y') }}</td>
                            <td class="max-w-[220px] truncate px-5 py-3 font-medium text-zinc-900">{{ $entry->description }}</td>
                            <td class="hidden px-5 py-3 text-zinc-500 sm:table-cell">{{ $entry->lines_count }}</td>
                            <td class="hidden px-5 py-3 text-right text-zinc-600 md:table-cell">{{ number_format((float) $entry->total_debit, 2) }}</td>
                            <td class="hidden px-5 py-3 text-right text-zinc-600 md:table-cell">{{ number_format((float) $entry->total_credit, 2) }}</td>
                            <td class="px-5 py-3">
                                @if ($balanced)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">Yes</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">No</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('journal-entries.show', $entry) }}"
                                   class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                    <img src="{{ asset('assets/icons/circle-info.svg') }}" class="size-3.5 injectable" alt="">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-sm text-zinc-400">
                                <img src="{{ asset('assets/icons/insights.svg') }}" class="mx-auto mb-3 size-10 text-zinc-300 injectable" alt="">
                                No journal entries yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($entries->hasPages())
            <div class="border-t border-zinc-100 px-5 py-3">
                {{ $entries->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
