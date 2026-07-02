@props(['notice'])

<a href="{{ url('/notices/'.$notice->slug) }}"
   class="flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-4 transition hover:border-primary-300 hover:shadow-sm">
    <div class="flex w-14 flex-none flex-col items-center rounded-md bg-primary-50 py-2 text-primary-700">
        <span class="text-lg font-bold leading-none">{{ $notice->notice_date?->format('d') }}</span>
        <span class="text-xs uppercase">{{ $notice->notice_date?->format('M') }}</span>
    </div>
    <div class="min-w-0">
        <div class="mb-1 flex flex-wrap items-center gap-2">
            <x-ui.badge color="secondary">{{ ucfirst($notice->category) }}</x-ui.badge>
            @if ($notice->is_important)
                <x-ui.badge color="accent">Important</x-ui.badge>
            @endif
        </div>
        <h3 class="line-clamp-2 font-semibold text-slate-800 group-hover:text-primary-700">{{ $notice->title }}</h3>
    </div>
</a>
