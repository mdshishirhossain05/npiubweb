@props(['value', 'label'])

<div class="group text-center">
    <div class="font-display text-4xl font-semibold text-white sm:text-5xl">
        <span class="bg-gradient-to-b from-white to-primary-200 bg-clip-text text-transparent">{{ $value }}</span>
    </div>
    <div class="mx-auto mt-2 h-0.5 w-8 rounded bg-gold-500 transition-all group-hover:w-14"></div>
    <div class="mt-2 text-xs font-semibold uppercase tracking-[0.15em] text-primary-100/80">{{ $label }}</div>
</div>
