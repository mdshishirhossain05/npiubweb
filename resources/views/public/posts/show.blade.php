<x-public-layout :title="$post->meta_title ?: $post->title" :description="$post->meta_description ?: $post->excerpt">
    <x-public.page-header :title="$post->title" />

    <article class="mx-auto max-w-3xl px-6 py-16 lg:px-8">
        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
            @if ($post->category)
                <span class="font-semibold uppercase tracking-wide text-brass-600">{{ $post->category->name }}</span>
                <span>·</span>
            @endif
            <span>{{ optional($post->published_at)->format('F j, Y') }}</span>
        </div>

        @if ($post->featuredImageUrl())
            <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}"
                 class="mt-6 aspect-[16/9] w-full rounded-lg object-cover">
        @endif

        @if ($post->excerpt)
            <p class="mt-8 font-display text-xl leading-relaxed text-navy-900">{{ $post->excerpt }}</p>
        @endif

        <div class="mt-6 leading-relaxed text-slate-700">
            {!! nl2br(e($post->body)) !!}
        </div>

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-navy-700 hover:text-brass-600">&larr; Back to all news</a>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="border-t border-slate-200 bg-slate-50">
            <div class="mx-auto max-w-7xl px-6 py-14 lg:px-8">
                <h2 class="font-display text-xl font-bold text-navy-900">Related news</h2>
                <div class="mt-6 grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <a href="{{ route('posts.show', $item) }}" class="block aspect-[16/10] overflow-hidden">
                                <x-public.thumb :src="$item->featuredImageUrl()" :alt="$item->title" />
                            </a>
                            <div class="p-5">
                                <h3 class="font-display font-semibold text-navy-900 group-hover:text-brass-600">{{ $item->title }}</h3>
                                <p class="mt-2 text-xs text-slate-400">{{ optional($item->published_at)->format('M j, Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-public-layout>
