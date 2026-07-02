@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'border-primary-200 bg-primary-50 text-primary-900',
        'error' => 'border-accent-200 bg-accent-50 text-accent-700',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-md border px-4 py-3 text-sm '.($styles[$type] ?? $styles['success'])]) }}>
    {{ $slot }}
</div>
