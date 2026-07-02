<x-layouts.app :title="$page->seoTitle().' — '.config('app.name')" :description="$page->seoDescription()">
    <x-ui.page-hero :title="$page->title" eyebrow="NPI University of Bangladesh"
        :breadcrumbs="[['label' => $page->title]]" />

    <section class="mx-auto max-w-3xl px-4 py-16 lg:py-20">
        <div class="prose prose-slate max-w-none prose-headings:font-display prose-headings:tracking-tight prose-a:text-primary-700">
            {!! $page->content ?: '<p>Content for this page will be published soon.</p>' !!}
        </div>
    </section>
</x-layouts.app>
