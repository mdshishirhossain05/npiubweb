@props([
    'value',
    'label',
    'suffix' => '+',
])

<div class="text-center">
    <div class="font-display text-4xl font-bold text-navy-900 sm:text-5xl">
        {{ number_format((int) $value) }}<span class="text-brass-500">{{ $suffix }}</span>
    </div>
    <div class="mt-2 text-sm font-medium uppercase tracking-wider text-slate-500">{{ $label }}</div>
</div>
