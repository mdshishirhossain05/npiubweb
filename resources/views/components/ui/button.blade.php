@props([
    'variant' => 'primary',
    'href' => null,
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-60';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variants = [
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus-visible:ring-primary-500',
        'secondary' => 'bg-secondary-600 text-white hover:bg-secondary-700 focus-visible:ring-secondary-500',
        'accent' => 'bg-accent-600 text-white hover:bg-accent-700 focus-visible:ring-accent-500',
        'outline' => 'border border-primary-600 text-primary-700 hover:bg-primary-50 focus-visible:ring-primary-500',
        'ghost' => 'text-primary-700 hover:bg-primary-50 focus-visible:ring-primary-500',
        'white' => 'bg-white text-primary-700 hover:bg-primary-50 focus-visible:ring-white',
    ];

    $classes = implode(' ', [$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary']]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>{{ $slot }}</button>
@endif
