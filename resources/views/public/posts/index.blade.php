<x-public-layout title="News &amp; Articles" description="Latest news and articles from NPI University of Bangladesh.">
    <x-public.page-header title="News &amp; Articles" subtitle="Updates, stories and announcements from across the university." />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($posts->isEmpty())
            <x-public.empty message="No news has been published yet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                        @if ($post->category)
                            <span class="text-xs font-semibold uppercase tracking-wide text-amber-600">{{ $post->category->name }}</span>
                        @endif
                        <h2 class="mt-1 text-lg font-semibold text-slate-900">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-700">{{ $post->title }}</a>
                        </h2>
                        @if ($post->excerpt)
                            <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $post->excerpt }}</p>
                        @endif
                        <p class="mt-4 text-xs text-slate-400">{{ optional($post->published_at)->format('M j, Y') }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</x-public-layout>
