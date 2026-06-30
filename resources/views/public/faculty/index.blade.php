<x-public-layout title="Faculty" description="Meet the faculty of NPI University of Bangladesh.">
    <x-public.page-header title="Faculty" subtitle="The teachers and researchers behind the university." />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($faculty->isEmpty())
            <x-public.empty message="No faculty members have been added yet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($faculty as $member)
                    <div class="rounded-xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                        <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-blue-100 text-2xl font-bold text-blue-700">
                            {{ \Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($p) => \Illuminate\Support\Str::substr($p, 0, 1))->take(2)->implode('') }}
                        </div>
                        <h2 class="mt-4 font-semibold text-slate-900">{{ $member->name }}</h2>
                        @if ($member->designation)
                            <p class="text-sm text-amber-600">{{ $member->designation }}</p>
                        @endif
                        @if ($member->department)
                            <p class="text-xs text-slate-400">{{ $member->department->name }}</p>
                        @endif
                        @if ($member->email)
                            <a href="mailto:{{ $member->email }}" class="mt-3 inline-block text-xs text-slate-500 hover:text-blue-700">{{ $member->email }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
