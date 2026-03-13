<div class="border-t border-zinc-200 p-3">
    <div class="flex items-center gap-3 rounded-md px-3 py-2">
        <div
            class="flex size-8 shrink-0 items-center justify-center rounded-full bg-zinc-900 text-xs font-semibold uppercase text-white">
            {{ substr(Auth::user()->name, 0, 2) }}
        </div>
        <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-medium text-zinc-900">{{ Auth::user()->name }}</p>
            <p class="truncate text-xs text-zinc-500">{{ Auth::user()->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Sign out" class="text-zinc-400 hover:text-zinc-900 transition-colors">
                <img src="{{ asset('assets/icons/logout.svg') }}" class="size-4 injectable" alt="">
            </button>
        </form>
    </div>
</div>
