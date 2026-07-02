<x-layouts.app :title="$department->name.' — '.config('app.name')" :description="$department->seoDescription()">
    {{-- Hero --}}
    <section class="border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 py-12 lg:px-6 lg:py-16">
            <x-ui.breadcrumbs :items="[['label' => 'Academics'], ['label' => $department->name]]" />
            <span class="eyebrow mt-8">Department</span>
            <h1 class="mt-4 max-w-4xl text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl lg:text-6xl">{{ $department->name }}</h1>
            @if ($department->summary)
                <p class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">{{ $department->summary }}</p>
            @endif
            <div class="mt-10 grid max-w-lg grid-cols-3 divide-x divide-slate-200 border-t border-slate-200 pt-6">
                <div><div class="font-display text-2xl font-semibold text-ink-900">{{ $faculty->count() }}</div><div class="text-sm text-slate-500">Faculty</div></div>
                <div class="pl-6"><div class="font-display text-2xl font-semibold text-ink-900">{{ $programs->count() }}</div><div class="text-sm text-slate-500">Programs</div></div>
                @if ($department->established_year)
                    <div class="pl-6"><div class="font-display text-2xl font-semibold text-ink-900">{{ $department->established_year }}</div><div class="text-sm text-slate-500">Established</div></div>
                @endif
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl gap-12 px-4 py-16 lg:grid lg:grid-cols-12 lg:px-6 lg:py-20">
        {{-- Main --}}
        <div class="lg:col-span-8">
            <span class="eyebrow">Overview</span>
            <div class="prose prose-slate mt-6 max-w-none prose-headings:font-display prose-headings:tracking-tight prose-a:text-primary-700">
                {!! $department->overview ?: '<p>Department overview will be published soon.</p>' !!}
            </div>

            @if ($faculty->isNotEmpty())
                <div class="mt-16">
                    <div class="flex items-end justify-between border-b border-slate-200 pb-5">
                        <h2 class="text-2xl font-semibold tracking-tight text-ink-900 sm:text-3xl">Faculty</h2>
                        <a href="{{ url('/faculty') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800">All staff →</a>
                    </div>
                    <div class="mt-10 grid gap-x-8 gap-y-10 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($faculty as $person)
                            <x-cards.faculty-card :person="$person" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="mt-14 lg:col-span-4 lg:mt-0">
            <div class="lg:sticky lg:top-28">
                <h3 class="border-b border-slate-200 pb-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Programs Offered</h3>
                <ul>
                    @forelse ($programs as $program)
                        <li class="border-b border-slate-200 py-4 text-sm text-ink-900">{{ $program->name }}</li>
                    @empty
                        <li class="py-4 text-sm text-slate-500">Programs coming soon.</li>
                    @endforelse
                </ul>
                <x-ui.button href="{{ url('/admissions') }}" class="mt-6 w-full">Apply to this department</x-ui.button>
                <a href="{{ url('/contact') }}" class="mt-4 block text-center text-sm font-medium text-primary-700 hover:text-primary-800">Have questions? Contact us →</a>
            </div>
        </aside>
    </div>
</x-layouts.app>
