@props(['program', 'index' => null])

<a href="{{ url('/departments/'.($program->department?->slug ?? '')) }}"
   class="group relative flex flex-col justify-between border border-slate-200 p-7 transition hover:border-ink-900 hover:bg-ink-900">
    <div>
        @if ($index)
            <span class="font-display text-sm font-medium text-slate-400 transition group-hover:text-white/50">{{ str_pad((string) $index, 2, '0', STR_PAD_LEFT) }}</span>
        @endif
        <span class="mt-4 block text-xs uppercase tracking-wider text-primary-700 transition group-hover:text-primary-300">{{ $program->level }}</span>
        <h3 class="mt-2 text-xl font-semibold leading-snug tracking-tight text-ink-900 transition group-hover:text-white">{{ $program->name }}</h3>
        @if ($program->department)
            <p class="mt-1 text-sm text-slate-500 transition group-hover:text-white/60">{{ $program->department->name }}</p>
        @endif
    </div>
    <span class="mt-8 inline-flex items-center gap-1.5 text-sm font-medium text-ink-900 transition group-hover:text-white">
        Explore
        <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </span>
</a>
