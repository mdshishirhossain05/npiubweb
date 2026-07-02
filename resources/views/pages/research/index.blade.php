<x-layouts.app :title="'Research & Publications — '.config('app.name')" description="Research and publications from NPI University of Bangladesh.">
    <x-ui.page-hero title="Research & Publications" eyebrow="Scholarship" :breadcrumbs="[['label' => 'Research']]"
        intro="Papers, projects, and scholarly work from our faculty and students." />

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-6 lg:py-20">
        @if ($items->isNotEmpty())
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <a href="{{ url('/research/'.$item->slug) }}" class="group block">
                        <x-ui.image-frame :src="$item->getFirstMediaUrl('cover', 'thumb') ?: null" :alt="$item->title" ratio="aspect-16/10" />
                        <div class="mt-4">
                            <p class="text-xs uppercase tracking-wider text-slate-400">{{ $item->published_at?->format('M d, Y') }}</p>
                            <h3 class="mt-1 text-lg font-semibold leading-snug tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $item->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12">{{ $items->links() }}</div>
        @else
            <p class="text-center text-slate-500">No publications yet.</p>
        @endif
    </section>
</x-layouts.app>
