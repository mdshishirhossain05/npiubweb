@props(['href' => null])

@php
    $classes = 'group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</div>
@endif
