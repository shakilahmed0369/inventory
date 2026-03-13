<x-admin-layout>
    <x-slot name="heading">New Product</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-zinc-900 transition-colors">Products</a>
        <span>/</span>
        <span class="font-medium text-zinc-900">New</span>
    </x-slot>

    <x-admin.card title="Product details" description="Fill in the information below to add a new product.">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Name + SKU --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="name" value="Product Name" required />
                    <x-admin.input id="name" name="name" type="text" :value="old('name')"
                                   placeholder="e.g. Widget Pro" autofocus />
                    <x-admin.input-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-admin.label for="sku" value="SKU" />
                    <x-admin.input id="sku" name="sku" type="text" :value="old('sku')"
                                   placeholder="e.g. PROD-001" />
                    <x-admin.input-error :messages="$errors->get('sku')" />
                </div>
            </div>

            {{-- Description --}}
            <div>
                <x-admin.label for="description" value="Description" />
                <textarea id="description" name="description" rows="3"
                          class="mt-1 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm placeholder:text-zinc-400 focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500"
                          placeholder="Optional product description…">{{ old('description') }}</textarea>
                <x-admin.input-error :messages="$errors->get('description')" />
            </div>

            {{-- Image --}}
            <div>
                <x-admin.label for="image" value="Product Image" />
                <input id="image" name="image" type="file" accept="image/*"
                       class="mt-1 block w-full text-sm text-zinc-500 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-900 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-zinc-700" />
                <p class="mt-1 text-xs text-zinc-400">PNG, JPG, GIF up to 2 MB</p>
                <x-admin.input-error :messages="$errors->get('image')" />
            </div>

            {{-- Purchase price + Sell price --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="purchase_price" value="Purchase Price (TK)" required />
                    <x-admin.input id="purchase_price" name="purchase_price" type="number" step="0.01" min="0"
                                   :value="old('purchase_price')" placeholder="0.00" />
                    <x-admin.input-error :messages="$errors->get('purchase_price')" />
                </div>
                <div>
                    <x-admin.label for="sell_price" value="Sell Price (TK)" required />
                    <x-admin.input id="sell_price" name="sell_price" type="number" step="0.01" min="0"
                                   :value="old('sell_price')" placeholder="0.00" />
                    <x-admin.input-error :messages="$errors->get('sell_price')" />
                </div>
            </div>

            {{-- Opening stock --}}
            <div class="sm:w-1/2">
                <x-admin.label for="opening_stock" value="Opening Stock (units)" required />
                <x-admin.input id="opening_stock" name="opening_stock" type="number" min="0"
                               :value="old('opening_stock', 0)" placeholder="0" />
                <x-admin.input-error :messages="$errors->get('opening_stock')" />
            </div>

            <div class="flex items-center gap-3 border-t border-zinc-100 pt-5">
                <x-admin.button type="submit">Create product</x-admin.button>
                <a href="{{ route('products.index') }}">
                    <x-admin.secondary-button type="button">Cancel</x-admin.secondary-button>
                </a>
            </div>
        </form>
    </x-admin.card>
</x-admin-layout>
