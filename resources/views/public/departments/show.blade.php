<x-public-layout :title="$department->name" description="Programmes and faculty of the {{ $department->name }} at NPI University of Bangladesh.">
    <x-public.page-header :title="$department->name" :subtitle="$department->short_name" />

    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($department->description)
            <div class="leading-relaxed text-slate-700">
                {!! nl2br(e($department->description)) !!}
            </div>
        @endif

        {{-- Programmes --}}
        <section class="mt-12">
            <h2 class="text-xl font-bold text-slate-900">Programmes</h2>
            @if ($department->programs->isEmpty())
                <x-public.empty class="mt-6" message="No programmes listed for this department yet." />
            @else
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    @foreach ($department->programs as $program)
                        <div class="rounded-xl border border-slate-200 bg-white p-5">
                            <div class="flex items-center gap-2">
                                @if ($program->level)
                                    <span class="rounded bg-blue-100 px-1.5 py-0.5 text-xs font-semibold text-blue-700">{{ $program->level }}</span>
                                @endif
                                <h3 class="font-semibold text-slate-900">{{ $program->name }}</h3>
                            </div>
                            @if ($program->duration)
                                <p class="mt-1 text-sm text-slate-500">Duration: {{ $program->duration }}</p>
                            @endif
                            @if ($program->description)
                                <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $program->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Faculty --}}
        @if ($department->facultyMembers->isNotEmpty())
            <section class="mt-12">
                <h2 class="text-xl font-bold text-slate-900">Faculty</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($department->facultyMembers as $member)
                        <div class="rounded-xl border border-slate-200 bg-white p-5">
                            <h3 class="font-semibold text-slate-900">{{ $member->name }}</h3>
                            @if ($member->designation)
                                <p class="text-sm text-amber-600">{{ $member->designation }}</p>
                            @endif
                            @if ($member->email)
                                <a href="mailto:{{ $member->email }}" class="mt-2 block text-xs text-slate-500 hover:text-blue-700">{{ $member->email }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('departments.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">&larr; All departments</a>
        </div>
    </div>
</x-public-layout>
