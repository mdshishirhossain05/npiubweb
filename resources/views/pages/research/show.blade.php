<x-layouts.app :title="$article->seoTitle().' — '.config('app.name')" :description="$article->seoDescription()">
    <article class="mx-auto max-w-3xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Research', 'url' => url('/research')], ['label' => $article->title]]" />
        <p class="mt-8 text-sm text-slate-500">{{ $article->published_at?->format('F d, Y') }}</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">{{ $article->title }}</h1>
        @if ($article->author_name)<p class="mt-2 text-slate-600">By {{ $article->author_name }}</p>@endif

        @php $cover = $article->getFirstMediaUrl('cover'); @endphp
        @if ($cover)<img src="{{ $cover }}" alt="{{ $article->title }}" class="mt-8 w-full rounded-lg object-cover">@endif

        <div class="prose prose-lg prose-slate mt-8 max-w-none prose-a:text-primary-700">{!! $article->content !!}</div>
    </article>
</x-layouts.app>
