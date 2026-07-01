<x-public-layout title="Departments" description="Academic departments at NPI University of Bangladesh.">
    <x-public.page-header title="Departments" subtitle="Explore our academic departments and the programmes they offer." />

    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        @if ($departments->isEmpty())
            <x-public.empty message="No departments have been added yet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($departments as $i => $department)
                    <x-public.reveal :delay="($i % 3) * 100">
                        <a href="{{ route('departments.show', $department) }}"
                           class="group flex h-full flex-col rounded-lg border border-slate-200 bg-white p-6 transition hover:border-brass-500/60">
                            <span class="grid h-12 w-12 place-items-center rounded-full border border-navy-900/15 font-display text-sm font-bold text-navy-800">
                                {{ \Illuminate\Support\Str::substr($department->short_name ?: $department->name, 0, 2) }}
                            </span>
                            <h2 class="mt-4 font-display text-lg font-semibold text-navy-900 group-hover:text-brass-600">{{ $department->name }}</h2>
                            @if ($department->short_name)
                                <p class="text-sm text-slate-500">{{ $department->short_name }}</p>
                            @endif
                            <p class="mt-4 flex gap-4 border-t border-slate-100 pt-4 text-xs text-slate-500">
                                <span>{{ $department->programs_count }} programmes</span>
                                <span>{{ $department->faculty_members_count }} faculty</span>
                            </p>
                        </a>
                    </x-public.reveal>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
