<x-public-layout title="News &amp; Articles" description="Latest news and articles from NPI University of Bangladesh.">
    <x-public.page-header title="News &amp; Articles" subtitle="Updates, stories and announcements from across the university." />

    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        @if ($posts->isEmpty())
            <x-public.empty message="No news has been published yet." />
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $i => $post)
                    <x-public.reveal :delay="($i % 3) * 100">
                        <article class="group flex h-full flex-col overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <a href="{{ route('posts.show', $post) }}" class="block aspect-[16/10] overflow-hidden">
                                <x-public.thumb :src="$post->featuredImageUrl()" :alt="$post->title" />
                            </a>
                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    @if ($post->category)
                                        <span class="font-semibold uppercase tracking-wide text-accent-600">{{ $post->category->name }}</span>
                                        <span>·</span>
                                    @endif
                                    <span>{{ optional($post->published_at)->format('M j, Y') }}</span>
                                </div>
                                <h2 class="mt-3 font-display text-xl font-semibold leading-snug text-ink-900">
                                    <a href="{{ route('posts.show', $post) }}" class="transition group-hover:text-accent-600">{{ $post->title }}</a>
                                </h2>
                                @if ($post->excerpt)
                                    <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
                                @endif
                            </div>
                        </article>
                    </x-public.reveal>
                @endforeach
            </div>

            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </div>
</x-public-layout>
