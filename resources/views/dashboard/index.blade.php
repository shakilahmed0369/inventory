<x-admin-layout>
    <x-slot name="heading">Dashboard</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="text-zinc-900 font-medium">Dashboard</span>
    </x-slot>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <!-- Total Revenue -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Total Revenue</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/revenue.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">$45,231.89</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 injectable" alt="">
                +20.1% from last month
            </p>
        </div>

        <!-- Active Users -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Active Users</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/users.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+2,350</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 injectable" alt="">
                +180.1% from last month
            </p>
        </div>

        <!-- Sales -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Sales</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/orders.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+12,234</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 injectable" alt="">
                +19% from last month
            </p>
        </div>

        <!-- Active Now -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Active Now</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <img src="{{ asset('assets/icons/activity.svg') }}" class="size-4 text-zinc-600 injectable" alt="">
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+573</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-red-500">
                <img src="{{ asset('assets/icons/trending-up.svg') }}" class="size-3 rotate-180 injectable" alt="">
                -201 since last hour
            </p>
        </div>
    </div>

    <!-- Lower section: Recent activity + Recent sales -->
    <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-7">

        <!-- Recent Sales table (4 cols) -->
        <div class="col-span-1 rounded-lg border border-zinc-200 bg-white lg:col-span-4">
            <div class="border-b border-zinc-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-zinc-900">Recent Sales</h2>
                <p class="mt-0.5 text-xs text-zinc-500">You made 265 sales this month.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100">
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Customer</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-400">Date</th>
                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-zinc-400">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ([
                            ['name' => 'Olivia Martin',  'email' => 'olivia@email.com',  'amount' => '$1,999.00', 'status' => 'Success',  'date' => 'Mar 12'],
                            ['name' => 'Jackson Lee',    'email' => 'jackson@email.com', 'amount' => '$39.00',    'status' => 'Pending',   'date' => 'Mar 12'],
                            ['name' => 'Isabella Nguyen','email' => 'isa@email.com',     'amount' => '$299.00',   'status' => 'Success',   'date' => 'Mar 11'],
                            ['name' => 'William Kim',    'email' => 'will@email.com',    'amount' => '$99.00',    'status' => 'Failed',    'date' => 'Mar 11'],
                            ['name' => 'Sofia Davis',    'email' => 'sofia@email.com',   'amount' => '$39.00',    'status' => 'Success',   'date' => 'Mar 10'],
                        ] as $sale)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-[10px] font-semibold uppercase text-white">
                                        {{ substr($sale['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-900">{{ $sale['name'] }}</p>
                                        <p class="text-xs text-zinc-500">{{ $sale['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                @if($sale['status'] === 'Success')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Success</span>
                                @elseif($sale['status'] === 'Pending')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Pending</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700">Failed</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-zinc-500">{{ $sale['date'] }}</td>
                            <td class="px-5 py-3 text-right font-medium text-zinc-900">{{ $sale['amount'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent activity feed (3 cols) -->
        <div class="col-span-1 rounded-lg border border-zinc-200 bg-white lg:col-span-3">
            <div class="border-b border-zinc-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-zinc-900">Recent Activity</h2>
                <p class="mt-0.5 text-xs text-zinc-500">Latest system events.</p>
            </div>
            <ul class="divide-y divide-zinc-100">
                @foreach ([
                    ['icon' => 'user',    'text' => 'New user registered',          'sub' => 'john.doe@example.com',  'time' => '2m ago'],
                    ['icon' => 'order',   'text' => 'Order #4921 placed',            'sub' => '$249.00 — 3 items',      'time' => '14m ago'],
                    ['icon' => 'payment', 'text' => 'Payment received',             'sub' => '$1,200 from Stripe',     'time' => '1h ago'],
                    ['icon' => 'alert',   'text' => 'Server CPU spike detected',    'sub' => '92% — node-prod-02',     'time' => '2h ago'],
                    ['icon' => 'user',    'text' => 'User profile updated',         'sub' => 'alice@example.com',      'time' => '3h ago'],
                    ['icon' => 'order',   'text' => 'Order #4920 shipped',          'sub' => 'Tracking: 1Z999AA10',    'time' => '5h ago'],
                ] as $event)
                <li class="flex items-start gap-3 px-5 py-3 hover:bg-zinc-50 transition-colors">
                    <div class="mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full
                        {{ $event['icon'] === 'alert' ? 'bg-red-50' : 'bg-zinc-100' }}">
                        @if($event['icon'] === 'user')
                            <img src="{{ asset('assets/icons/profile.svg') }}" class="size-3.5 text-zinc-600 injectable" alt="">
                        @elseif($event['icon'] === 'order')
                            <img src="{{ asset('assets/icons/orders.svg') }}" class="size-3.5 text-zinc-600 injectable" alt="">
                        @elseif($event['icon'] === 'payment')
                            <img src="{{ asset('assets/icons/credit-card.svg') }}" class="size-3.5 text-zinc-600 injectable" alt="">
                        @else
                            <img src="{{ asset('assets/icons/warning.svg') }}" class="size-3.5 text-red-500 injectable" alt="">
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-zinc-900">{{ $event['text'] }}</p>
                        <p class="text-xs text-zinc-500 truncate">{{ $event['sub'] }}</p>
                    </div>
                    <span class="shrink-0 text-xs text-zinc-400">{{ $event['time'] }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Quick actions bar -->
    <div class="mt-4 flex flex-wrap gap-2">
        <button class="inline-flex items-center gap-2 rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 transition-colors">
            <img src="{{ asset('assets/icons/arrow-right.svg') }}" class="size-4 injectable" alt="">
            New Report
        </button>
        <button class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <img src="{{ asset('assets/icons/download.svg') }}" class="size-4 injectable" alt="">
            Export CSV
        </button>
        <button class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <img src="{{ asset('assets/icons/settings.svg') }}" class="size-4 injectable" alt="">
            Settings
        </button>
    </div>

</x-admin-layout>
