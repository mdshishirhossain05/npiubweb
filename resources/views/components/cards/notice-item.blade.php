@props(['notice'])

<a href="{{ url('/notices/'.$notice->slug) }}"
   class="group flex items-baseline gap-5 border-t border-slate-200 py-5 transition first:border-t-0 hover:border-ink-900">
    <div class="w-24 flex-none">
        <div class="font-display text-sm font-semibold tracking-tight text-ink-900">{{ $notice->notice_date?->format('d M') }}</div>
        <div class="text-xs text-slate-400">{{ $notice->notice_date?->format('Y') }}</div>
    </div>
    <div class="min-w-0 flex-1">
        <div class="mb-1 flex items-center gap-2 text-xs uppercase tracking-wider text-slate-400">
            <span>{{ $notice->category }}</span>
            @if ($notice->is_important)
                <span class="font-semibold text-accent-600">• Important</span>
            @endif
        </div>
        <h3 class="line-clamp-2 text-base font-medium text-ink-900 transition group-hover:text-primary-700">{{ $notice->title }}</h3>
    </div>
    <svg class="mt-1 h-4 w-4 flex-none text-slate-300 transition group-hover:translate-x-1 group-hover:text-ink-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
</a>
