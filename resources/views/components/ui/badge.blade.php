@props(['color' => 'primary'])

@php
    $colors = [
        'primary' => 'bg-primary-100 text-primary-800',
        'secondary' => 'bg-secondary-100 text-secondary-800',
        'accent' => 'bg-accent-100 text-accent-800',
        'gray' => 'bg-slate-100 text-slate-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold '.($colors[$color] ?? $colors['primary'])]) }}>
    {{ $slot }}
</span>
