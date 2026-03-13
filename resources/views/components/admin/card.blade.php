@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-zinc-200 bg-white']) }}>
    <div class="border-b border-zinc-100 px-6 py-5">
        <h2 class="text-base font-semibold text-zinc-900">{{ $title }}</h2>
        @if ($description)
            <p class="mt-1 text-sm text-zinc-500">{{ $description }}</p>
        @endif
    </div>
    <div class="px-6 py-6">
        {{ $slot }}
    </div>
</div>
