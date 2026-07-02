<x-layouts.app :title="$department->name.' — '.config('app.name')" :description="$department->seoDescription()">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-grid-ink text-white">
        <div class="pointer-events-none absolute -right-20 -top-16 h-96 w-96 rounded-full bg-primary-500/20 blur-3xl"></div>
        <x-brand.motif class="pointer-events-none absolute -bottom-16 right-10 hidden h-80 w-80 text-white/5 lg:block" />
        <div class="relative mx-auto max-w-7xl px-4 py-14">
            <x-ui.breadcrumbs :light="true" :items="[
                ['label' => 'Academics'],
                ['label' => $department->name],
            ]" />
            <span class="kicker mt-6 !text-gold-300">Department</span>
            <h1 class="mt-3 max-w-3xl font-display text-4xl font-semibold sm:text-5xl">{{ $department->name }}</h1>
            @if ($department->summary)
                <p class="mt-4 max-w-2xl text-lg text-primary-100">{{ $department->summary }}</p>
            @endif
            <div class="mt-8 flex flex-wrap gap-8 border-t border-white/10 pt-6 text-sm">
                <div><span class="font-display text-2xl font-semibold text-gold-300">{{ $faculty->count() }}</span><span class="ml-2 text-primary-100/80">Faculty</span></div>
                <div><span class="font-display text-2xl font-semibold text-gold-300">{{ $programs->count() }}</span><span class="ml-2 text-primary-100/80">Programs</span></div>
                @if ($department->established_year)
                    <div><span class="font-display text-2xl font-semibold text-gold-300">{{ $department->established_year }}</span><span class="ml-2 text-primary-100/80">Established</span></div>
                @endif
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl gap-12 px-4 py-16 lg:grid lg:grid-cols-3">
        {{-- Main --}}
        <div class="lg:col-span-2">
            <x-ui.section-header kicker="About the Department" title="Overview" />
            <div class="prose prose-slate max-w-none prose-headings:font-display">
                {!! $department->overview ?: '<p>Department overview will be published soon.</p>' !!}
            </div>

            @if ($faculty->isNotEmpty())
                <div class="mt-14">
                    <x-ui.section-header kicker="Our People" title="Faculty Members" />
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($faculty as $person)
                            <x-cards.faculty-card :person="$person" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="mt-14 space-y-6 lg:mt-0">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-ink-700 px-6 py-4">
                    <h3 class="font-display text-lg font-semibold text-white">Programs Offered</h3>
                </div>
                <ul class="divide-y divide-slate-100">
                    @forelse ($programs as $program)
                        <li class="flex items-center gap-3 px-6 py-3.5 text-sm text-slate-700">
                            <span class="flex h-7 w-7 flex-none items-center justify-center rounded-full bg-primary-50 text-primary-700"><span class="h-1.5 w-1.5 rounded-full bg-primary-600"></span></span>
                            {{ $program->name }}
                        </li>
                    @empty
                        <li class="px-6 py-4 text-sm text-slate-500">Programs coming soon.</li>
                    @endforelse
                </ul>
                <div class="p-4">
                    <x-ui.button href="{{ url('/admissions') }}" class="w-full">Apply to this department</x-ui.button>
                </div>
            </div>

            <div class="rounded-2xl bg-gradient-to-br from-gold-500 to-gold-600 p-6 text-ink-800">
                <h3 class="font-display text-lg font-semibold">Have questions?</h3>
                <p class="mt-1 text-sm text-ink-800/80">Our admissions team is here to help you choose the right path.</p>
                <x-ui.button href="{{ url('/contact') }}" variant="white" class="mt-4">Contact us</x-ui.button>
            </div>
        </aside>
    </div>
</x-layouts.app>
