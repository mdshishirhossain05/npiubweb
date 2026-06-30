<x-public-layout title="News &amp; Articles" description="Latest news and articles from NPI University of Bangladesh.">
    <x-public.page-header title="News &amp; Articles" subtitle="Updates, stories and announcements from across the university." />

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        @if ($posts->isEmpty())
            <x-public.empty message="No news has been published yet." />
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $i => $post)
                    <x-public.reveal :delay="($i % 3) * 100">
                        <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-xl">
                            <a href="{{ route('posts.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden">
                                @if ($post->featuredImageUrl())
                                    <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-800 to-blue-950 text-3xl font-bold text-white/20">NPIUB</div>
                                @endif
                                @if ($post->category)
                                    <span class="absolute left-4 top-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold text-blue-950">{{ $post->category->name }}</span>
                                @endif
                            </a>
                            <div class="flex flex-1 flex-col p-6">
                                <p class="text-xs font-medium text-slate-400">{{ optional($post->published_at)->format('F j, Y') }}</p>
                                <h2 class="mt-2 text-lg font-bold text-slate-900">
                                    <a href="{{ route('posts.show', $post) }}" class="transition hover:text-blue-700">{{ $post->title }}</a>
                                </h2>
                                @if ($post->excerpt)
                                    <p class="mt-3 line-clamp-3 text-sm text-slate-600">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('posts.show', $post) }}" class="mt-4 inline-flex items-center gap-1 pt-2 text-sm font-semibold text-blue-700">
                                    Read more <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    </x-public.reveal>
                @endforeach
            </div>

            <div class="mt-12">{{ $posts->links() }}</div>
        @endif
    </div>
</x-public-layout>
