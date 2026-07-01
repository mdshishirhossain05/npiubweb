<x-public-layout :title="$page->meta_title ?: $page->title" :description="$page->meta_description">
    <x-public.page-header :title="$page->title" />

    <article class="mx-auto max-w-3xl px-6 py-16 lg:px-8">
        @if ($page->excerpt)
            <p class="mb-8 font-display text-xl leading-relaxed text-navy-900">{{ $page->excerpt }}</p>
        @endif

        <div class="leading-relaxed text-slate-700">
            {!! nl2br(e($page->body)) !!}
        </div>
    </article>
</x-public-layout>
