@props(['program', 'index' => null])

<a href="{{ url('/departments/'.($program->department?->slug ?? '')) }}"
   class="card-hover group relative flex h-full flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-6 hover:border-primary-300">
    {{-- gradient wash revealed on hover --}}
    <div class="pointer-events-none absolute inset-0 -z-10 bg-gradient-to-br from-primary-50 to-teal-50 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
    <div>
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-teal-500 text-white shadow-lg shadow-primary-500/30">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
        </div>
        <span class="mt-5 block text-xs font-semibold uppercase tracking-wider text-primary-600">{{ $program->level }}</span>
        <h3 class="mt-1.5 text-lg font-semibold leading-snug tracking-tight text-ink-900">{{ $program->name }}</h3>
        @if ($program->department)
            <p class="mt-1 text-sm text-slate-500">{{ $program->department->name }}</p>
        @endif
    </div>
    <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-700">
        Explore
        <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </span>
</a>
