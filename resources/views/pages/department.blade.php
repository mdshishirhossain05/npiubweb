<x-layouts.app :title="$department->name.' — '.config('app.name')" :description="$department->seoDescription()">
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-700 to-secondary-700 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12">
            <x-ui.breadcrumbs :light="true" :items="[
                ['label' => 'Academics'],
                ['label' => $department->name],
            ]" />
            <h1 class="mt-4 text-3xl font-extrabold sm:text-4xl">{{ $department->name }}</h1>
            @if ($department->summary)
                <p class="mt-3 max-w-2xl text-primary-50">{{ $department->summary }}</p>
            @endif
        </div>
    </section>

    <div class="mx-auto max-w-7xl gap-10 px-4 py-12 lg:grid lg:grid-cols-3">
        {{-- Main --}}
        <div class="lg:col-span-2">
            <x-ui.section-header title="Overview" />
            <div class="prose prose-slate max-w-none">
                {!! $department->overview ?: '<p>Department overview will be published soon.</p>' !!}
            </div>

            @if ($faculty->isNotEmpty())
                <div class="mt-12">
                    <x-ui.section-header title="Faculty Members" />
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($faculty as $person)
                            <x-cards.faculty-card :person="$person" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="mt-12 lg:mt-0">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-slate-900">Programs Offered</h3>
                <ul class="mt-4 space-y-2">
                    @forelse ($programs as $program)
                        <li class="flex items-center gap-2 text-sm text-slate-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                            {{ $program->name }}
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">Programs coming soon.</li>
                    @endforelse
                </ul>
                <x-ui.button href="{{ url('/admissions') }}" class="mt-6 w-full">Apply to this department</x-ui.button>
            </div>

            <div class="mt-6 rounded-xl bg-primary-50 p-6">
                <h3 class="font-semibold text-primary-900">Quick Facts</h3>
                <dl class="mt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Faculty</dt><dd class="font-medium text-slate-800">{{ $faculty->count() }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Programs</dt><dd class="font-medium text-slate-800">{{ $programs->count() }}</dd></div>
                    @if ($department->established_year)
                        <div class="flex justify-between"><dt class="text-slate-500">Established</dt><dd class="font-medium text-slate-800">{{ $department->established_year }}</dd></div>
                    @endif
                </dl>
            </div>
        </aside>
    </div>
</x-layouts.app>
