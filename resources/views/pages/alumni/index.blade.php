<x-layouts.app :title="'Alumni — '.config('app.name')" description="NPI University of Bangladesh alumni network.">
    <x-ui.page-hero title="Alumni" eyebrow="Our Graduates" :breadcrumbs="[['label' => 'Alumni']]"
        intro="Meet the graduates carrying the NPIUB name into the world." />

    <section class="mx-auto max-w-7xl px-4 py-14 lg:px-6 lg:py-20">
        @if ($alumni->isNotEmpty())
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($alumni as $person)
                    <a href="{{ url('/alumni/'.$person->slug) }}" class="group block">
                        <x-ui.image-frame :src="$person->getFirstMediaUrl('photo', 'thumb') ?: null" :alt="$person->name" ratio="aspect-4/5" :grayscale="true" />
                        <div class="mt-4">
                            <h3 class="font-semibold tracking-tight text-ink-900">{{ $person->name }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $person->current_position ?: 'Alumnus' }}</p>
                            @if ($person->batch)<p class="mt-0.5 text-xs text-slate-400">Batch {{ $person->batch }}</p>@endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12">{{ $alumni->links() }}</div>
        @else
            <p class="text-center text-slate-500">Alumni profiles coming soon.</p>
        @endif
    </section>
</x-layouts.app>
