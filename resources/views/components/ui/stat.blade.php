@props(['value', 'label', 'suffix' => '', 'count' => false])

<div>
    <div class="font-display text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl">
        @if ($count)
            <span x-data="counter({{ (int) $value }})" x-text="value.toLocaleString()">{{ number_format((int) $value) }}</span><span>{{ $suffix }}</span>
        @else
            {{ $value }}{{ $suffix }}
        @endif
    </div>
    <div class="mt-2 text-sm text-slate-500">{{ $label }}</div>
</div>
