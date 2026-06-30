<x-public-layout :title="$page->meta_title ?: $page->title" :description="$page->meta_description">
    <x-public.page-header :title="$page->title" />

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($page->excerpt)
            <p class="mb-8 text-lg leading-relaxed text-slate-600">{{ $page->excerpt }}</p>
        @endif

        <div class="leading-relaxed text-slate-700">
            {!! nl2br(e($page->body)) !!}
        </div>
    </article>
</x-public-layout>
