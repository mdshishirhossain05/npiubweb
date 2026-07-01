<x-public-layout title="Faculty" description="Meet the faculty of NPI University of Bangladesh.">
    <x-public.page-header title="Faculty" subtitle="The teachers and researchers who guide our students." />

    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        @if ($faculty->isEmpty())
            <x-public.empty message="No faculty members have been added yet." />
        @else
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($faculty as $i => $member)
                    <x-public.reveal :delay="($i % 4) * 80">
                        <div class="group h-full overflow-hidden rounded-lg border border-slate-200 bg-white">
                            <div class="aspect-[4/5] overflow-hidden bg-slate-100">
                                @if ($member->photoUrl())
                                    <img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}"
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <span class="font-display text-4xl font-semibold text-slate-300">
                                            {{ \Illuminate\Support\Str::of($member->name)->explode(' ')->map(fn ($p) => \Illuminate\Support\Str::substr($p, 0, 1))->take(2)->implode('') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="border-t border-slate-100 p-5">
                                <h2 class="font-display font-semibold text-ink-900">{{ $member->name }}</h2>
                                @if ($member->designation)
                                    <p class="text-sm font-medium text-accent-600">{{ $member->designation }}</p>
                                @endif
                                @if ($member->department)
                                    <p class="mt-1 text-xs text-slate-500">{{ $member->department->name }}</p>
                                @endif
                                @if ($member->email)
                                    <a href="mailto:{{ $member->email }}" class="mt-3 inline-block text-xs text-slate-500 hover:text-ink-700">{{ $member->email }}</a>
                                @endif
                            </div>
                        </div>
                    </x-public.reveal>
                @endforeach
            </div>
        @endif
    </div>
</x-public-layout>
