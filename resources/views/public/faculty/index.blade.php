<x-public-layout title="Faculty" description="Meet the faculty of NPI University of Bangladesh.">
    <x-public.page-header title="Our Faculty" subtitle="The teachers and researchers behind the university." />

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        @if ($faculty->isEmpty())
            <x-public.empty message="No faculty members have been added yet." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($faculty as $i => $member)
                    <x-public.reveal :delay="($i % 4) * 80">
                        <div class="group h-full overflow-hidden rounded-2xl border border-slate-200 bg-white text-center transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-blue-100 to-slate-100">
                                @if ($member->photoUrl())
                                    <img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-4xl font-bold text-blue-700/40">
                                        {{ \Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($p) => \Illuminate\Support\Str::substr($p, 0, 1))->take(2)->implode('') }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h2 class="font-bold text-slate-900">{{ $member->name }}</h2>
                                @if ($member->designation)
                                    <p class="text-sm font-medium text-amber-600">{{ $member->designation }}</p>
                                @endif
                                @if ($member->department)
                                    <p class="mt-1 text-xs text-slate-400">{{ $member->department->name }}</p>
                                @endif
                                @if ($member->email)
                                    <a href="mailto:{{ $member->email }}" class="mt-3 inline-block text-xs text-slate-500 hover:text-blue-700">{{ $member->email }}</a>
                                @endif
                            </div>
                        </div>
                    </x-public.reveal>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
