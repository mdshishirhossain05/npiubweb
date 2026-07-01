@props([
    'eyebrow' => null,
    'title',
    'link' => null,
    'linkLabel' => 'View all',
])

<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        @if ($eyebrow)
            <p class="text-sm font-semibold uppercase tracking-widest text-amber-600">{{ $eyebrow }}</p>
        @endif
        <h2 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h2>
    </div>
    @if ($link)
        <a href="{{ $link }}"
           class="group inline-flex items-center gap-1 text-sm font-semibold text-blue-700 hover:text-blue-900">
            {{ $linkLabel }}
            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
        </a>
    @endif
</div>
