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
                    <svg class="size-4 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">$45,231.89</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                +20.1% from last month
            </p>
        </div>

        <!-- Active Users -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Active Users</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <svg class="size-4 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+2,350</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                +180.1% from last month
            </p>
        </div>

        <!-- Sales -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Sales</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <svg class="size-4 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+12,234</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-emerald-600">
                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                +19% from last month
            </p>
        </div>

        <!-- Active Now -->
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500">Active Now</p>
                <div class="flex size-8 items-center justify-center rounded-md bg-zinc-100">
                    <svg class="size-4 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-semibold text-zinc-900">+573</p>
            <p class="mt-1 flex items-center gap-1 text-xs text-red-500">
                <svg class="size-3 rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
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
                            <svg class="size-3.5 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                        @elseif($event['icon'] === 'order')
                            <svg class="size-3.5 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
                        @elseif($event['icon'] === 'payment')
                            <svg class="size-3.5 text-zinc-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                        @else
                            <svg class="size-3.5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
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
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            New Report
        </button>
        <button class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export CSV
        </button>
        <button class="inline-flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            Settings
        </button>
    </div>

</x-admin-layout>
