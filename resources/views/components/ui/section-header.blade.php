@props(['title', 'kicker' => null, 'subtitle' => null, 'align' => 'left', 'invert' => false])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }} mb-10">
    @if ($kicker)
        <span class="kicker {{ $invert ? '!text-gold-300' : '' }} {{ $align === 'center' ? 'justify-center' : '' }}">{{ $kicker }}</span>
    @endif
    <h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl {{ $invert ? 'text-white' : 'text-ink-700' }}">
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p class="mt-4 text-base leading-relaxed {{ $invert ? 'text-primary-100' : 'text-slate-600' }}">{{ $subtitle }}</p>
    @endif
</div>
