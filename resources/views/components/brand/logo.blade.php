@props(['class' => 'h-12 w-auto'])

@php
    // Prefer the official PNG logo; fall back to an SVG if provided.
    $logo = collect(['images/logo.png', 'images/logo.svg'])
        ->first(fn ($p) => file_exists(public_path($p)), 'images/logo.png');
@endphp

<img src="{{ asset($logo) }}"
     alt="{{ config('app.name') }}"
     {{ $attributes->merge(['class' => $class]) }}>
