@props([
    'eyebrow' => null,
    'title',
    'link' => null,
    'linkLabel' => 'View all',
])

<div class="flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 pb-4">
    <div>
        @if ($eyebrow)
            <p class="mb-1 text-xs font-semibold uppercase tracking-[0.2em] text-accent-600">{{ $eyebrow }}</p>
        @endif
        <h2 class="font-display text-3xl font-bold tracking-tight text-ink-900">{{ $title }}</h2>
    </div>
    @if ($link)
        <a href="{{ $link }}"
           class="text-sm font-semibold text-ink-700 underline-offset-4 hover:text-accent-600 hover:underline">
            {{ $linkLabel }} &rarr;
        </a>
    @endif
</div>
