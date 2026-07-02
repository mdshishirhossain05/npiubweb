<x-layouts.app :title="'Gallery — '.config('app.name')" description="Photo gallery of NPI University of Bangladesh.">
    <x-ui.page-hero title="Gallery" eyebrow="Campus in Pictures" :breadcrumbs="[['label' => 'Gallery']]"
        intro="Moments from campus life, events, and academic activities." />

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-6 lg:py-20">
        @if ($albums->isNotEmpty())
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    @php $cover = optional($album->images->first())?->getFirstMediaUrl('image', 'thumb'); @endphp
                    <a href="{{ url('/galleries/'.$album->slug) }}" class="group block">
                        <x-ui.image-frame :src="$cover ?: null" :alt="$album->title" ratio="aspect-4/3" />
                        <div class="mt-4 flex items-center justify-between">
                            <h3 class="font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $album->title }}</h3>
                            <span class="text-sm text-slate-400">{{ $album->images_count }} photos</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12">{{ $albums->links() }}</div>
        @else
            <p class="text-center text-slate-500">No albums yet.</p>
        @endif
    </section>
</x-layouts.app>
