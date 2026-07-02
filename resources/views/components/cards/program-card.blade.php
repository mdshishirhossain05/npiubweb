@props(['program'])

<a href="{{ url('/departments/'.($program->department?->slug ?? '')) }}"
   class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-primary-200 hover:shadow-xl">
    {{-- top accent bar reveals on hover --}}
    <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-primary-600 to-gold-500 transition-transform duration-300 group-hover:scale-x-100"></span>

    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-primary-50 text-primary-700 ring-1 ring-primary-100 transition group-hover:bg-primary-600 group-hover:text-white">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z M12 14v7 M5 11v4c0 1 3 3 7 3s7-2 7-3v-4"/></svg>
    </div>

    <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ ucfirst($program->level) }}</span>
    <h3 class="mt-1 font-display text-lg font-semibold leading-snug text-ink-700 transition group-hover:text-primary-700">{{ $program->name }}</h3>
    @if ($program->department)
        <p class="mt-1 text-sm text-slate-500">{{ $program->department->name }}</p>
    @endif

    <span class="mt-auto pt-4 text-sm font-semibold text-primary-700 opacity-0 transition group-hover:opacity-100">Explore →</span>
</a>
