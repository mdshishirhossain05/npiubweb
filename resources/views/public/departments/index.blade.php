<x-public-layout title="Departments" description="Academic departments at NPI University of Bangladesh.">
    <x-public.page-header title="Departments" subtitle="Explore our academic departments and the programmes they offer." />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($departments->isEmpty())
            <x-public.empty message="No departments have been added yet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($departments as $department)
                    <a href="{{ route('departments.show', $department) }}"
                       class="flex flex-col rounded-xl border border-slate-200 bg-white p-6 transition hover:border-blue-300 hover:shadow-md">
                        <h2 class="text-lg font-semibold text-slate-900">{{ $department->name }}</h2>
                        @if ($department->short_name)
                            <p class="text-sm text-slate-500">{{ $department->short_name }}</p>
                        @endif
                        <p class="mt-4 flex gap-4 text-xs text-slate-400">
                            <span>{{ $department->programs_count }} programmes</span>
                            <span>{{ $department->faculty_members_count }} faculty</span>
                        </p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
