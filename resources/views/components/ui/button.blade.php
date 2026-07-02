@props([
    'variant' => 'primary',
    'href' => null,
    'size' => 'md',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-md font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:opacity-60';

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variants = [
        // solid green — the single strong accent
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus-visible:ring-primary-500',
        // near-black solid — Swiss neutral emphasis
        'dark' => 'bg-ink-900 text-white hover:bg-ink-700 focus-visible:ring-ink-700',
        // thin outline
        'outline' => 'border border-slate-300 text-ink-900 hover:border-ink-900 focus-visible:ring-slate-400',
        'white' => 'bg-white text-ink-900 hover:bg-slate-100 focus-visible:ring-white',
        // text link with arrow
        'link' => 'px-0 text-primary-700 hover:text-primary-800 focus-visible:ring-primary-500',
    ];

    $classes = implode(' ', [$base, $variant === 'link' ? $sizes['md'] : ($sizes[$size] ?? $sizes['md']), $variants[$variant] ?? $variants['primary']]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>{{ $slot }}</button>
@endif
