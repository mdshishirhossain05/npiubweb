@props(['title', 'eyebrow' => null, 'subtitle' => null, 'align' => 'left'])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-3xl' }}">
    @if ($eyebrow)
        <span class="eyebrow {{ $align === 'center' ? 'justify-center' : '' }}">{{ $eyebrow }}</span>
    @endif
    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl md:text-[2.75rem]">
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p class="mt-4 text-lg leading-relaxed text-slate-600">{{ $subtitle }}</p>
    @endif
</div>
