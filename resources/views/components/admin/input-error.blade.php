@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'mt-1.5 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1.5 text-xs text-red-600">
                <img src="{{ asset('assets/icons/circle-info.svg') }}" class="size-3 shrink-0 injectable" alt="">
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
