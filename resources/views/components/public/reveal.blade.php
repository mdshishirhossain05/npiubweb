@props(['delay' => 0])

{{-- Wraps content so it animates into view once, when scrolled to. --}}
<div
    x-data="{ shown: false }"
    x-intersect.once.margin.-80px="shown = true"
    :class="shown && 'is-visible'"
    style="transition-delay: {{ (int) $delay }}ms"
    {{ $attributes->merge(['class' => 'reveal']) }}
>
    {{ $slot }}
</div>
