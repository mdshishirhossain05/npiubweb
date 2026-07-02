@props(['article'])

@php
    $cover = $article->getFirstMediaUrl('cover', 'thumb') ?: $article->getFirstMediaUrl('cover');
@endphp

<a href="{{ url('/news/'.$article->slug) }}"
   class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="relative aspect-video w-full overflow-hidden bg-slate-100">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-secondary-100 to-primary-100 text-primary-300">
                <x-brand.motif class="h-16 w-16" />
            </div>
        @endif
        <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-xs font-semibold text-primary-700 shadow-sm">{{ ucfirst($article->category) }}</span>
    </div>
    <div class="flex flex-1 flex-col p-5">
        <span class="text-xs font-medium uppercase tracking-wide text-slate-400">{{ $article->published_at?->format('M d, Y') }}</span>
        <h3 class="mt-2 line-clamp-2 font-display text-lg font-semibold leading-snug text-ink-700 transition group-hover:text-primary-700">{{ $article->title }}</h3>
        @if ($article->excerpt)
            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $article->excerpt }}</p>
        @endif
        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-primary-700">
            Read more
            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </span>
    </div>
</a>
