<x-admin-layout>
    <x-slot name="heading">New Customer</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <a href="{{ route('customers.index') }}" class="hover:text-zinc-900 transition-colors">Customers</a>
        <span>/</span>
        <span class="font-medium text-zinc-900">New</span>
    </x-slot>

    <x-admin.card title="Customer details" description="Fill in the information below to add a new customer.">
        <form method="POST" action="{{ route('customers.store') }}" class="space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <x-admin.label for="name" value="Name" required />
                <x-admin.input id="name" name="name" type="text" :value="old('name')"
                               placeholder="Jane Smith" autofocus />
                <x-admin.input-error :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div>
                <x-admin.label for="email" value="Email address" required />
                <x-admin.input id="email" name="email" type="email" :value="old('email')"
                               placeholder="jane@example.com" />
                <x-admin.input-error :messages="$errors->get('email')" />
            </div>

            {{-- Phone + Address row --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-admin.label for="phone" value="Phone" />
                    <x-admin.input id="phone" name="phone" type="text" :value="old('phone')"
                                   placeholder="+1 (555) 000-0000" />
                    <x-admin.input-error :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-admin.label for="address" value="Address" />
                    <x-admin.input id="address" name="address" type="text" :value="old('address')"
                                   placeholder="123 Main St, City" />
                    <x-admin.input-error :messages="$errors->get('address')" />
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-zinc-100 pt-5">
                <x-admin.button type="submit">Create customer</x-admin.button>
                <a href="{{ route('customers.index') }}">
                    <x-admin.secondary-button type="button">Cancel</x-admin.secondary-button>
                </a>
            </div>
        </form>
    </x-admin.card>
</x-admin-layout>
