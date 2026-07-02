<x-layouts.app :title="$article->seoTitle().' — '.config('app.name')" :description="$article->seoDescription()">
    <article class="mx-auto max-w-3xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'News', 'url' => url('/news')], ['label' => $article->title]]" />

        <div class="mt-8 flex items-center gap-3 text-sm text-slate-500">
            <span class="capitalize text-primary-700">{{ $article->category }}</span>
            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
            <span>{{ $article->published_at?->format('F d, Y') }}</span>
        </div>

        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl lg:text-5xl">{{ $article->title }}</h1>

        @php $cover = $article->getFirstMediaUrl('cover'); @endphp
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $article->title }}" class="mt-8 w-full rounded-lg object-cover">
        @endif

        <div class="prose prose-lg prose-slate mt-8 max-w-none prose-headings:font-display prose-a:text-primary-700">
            {!! $article->content !!}
        </div>

        @if ($article->author_name)
            <div class="mt-10 flex items-center gap-3 border-t border-slate-200 pt-6">
                <div>
                    <p class="text-sm font-semibold text-ink-900">{{ $article->author_name }}</p>
                    @if ($article->author_info)<p class="text-sm text-slate-500">{{ $article->author_info }}</p>@endif
                </div>
            </div>
        @endif

        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-slate-200 pt-10">
                <h2 class="mb-6 text-lg font-semibold tracking-tight text-ink-900">Related stories</h2>
                <div class="grid gap-8 sm:grid-cols-3">
                    @foreach ($related as $article)
                        <x-cards.news-card :article="$article" />
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</x-layouts.app>
