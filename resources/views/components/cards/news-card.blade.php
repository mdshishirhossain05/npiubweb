@props(['article'])

@php
    $cover = $article->getFirstMediaUrl('cover', 'thumb') ?: $article->getFirstMediaUrl('cover');
@endphp

<a href="{{ url('/news/'.$article->slug) }}" class="group block">
    <x-ui.image-frame :src="$cover ?: null" :alt="$article->title" ratio="aspect-16/10" />
    <div class="mt-4">
        <div class="flex items-center gap-3 text-xs uppercase tracking-wider text-slate-400">
            <span class="font-medium text-primary-700">{{ $article->category }}</span>
            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
            <span>{{ $article->published_at?->format('M d, Y') }}</span>
        </div>
        <h3 class="mt-2 text-lg font-semibold leading-snug tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $article->title }}</h3>
        @if ($article->excerpt)
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-600">{{ $article->excerpt }}</p>
        @endif
    </div>
</a>
