@props(['article'])

@php
    $cover = $article->getFirstMediaUrl('cover', 'thumb') ?: $article->getFirstMediaUrl('cover');
@endphp

<x-ui.card href="{{ url('/news/'.$article->slug) }}">
    <div class="aspect-video w-full overflow-hidden bg-slate-100">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-secondary-50 text-secondary-200">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5h16v14H4z M4 15l4-4 4 4 4-5 4 5"/></svg>
            </div>
        @endif
    </div>
    <div class="p-5">
        <div class="mb-2 flex items-center gap-2 text-xs text-slate-500">
            <x-ui.badge color="primary">{{ ucfirst($article->category) }}</x-ui.badge>
            <span>{{ $article->published_at?->format('M d, Y') }}</span>
        </div>
        <h3 class="line-clamp-2 font-semibold text-slate-900 group-hover:text-primary-700">{{ $article->title }}</h3>
        @if ($article->excerpt)
            <p class="mt-2 line-clamp-2 text-sm text-slate-600">{{ $article->excerpt }}</p>
        @endif
    </div>
</x-ui.card>
