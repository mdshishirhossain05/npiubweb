@props(['notice'])

<a href="{{ url('/notices/'.$notice->slug) }}"
   class="group relative flex items-start gap-4 overflow-hidden rounded-xl border border-slate-200 bg-white p-4 pl-5 transition hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
    {{-- left accent --}}
    <span class="absolute inset-y-0 left-0 w-1 {{ $notice->is_important ? 'bg-accent-500' : 'bg-primary-500' }}"></span>

    <div class="flex w-16 flex-none flex-col items-center rounded-lg bg-ink-700 py-2 text-white">
        <span class="font-display text-xl font-semibold leading-none text-gold-300">{{ $notice->notice_date?->format('d') }}</span>
        <span class="mt-0.5 text-[10px] font-semibold uppercase tracking-wider text-primary-100/80">{{ $notice->notice_date?->format('M Y') }}</span>
    </div>
    <div class="min-w-0 flex-1">
        <div class="mb-1.5 flex flex-wrap items-center gap-2">
            <x-ui.badge color="secondary">{{ ucfirst($notice->category) }}</x-ui.badge>
            @if ($notice->is_important)
                <x-ui.badge color="accent">Important</x-ui.badge>
            @endif
        </div>
        <h3 class="line-clamp-2 font-medium text-slate-800 transition group-hover:text-primary-700">{{ $notice->title }}</h3>
    </div>
    <svg class="mt-1 h-5 w-5 flex-none text-slate-300 transition group-hover:translate-x-1 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
</a>
