<x-public-layout :title="$post->meta_title ?: $post->title" :description="$post->meta_description ?: $post->excerpt">
    <x-public.page-header :title="$post->title">
    </x-public.page-header>

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
            @if ($post->category)
                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">{{ $post->category->name }}</span>
            @endif
            <span>{{ optional($post->published_at)->format('F j, Y') }}</span>
        </div>

        @if ($post->excerpt)
            <p class="mt-6 text-lg leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
        @endif

        <div class="mt-6 leading-relaxed text-slate-700">
            {!! nl2br(e($post->body)) !!}
        </div>

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">&larr; Back to all news</a>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold text-slate-900">Related news</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('posts.show', $item) }}"
                           class="rounded-xl border border-slate-200 p-5 transition hover:shadow-md">
                            <h3 class="font-semibold text-slate-900">{{ $item->title }}</h3>
                            <p class="mt-2 text-xs text-slate-400">{{ optional($item->published_at)->format('M j, Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-public-layout>
