<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }} — Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    },
                },
            }
        </script>

    </head>
    <body class="font-sans antialiased bg-zinc-50 text-zinc-900">

        <div class="flex h-screen overflow-hidden">

            <!-- ── Sidebar ─────────────────────────────────────────── -->
            <!-- Overlay (mobile) -->
            <div
                id="sidebar-overlay"
                class="fixed inset-0 z-20 bg-black/50 lg:hidden hidden"
            ></div>

            <aside
                id="sidebar"
                class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white text-zinc-900 border-r border-zinc-200 transition-transform duration-200 ease-in-out -translate-x-full lg:static lg:translate-x-0"
            >
                <!-- Brand -->
                <div class="flex h-16 shrink-0 items-center gap-3 border-b border-zinc-200 px-6">
                    <div class="flex size-7 items-center justify-center rounded-md bg-zinc-900">
                        <svg class="size-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.644 1.59a.75.75 0 0 1 .712 0l9.75 5.25a.75.75 0 0 1 0 1.32l-9.75 5.25a.75.75 0 0 1-.712 0l-9.75-5.25a.75.75 0 0 1 0-1.32l9.75-5.25Z" />
                            <path d="m3.265 10.602 7.668 4.129a2.25 2.25 0 0 0 2.134 0l7.668-4.13 1.37.739a.75.75 0 0 1 0 1.32l-9.75 5.25a.75.75 0 0 1-.71 0l-9.75-5.25a.75.75 0 0 1 0-1.32l1.37-.738Z" />
                            <path d="m10.933 19.231-7.668-4.13-1.37.739a.75.75 0 0 0 0 1.32l9.75 5.25c.221.12.489.12.71 0l9.75-5.25a.75.75 0 0 0 0-1.32l-1.37-.738-7.668 4.13a2.25 2.25 0 0 1-2.134 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold tracking-wide text-zinc-900">{{ config('app.name') }}</span>
                </div>

                <!-- Navigation -->
                @include('layouts.partials.nav')

                <!-- Sidebar footer -->
                @include('layouts.partials.sidebar')
            </aside>

            <!-- ── Main content area ──────────────────────────────── -->
            <div class="flex flex-1 flex-col overflow-hidden">

                <!-- Navbar -->
                <header class="flex h-16 shrink-0 items-center gap-4 border-b border-zinc-200 bg-white px-6">

                    <!-- Mobile menu toggle -->
                    <button
                        id="sidebar-toggle"
                        class="rounded-md p-1.5 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 lg:hidden"
                    >
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/>
                        </svg>
                    </button>

                    <!-- Breadcrumb / page title -->
                    <div class="flex-1">
                        @isset($heading)
                            <h1 class="text-sm font-semibold text-zinc-900">{{ $heading }}</h1>
                        @endisset
                        @isset($breadcrumbs)
                            <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
                                {{ $breadcrumbs }}
                            </nav>
                        @endisset
                    </div>

                    <!-- Right-side actions -->
                    <div class="flex items-center gap-3">
                        <!-- Search -->
                        <div class="hidden items-center gap-2 rounded-md border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-sm text-zinc-400 sm:flex">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                            </svg>
                            <span>Search…</span>
                            <kbd class="ml-4 rounded border border-zinc-200 bg-white px-1.5 py-0.5 text-[10px] font-medium text-zinc-500">⌘K</kbd>
                        </div>

                        <!-- Notifications -->
                        <button class="relative rounded-md p-1.5 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                            </svg>
                            <span class="absolute right-1 top-1 size-1.5 rounded-full bg-zinc-900"></span>
                        </button>

                        <!-- Avatar dropdown -->
                        <div class="relative">
                            <button id="avatar-btn" class="flex size-8 items-center justify-center rounded-full bg-zinc-900 text-xs font-semibold uppercase text-white">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </button>

                            <div
                                id="avatar-dropdown"
                                class="hidden absolute right-0 top-full mt-2 w-52 origin-top-right rounded-lg border border-zinc-200 bg-white p-1 shadow-lg"
                            >
                                <div class="border-b border-zinc-100 px-3 py-2 mb-1">
                                    <p class="text-sm font-medium text-zinc-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-zinc-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-md px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-100">
                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                                    Profile
                                </a>
                                <a href="#" class="flex items-center gap-2 rounded-md px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-100">
                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Settings
                                </a>
                                <div class="my-1 border-t border-zinc-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-md px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page content -->
                <main class="flex-1 overflow-y-auto px-6 py-6">
                    {{ $slot }}
                </main>
            </div>
        </div>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- Custom admin JS -->
        <script src="{{ asset('assets/admin.js') }}"></script>

    </body>
</html>
