<x-layouts.app :title="'News & Events — '.config('app.name')" description="Latest news and stories from NPI University of Bangladesh.">
    <x-ui.page-hero title="News & Events" eyebrow="Campus Life" :breadcrumbs="[['label' => 'News']]"
        intro="Stories, achievements, and happenings across the NPIUB community." />

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-6 lg:py-20">
        @if ($news->isNotEmpty())
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $article)
                    <x-cards.news-card :article="$article" />
                @endforeach
            </div>
            <div class="mt-12">{{ $news->links() }}</div>
        @else
            <p class="text-center text-slate-500">No news yet.</p>
        @endif
    </section>
</x-layouts.app>
