<x-admin-layout>
    <x-slot name="heading">Products</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Products</span>
    </x-slot>

    {{-- Header row --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">All Products</h2>
            <p class="mt-0.5 text-sm text-zinc-500">{{ $products->total() }} total records</p>
        </div>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition-colors">
            <img src="{{ asset('assets/icons/arrow-right.svg') }}" class="size-4 injectable" alt="">
            New Product
        </a>
    </div>

    {{-- Table card --}}
    <div class="rounded-lg border border-zinc-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Product</th>
                        <th class="hidden px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500 sm:table-cell">SKU</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Purchase</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Sell</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Stock</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($product->image)
                                        <img src="{{ Storage::url($product->image) }}"
                                             class="size-9 shrink-0 rounded-md object-cover border border-zinc-200" alt="">
                                    @else
                                        <div class="flex size-9 shrink-0 items-center justify-center rounded-md bg-zinc-100 text-zinc-400">
                                            <img src="{{ asset('assets/icons/products.svg') }}" class="size-4 injectable" alt="">
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-zinc-900">{{ $product->name }}</p>
                                        @if ($product->description)
                                            <p class="max-w-[200px] truncate text-xs text-zinc-400">{{ $product->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-5 py-3 text-zinc-500 sm:table-cell">{{ $product->sku ?? '—' }}</td>
                            <td class="px-5 py-3 font-medium text-zinc-900">{{ number_format($product->purchase_price, 2) }} TK</td>
                            <td class="px-5 py-3 font-medium text-zinc-900">{{ number_format($product->sell_price, 2) }} TK</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $product->current_stock > 10 ? 'bg-emerald-50 text-emerald-700' : ($product->current_stock > 0 ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                    {{ $product->current_stock }} units
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="inline-flex items-center gap-1.5 rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                        <img src="{{ asset('assets/icons/edit.svg') }}" class="size-3.5 injectable" alt="">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}"
                                          class="delete-form" data-name="{{ $product->name }}"
                                          data-sale-items-count="{{ $product->sale_items_count }}">
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
                                <img src="{{ asset('assets/icons/products.svg') }}" class="mx-auto mb-3 size-10 text-zinc-300 injectable" alt="">
                                No products yet.
                                <a href="{{ route('products.create') }}" class="font-medium text-zinc-900 underline">Add one now.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="border-t border-zinc-100 px-5 py-3">
                {{ $products->links() }}
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
            <h2 class="text-base font-semibold text-zinc-900">Delete product?</h2>
            <p class="mt-1 text-sm text-zinc-500">
                <strong id="delete-product-name" class="text-zinc-700"></strong> will be permanently removed. This cannot be undone.
            </p>
            <p id="delete-product-warning" class="mt-2 hidden rounded-md bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700">
                This product has <span id="delete-product-sale-count"></span> sale record(s). <strong>Deletion is not allowed</strong> while sale history exists.
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
                var count = parseInt($(this).data('sale-items-count')) || 0;
                $('#delete-product-name').text($(this).data('name'));
                if (count > 0) {
                    $('#delete-product-warning').removeClass('hidden');
                    $('#delete-product-sale-count').text(count);
                    $('#confirm-delete').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                } else {
                    $('#delete-product-warning').addClass('hidden');
                    $('#confirm-delete').prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                }
                $('#delete-confirm-modal').removeClass('hidden').addClass('flex');
            });

            $('#cancel-delete, #delete-confirm-backdrop').on('click', function () {
                $('#delete-confirm-modal').removeClass('flex').addClass('hidden');
                pendingForm = null;
            });

            $('#confirm-delete').on('click', function () {
                if (pendingForm && !$(this).prop('disabled')) { $(pendingForm).off('submit').trigger('submit'); }
            });
        });
    </script>
</x-admin-layout>
