<nav class="flex-1 overflow-y-auto px-3 py-4">
    <ul class="space-y-0.5">

        <!-- Overview section -->
        <li class="mb-1 px-3 pt-2 pb-1">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-500">Overview</span>
        </li>

        <li>
            <a href="{{ route('dashboard') }}"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                                      {{ request()->routeIs('dashboard') ? 'bg-zinc-900 text-white' : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900' }}
                                      transition-colors duration-150">
                <img src="{{ asset('assets/icons/dashboard.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Dashboard
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/orders.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Orders
                <span
                    class="ml-auto flex size-5 items-center justify-center rounded-full bg-zinc-100 text-[10px] font-medium text-zinc-600">12</span>
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/users.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Users
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/revenue.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Revenue
            </a>
        </li>

        <!-- Management section -->
        <li class="mb-1 px-3 pt-5 pb-1">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-500">Management</span>
        </li>

        <li>
            <a href="{{ route('customers.index') }}"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                                      {{ request()->routeIs('customers.*') ? 'bg-zinc-900 text-white' : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900' }}
                                      transition-colors duration-150">
                <img src="{{ asset('assets/icons/users.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Customers
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/products.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Products
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/assets.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Assets
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/insights.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Insights
            </a>
        </li>

        <!-- System section -->
        <li class="mb-1 px-3 pt-5 pb-1">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-500">System</span>
        </li>

        <li>
            <a href="{{ route('profile.edit') }}"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                                      {{ request()->routeIs('profile.*') ? 'bg-zinc-900 text-white' : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900' }}
                                      transition-colors duration-150">
                <img src="{{ asset('assets/icons/profile.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Profile
            </a>
        </li>

        <li>
            <a href="#"
                class="group flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors duration-150">
                <img src="{{ asset('assets/icons/settings.svg') }}" class="size-4 shrink-0 injectable" alt="">
                Settings
            </a>
        </li>
    </ul>
</nav>
