<x-admin-layout>
    <x-slot name="heading">Customers</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Customers</span>
    </x-slot>

    {{-- Header row --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">All Customers</h2>
            <p class="mt-0.5 text-sm text-zinc-500">{{ $customers->total() }} total records</p>
        </div>
        <a href="{{ route('customers.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition-colors">
            <img src="{{ asset('assets/icons/arrow-right.svg') }}" class="size-4 injectable" alt="">
            New Customer
        </a>
    </div>

    {{-- Table card --}}
    <div class="rounded-lg border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Name</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Email</th>
                        <th class="hidden px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500 sm:table-cell">Phone</th>
                        <th class="hidden px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500 md:table-cell">Address</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Created</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-[10px] font-semibold uppercase text-white">
                                        {{ substr($customer->name, 0, 2) }}
                                    </div>
                                    <span class="font-medium text-zinc-900">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-zinc-600">{{ $customer->email }}</td>
                            <td class="hidden px-5 py-3 text-zinc-500 sm:table-cell">{{ $customer->phone ?? '—' }}</td>
                            <td class="hidden max-w-[180px] truncate px-5 py-3 text-zinc-500 md:table-cell">{{ $customer->address ?? '—' }}</td>
                            <td class="px-5 py-3 text-zinc-500">{{ $customer->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                        <img src="{{ asset('assets/icons/edit.svg') }}" class="size-3.5 injectable" alt="">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                          class="delete-form" data-name="{{ $customer->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-md border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition-colors">
                                            <img src="{{ asset('assets/icons/trash.svg') }}" class="size-3.5 injectable" alt="">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-zinc-400">
                                <img src="{{ asset('assets/icons/users.svg') }}" class="mx-auto mb-3 size-10 text-zinc-300 injectable" alt="">
                                No customers yet.
                                <a href="{{ route('customers.create') }}" class="font-medium text-zinc-900 underline">Add one now.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="border-t border-zinc-100 px-5 py-3">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    {{-- Delete confirmation modal --}}
    <div id="delete-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div id="delete-confirm-backdrop" class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 w-full max-w-sm rounded-lg border border-zinc-200 bg-white p-6 shadow-xl">
            <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-red-50">
                <img src="{{ asset('assets/icons/warning.svg') }}" class="size-5 text-red-600 injectable" alt="">
            </div>
            <h2 class="text-base font-semibold text-zinc-900">Delete customer?</h2>
            <p class="mt-1 text-sm text-zinc-500">
                <strong id="delete-customer-name" class="text-zinc-700"></strong> will be permanently removed. This cannot be undone.
            </p>
            <div class="mt-5 flex justify-end gap-3">
                <x-admin.secondary-button id="cancel-delete">Cancel</x-admin.secondary-button>
                <x-admin.danger-button id="confirm-delete">Delete</x-admin.danger-button>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            var pendingForm = null;

            $('.delete-form').on('submit', function (e) {
                e.preventDefault();
                pendingForm = this;
                $('#delete-customer-name').text($(this).data('name'));
                $('#delete-confirm-modal').removeClass('hidden').addClass('flex');
            });

            $('#cancel-delete, #delete-confirm-backdrop').on('click', function () {
                $('#delete-confirm-modal').removeClass('flex').addClass('hidden');
                pendingForm = null;
            });

            $('#confirm-delete').on('click', function () {
                if (pendingForm) { $(pendingForm).off('submit').trigger('submit'); }
            });
        });
    </script>
</x-admin-layout>
