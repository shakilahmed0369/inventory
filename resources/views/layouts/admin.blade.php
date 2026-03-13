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
                    <div class="flex size-7 items-center justify-center rounded-md bg-zinc-900 text-white">
                        <img src="{{ asset('assets/icons/brand-logo.svg') }}" class="size-4 injectable" alt="">
                    </div>
                    <span class="text-sm font-semibold tracking-wide text-zinc-900">{{ config('app.name') }}</span>
                </div>

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
                        <img src="{{ asset('assets/icons/menu.svg') }}" class="size-5 injectable" alt="">
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
                            <img src="{{ asset('assets/icons/search.svg') }}" class="size-3.5 injectable" alt="">
                            <span>Search…</span>
                            <kbd class="ml-4 rounded border border-zinc-200 bg-white px-1.5 py-0.5 text-[10px] font-medium text-zinc-500">⌘K</kbd>
                        </div>

                        <!-- Notifications -->
                        <button class="relative rounded-md p-1.5 text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 transition-colors">
                            <img src="{{ asset('assets/icons/bell.svg') }}" class="size-5 injectable" alt="">
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
                                    <img src="{{ asset('assets/icons/profile.svg') }}" class="size-3.5 injectable" alt="">
                                    Profile
                                </a>
                                <a href="#" class="flex items-center gap-2 rounded-md px-3 py-1.5 text-sm text-zinc-700 hover:bg-zinc-100">
                                    <img src="{{ asset('assets/icons/settings.svg') }}" class="size-3.5 injectable" alt="">
                                    Settings
                                </a>
                                <div class="my-1 border-t border-zinc-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-md px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">
                                        <img src="{{ asset('assets/icons/logout.svg') }}" class="size-3.5 injectable" alt="">
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

        <script src="{{ asset('assets/js/svg-inject.min.js') }}"></script>
        <!-- Custom admin JS -->
        <script src="{{ asset('assets/admin.js') }}"></script>

    </body>
</html>
