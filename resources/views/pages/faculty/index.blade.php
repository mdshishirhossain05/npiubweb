<x-layouts.app :title="'Faculty & Staff — '.config('app.name')" description="Meet the faculty and staff of NPI University of Bangladesh.">
    <x-ui.page-hero title="Faculty & Staff" eyebrow="Our People" :breadcrumbs="[['label' => 'Faculty']]"
        intro="Experienced educators and researchers dedicated to student success." />

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-6 lg:py-16">
        <div class="mb-10 flex flex-wrap items-center gap-2">
            <a href="{{ url('/faculty') }}" class="rounded-full border px-3.5 py-1.5 text-sm transition {{ ! request('department') ? 'border-ink-900 bg-ink-900 text-white' : 'border-slate-300 text-slate-600 hover:border-ink-900' }}">All Departments</a>
            @foreach ($departments as $dept)
                <a href="{{ url('/faculty?department='.$dept->slug) }}" class="rounded-full border px-3.5 py-1.5 text-sm transition {{ request('department') === $dept->slug ? 'border-ink-900 bg-ink-900 text-white' : 'border-slate-300 text-slate-600 hover:border-ink-900' }}">{{ $dept->short_name ?: $dept->name }}</a>
            @endforeach
        </div>

        @if ($faculty->isNotEmpty())
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($faculty as $person)
                    <x-cards.faculty-card :person="$person" />
                @endforeach
            </div>
            <div class="mt-12">{{ $faculty->links() }}</div>
        @else
            <p class="text-center text-slate-500">No faculty found for this filter.</p>
        @endif
    </section>
</x-layouts.app>
