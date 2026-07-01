<x-public-layout :title="$event->title" description="Event at NPI University of Bangladesh.">
    <x-public.page-header :title="$event->title" />

    <article class="mx-auto max-w-3xl px-6 py-16 lg:px-8">
        <dl class="grid gap-4 rounded-lg border border-slate-200 bg-slate-50 p-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Starts</dt>
                <dd class="mt-1 text-sm text-ink-900">{{ optional($event->starts_at)->format('l, F j, Y · g:i A') ?: 'To be announced' }}</dd>
            </div>
            @if ($event->ends_at)
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Ends</dt>
                    <dd class="mt-1 text-sm text-ink-900">{{ $event->ends_at->format('l, F j, Y · g:i A') }}</dd>
                </div>
            @endif
            @if ($event->location)
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Location</dt>
                    <dd class="mt-1 flex items-center gap-1.5 text-sm text-ink-900"><x-public.icon-pin class="h-4 w-4 text-accent-600" /> {{ $event->location }}</dd>
                </div>
            @endif
        </dl>

        @if ($event->description)
            <div class="mt-8 leading-relaxed text-slate-700">
                {!! nl2br(e($event->description)) !!}
            </div>
        @endif

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-ink-700 hover:text-accent-600">&larr; Back to all events</a>
        </div>
    </article>
</x-public-layout>
