<x-admin-layout>
    <x-slot name="heading">New Sale</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <a href="{{ route('sales.index') }}" class="hover:text-zinc-700">Sales</a>
        <span>/</span>
        <span class="font-medium text-zinc-900">New Sale</span>
    </x-slot>

    <div class="flex flex-col gap-4 lg:flex-row lg:h-[calc(100vh-7rem)]">

        {{-- ── LEFT: Product catalogue ──────────────────────────────────── --}}
        <div class="flex h-[50vh] flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white lg:h-auto lg:w-3/5">

            {{-- Panel header + search --}}
            <div class="shrink-0 border-b border-zinc-100 px-5 py-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-900">Products</h3>
                        <p class="text-xs text-zinc-500">{{ $products->count() }} available</p>
                    </div>
                </div>
                <div class="relative mt-2">
                    <svg class="absolute left-2.5 top-2 size-4 text-zinc-400 pointer-events-none"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0A7 7 0 1 0 6.65 16.65 7 7 0 0 0 16.65 16.65z"/>
                    </svg>
                    <input id="product-search" type="text" placeholder="Search products…"
                           class="w-full rounded-md border border-zinc-300 py-1.5 pl-8 pr-3 text-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                </div>
            </div>

            {{-- Scrollable product grid --}}
            <div class="flex-1 overflow-y-auto p-4">
                @if ($products->isEmpty())
                    <div class="flex h-full flex-col items-center justify-center text-sm text-zinc-400">
                        <p>No products with available stock.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="product-grid">
                        @foreach ($products as $product)
                            {{-- Outer wrapper is relative WITHOUT overflow-hidden so the badge can poke out --}}
                            <div class="product-card group relative cursor-pointer select-none rounded-lg transition-all duration-150 active:scale-95"
                                 data-id="{{ $product->id }}"
                                 data-name="{{ $product->name }}"
                                 data-price="{{ $product->sell_price }}"
                                 data-stock="{{ $product->current_stock }}">

                                {{-- In-cart qty badge sits on the outer wrapper so it's never clipped --}}
                                <span class="cart-badge absolute -right-1.5 -top-1.5 z-10 hidden min-w-[1.25rem] items-center justify-center rounded-full bg-zinc-900 px-1 py-0.5 text-[10px] font-bold text-white"></span>

                                {{-- Inner card has overflow-hidden for the image crop + border styling --}}
                                <div class="overflow-hidden rounded-lg border border-zinc-200 hover:border-zinc-400 hover:shadow-sm transition-all duration-150">

                                {{-- Product image --}}
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="aspect-square w-full object-cover">
                                @else
                                    <div class="flex aspect-square w-full items-center justify-center bg-zinc-100">
                                        <svg class="size-10 text-zinc-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v13.5A1.5 1.5 0 0 0 3.75 21Z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Card body --}}
                                <div class="p-3">
                                    <p class="text-xs font-semibold text-zinc-900 leading-snug line-clamp-2">{{ $product->name }}</p>
                                    <p class="mt-1 text-sm font-bold text-zinc-900">৳ {{ number_format($product->sell_price, 2) }}</p>
                                    <div class="mt-1.5 flex items-center justify-between">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium
                                                     {{ $product->current_stock <= 5 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                            Stock: {{ $product->current_stock }}
                                        </span>
                                        <span class="text-base font-light text-zinc-300 transition-colors group-hover:text-zinc-500">+</span>
                                    </div>
                                </div>
                                </div>{{-- /inner card --}}
                            </div>{{-- /outer wrapper --}}
                        @endforeach
                    </div>
                    <p id="no-search-results" class="hidden pt-10 text-center text-sm text-zinc-400">
                        No products match your search.
                    </p>
                @endif
            </div>
        </div>

        {{-- ── RIGHT: Cart / POS ────────────────────────────────────────── --}}
        <form id="sale-form" method="POST" action="{{ route('sales.store') }}"
              class="flex flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white lg:w-2/5">
            @csrf

            {{-- Cart header --}}
            <div class="shrink-0 flex items-center justify-between border-b border-zinc-100 px-5 py-3">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Cart</h3>
                    <p id="cart-count" class="text-xs text-zinc-500">0 items</p>
                </div>
                <button type="button" id="clear-cart"
                        class="rounded-md px-2.5 py-1 text-xs font-medium text-red-500 hover:bg-red-50 transition-colors">
                    Clear all
                </button>
            </div>

            {{-- Scrollable cart items --}}
            <div class="min-h-48 flex-1 overflow-y-auto lg:min-h-0">
                {{-- Empty state --}}
                <div id="cart-empty" class="flex h-full flex-col items-center justify-center p-8 text-center">
                    <div class="flex size-12 items-center justify-center rounded-full bg-zinc-100">
                        <svg class="size-6 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                        </svg>
                    </div>
                    <p class="mt-3 text-sm font-medium text-zinc-600">Cart is empty</p>
                    <p class="mt-1 text-xs text-zinc-400">Click products on the left to add them</p>
                </div>

                {{-- Cart table --}}
                <table id="cart-table" class="hidden w-full text-sm">
                    <thead class="sticky top-0 z-10">
                        <tr class="border-b border-zinc-100 bg-zinc-50 text-left">
                            <th class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">Product</th>
                            <th class="w-24 px-3 py-2 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Price</th>
                            <th class="w-28 px-3 py-2 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500">Qty</th>
                            <th class="w-20 px-3 py-2 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">Total</th>
                            <th class="w-8 px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody id="cart-tbody" class="divide-y divide-zinc-100"></tbody>
                </table>
            </div>

            {{-- Customer / Date / Notes --}}
            <div class="shrink-0 space-y-2.5 border-t border-zinc-200 px-5 py-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-admin.label for="customer_id" value="Customer" />
                        <select id="customer_id" name="customer_id"
                                class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900">
                            <option value="">— Walk-in —</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-admin.input-error :messages="$errors->get('customer_id')" />
                    </div>
                    <div>
                        <x-admin.label for="sale_date" value="Date" required />
                        <input id="sale_date" name="sale_date" type="date"
                               value="{{ old('sale_date', date('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900"
                               required />
                        <x-admin.input-error :messages="$errors->get('sale_date')" />
                    </div>
                </div>
                <div>
                    <x-admin.label for="notes" value="Notes" />
                    <textarea id="notes" name="notes" rows="2"
                              class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900"
                              placeholder="Optional remarks…">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Payment inputs + live totals --}}
            <div class="shrink-0 border-t border-zinc-200 bg-zinc-50 px-5 py-4">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                    <div>
                        <x-admin.label for="discount" value="Discount (৳)" required />
                        <input id="discount" name="discount" type="number" step="0.01" min="0"
                               value="{{ old('discount', 0) }}"
                               class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900"
                               required />
                        <x-admin.input-error :messages="$errors->get('discount')" />
                    </div>
                    <div>
                        <x-admin.label for="vat_rate" value="VAT (%)" required />
                        <input id="vat_rate" name="vat_rate" type="number" step="0.01" min="0" max="100"
                               value="{{ old('vat_rate', 0) }}"
                               class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900"
                               required />
                        <x-admin.input-error :messages="$errors->get('vat_rate')" />
                    </div>
                    <div>
                        <x-admin.label for="paid_amount" value="Paid (৳)" required />
                        <input id="paid_amount" name="paid_amount" type="number" step="0.01" min="0"
                               value="{{ old('paid_amount', 0) }}"
                               class="mt-1 block w-full rounded-md border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-900 focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900"
                               required />
                        <x-admin.input-error :messages="$errors->get('paid_amount')" />
                    </div>
                </div>

                <dl class="mt-3 divide-y divide-zinc-100 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm">
                    <div class="flex justify-between py-1.5">
                        <dt class="text-zinc-500">Gross</dt>
                        <dd class="font-medium text-zinc-900">৳ <span id="gross-amount">0.00</span></dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="text-zinc-500">Discount</dt>
                        <dd class="font-medium text-zinc-900">− ৳ <span id="summary-discount">0.00</span></dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="text-zinc-500">VAT</dt>
                        <dd class="font-medium text-zinc-900">+ ৳ <span id="vat-amount">0.00</span></dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="font-semibold text-zinc-900">Net Payable</dt>
                        <dd class="font-bold text-zinc-900">৳ <span id="net-payable">0.00</span></dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="text-zinc-500">Paid</dt>
                        <dd class="font-medium text-emerald-600">৳ <span id="summary-paid">0.00</span></dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="font-semibold text-zinc-900">Due</dt>
                        <dd id="due-wrapper" class="font-bold text-emerald-600">৳ <span id="due-amount">0.00</span></dd>
                    </div>
                </dl>
            </div>

            {{-- Form footer --}}
            <div class="shrink-0 flex items-center justify-between border-t border-zinc-200 bg-white px-5 py-3">
                <x-admin.input-error :messages="$errors->get('items')" />
                <div class="flex items-center gap-3 ml-auto">
                    <a href="{{ route('sales.index') }}"
                       class="text-sm font-medium text-zinc-600 hover:text-zinc-900 transition-colors">
                        Cancel
                    </a>
                    <x-admin.button type="submit">Record Sale</x-admin.button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $(function () {
            var cart = [];

            // ── Add to cart (click product card) ──────────────────────────────
            $('#product-grid').on('click', '.product-card', function () {
                var id    = $(this).data('id');
                var idx   = cartIndex(id);
                if (idx >= 0) {
                    cart[idx].qty++;
                    updateRow(idx);
                } else {
                    cart.push({
                        id:    id,
                        name:  String($(this).data('name')),
                        price: parseFloat($(this).data('price')) || 0,
                        qty:   1,
                    });
                    renderCart();
                }
                highlightCards();
                recalculate();
            });

            // ── Clear all ──────────────────────────────────────────────────────
            $('#clear-cart').on('click', function () {
                if (!cart.length) { return; }
                cart = [];
                renderCart();
                highlightCards();
                recalculate();
            });

            // ── Qty dec ────────────────────────────────────────────────────────
            $('#cart-tbody').on('click', '.qty-dec', function () {
                var i = +$(this).data('index');
                if (cart[i].qty > 1) {
                    cart[i].qty--;
                    updateRow(i);
                } else {
                    cart.splice(i, 1);
                    renderCart();
                    highlightCards();
                }
                recalculate();
            });

            // ── Qty inc ────────────────────────────────────────────────────────
            $('#cart-tbody').on('click', '.qty-inc', function () {
                var i = +$(this).data('index');
                cart[i].qty++;
                updateRow(i);
                recalculate();
            });

            // ── Qty typed ─────────────────────────────────────────────────────
            $('#cart-tbody').on('input', '.item-qty', function () {
                var i   = +$(this).data('index');
                var val = Math.max(1, parseInt($(this).val()) || 1);
                cart[i].qty = val;
                rowSubtotal(i);
                recalculate();
            });

            // ── Price typed ───────────────────────────────────────────────────
            $('#cart-tbody').on('input', '.item-price', function () {
                var i = +$(this).data('index');
                cart[i].price = parseFloat($(this).val()) || 0;
                rowSubtotal(i);
                recalculate();
            });

            // ── Remove item ────────────────────────────────────────────────────
            $('#cart-tbody').on('click', '.remove-item', function () {
                cart.splice(+$(this).data('index'), 1);
                renderCart();
                highlightCards();
                recalculate();
            });

            // ── Summary inputs ────────────────────────────────────────────────
            $('#discount, #vat_rate, #paid_amount').on('input', recalculate);

            // ── Product search ────────────────────────────────────────────────
            $('#product-search').on('input', function () {
                var q = $(this).val().toLowerCase().trim();
                var n = 0;
                $('.product-card').each(function () {
                    var match = String($(this).data('name')).toLowerCase().indexOf(q) >= 0;
                    $(this).toggle(match);
                    if (match) { n++; }
                });
                $('#no-search-results').toggle(q.length > 0 && n === 0);
            });

            // ── Helpers ───────────────────────────────────────────────────────
            function cartIndex(id) {
                for (var i = 0; i < cart.length; i++) {
                    if (cart[i].id == id) { return i; }
                }
                return -1;
            }

            function renderCart() {
                if (!cart.length) {
                    $('#cart-empty').show();
                    $('#cart-table').addClass('hidden');
                    $('#cart-count').text('0 items');
                    return;
                }

                $('#cart-empty').hide();
                $('#cart-table').removeClass('hidden');
                $('#cart-count').text(cart.length + (cart.length === 1 ? ' item' : ' items'));

                var rows = '';
                $.each(cart, function (i, item) {
                    var sub = (item.qty * item.price).toFixed(2);
                    rows +=
                        '<tr>' +
                            '<td class="px-4 py-2">' +
                                '<span class="text-xs font-medium text-zinc-900">' + esc(item.name) + '</span>' +
                                '<input type="hidden" name="items[' + i + '][product_id]" value="' + item.id + '">' +
                            '</td>' +
                            '<td class="px-3 py-2">' +
                                '<input type="number" step="0.01" min="0" data-index="' + i + '"' +
                                    ' name="items[' + i + '][unit_price]" value="' + item.price.toFixed(2) + '"' +
                                    ' class="item-price w-20 rounded border border-zinc-200 px-2 py-1 text-right text-xs focus:border-zinc-500 focus:outline-none">' +
                            '</td>' +
                            '<td class="px-3 py-2">' +
                                '<div class="flex items-center gap-1">' +
                                    '<button type="button" data-index="' + i + '"' +
                                        ' class="qty-dec flex size-5 items-center justify-center rounded bg-zinc-100 text-xs font-semibold text-zinc-700 hover:bg-zinc-200">−</button>' +
                                    '<input type="number" min="1" data-index="' + i + '"' +
                                        ' name="items[' + i + '][quantity]" value="' + item.qty + '"' +
                                        ' class="item-qty w-20 rounded border border-zinc-200 px-1 py-1 text-center text-xs focus:border-zinc-500 focus:outline-none">' +
                                    '<button type="button" data-index="' + i + '"' +
                                        ' class="qty-inc flex size-5 items-center justify-center rounded bg-zinc-100 text-xs font-semibold text-zinc-700 hover:bg-zinc-200">+</button>' +
                                '</div>' +
                            '</td>' +
                            '<td class="row-subtotal px-3 py-2 text-right text-xs font-semibold text-zinc-900">' + sub + '</td>' +
                            '<td class="px-2 py-2 text-center">' +
                                '<button type="button" data-index="' + i + '"' +
                                    ' class="remove-item text-base font-light leading-none text-red-400 hover:text-red-600">×</button>' +
                            '</td>' +
                        '</tr>';
                });

                $('#cart-tbody').html(rows);
            }

            // Update a single row's qty input + subtotal (no full re-render)
            function updateRow(i) {
                $('#cart-tbody tr').eq(i).find('.item-qty').val(cart[i].qty);
                rowSubtotal(i);
            }

            function rowSubtotal(i) {
                var sub = (cart[i].qty * cart[i].price).toFixed(2);
                $('#cart-tbody tr').eq(i).find('.row-subtotal').text(sub);
            }

            function highlightCards() {
                $('.product-card').each(function () {
                    var i = cartIndex($(this).data('id'));
                    var $b = $(this).find('.cart-badge');
                    if (i >= 0) {
                        $b.text(cart[i].qty).addClass('inline-flex').removeClass('hidden');
                        $(this).addClass('border-zinc-900 ring-1 ring-zinc-900 bg-zinc-50');
                    } else {
                        $b.addClass('hidden').removeClass('inline-flex');
                        $(this).removeClass('border-zinc-900 ring-1 ring-zinc-900 bg-zinc-50');
                    }
                });
            }

            function recalculate() {
                var gross    = cart.reduce(function (s, x) { return s + x.qty * x.price; }, 0);
                var discount = Math.max(0, parseFloat($('#discount').val())    || 0);
                var vatRate  = Math.max(0, parseFloat($('#vat_rate').val())    || 0);
                var paid     = Math.max(0, parseFloat($('#paid_amount').val()) || 0);
                var vatAmt   = Math.max(0, gross - discount) * vatRate / 100;
                var net      = gross - discount + vatAmt;
                var due      = Math.max(0, net - paid);

                $('#gross-amount').text(gross.toFixed(2));
                $('#summary-discount').text(discount.toFixed(2));
                $('#vat-amount').text(vatAmt.toFixed(2));
                $('#net-payable').text(net.toFixed(2));
                $('#summary-paid').text(paid.toFixed(2));
                $('#due-amount').text(due.toFixed(2));
                $('#due-wrapper')
                    .toggleClass('text-red-600',     due > 0)
                    .toggleClass('text-emerald-600', due <= 0);
            }

            function esc(str) {
                return $('<div>').text(str).html();
            }

            recalculate();
        });
    </script>
    @endpush
</x-admin-layout>
