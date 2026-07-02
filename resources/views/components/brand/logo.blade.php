@props(['class' => 'h-12 w-auto'])

@php
    // Prefer the official raster/vector logo once uploaded to public/images/;
    // fall back to the placeholder crest until then.
    $logo = collect(['images/logo.svg', 'images/logo.png'])
        ->first(fn ($p) => file_exists(public_path($p)), 'images/logo.svg');
    // If both exist, prefer the real uploaded logo.png over the placeholder svg.
    if (file_exists(public_path('images/logo.png'))) {
        $logo = 'images/logo.png';
    }
@endphp

<img src="{{ asset($logo) }}"
     alt="{{ config('app.name') }}"
     {{ $attributes->merge(['class' => $class]) }}>
