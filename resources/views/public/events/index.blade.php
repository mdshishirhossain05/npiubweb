<x-public-layout title="Events" description="Upcoming and past events at NPI University of Bangladesh.">
    <x-public.page-header title="Events" subtitle="What's happening across the university." />

    <div class="mx-auto max-w-5xl px-6 py-16 lg:px-8">
        <section>
            <h2 class="font-display text-2xl font-bold text-ink-900">Upcoming</h2>
            @if ($upcoming->isEmpty())
                <x-public.empty class="mt-6" message="No upcoming events scheduled." />
            @else
                <div class="mt-6 space-y-4">
                    @foreach ($upcoming as $event)
                        <a href="{{ route('events.show', $event) }}"
                           class="flex items-center gap-5 rounded-lg border border-slate-200 bg-white p-5 transition hover:border-accent-500/60">
                            <div class="grid h-16 w-16 shrink-0 place-items-center rounded-md bg-ink-900 text-center text-white">
                                <span class="font-display text-xl font-bold leading-none">{{ optional($event->starts_at)->format('j') }}</span>
                                <span class="text-[10px] uppercase tracking-wide text-ink-50/70">{{ optional($event->starts_at)->format('M') }}</span>
                            </div>
                            <div>
                                <h3 class="font-display font-semibold text-ink-900">{{ $event->title }}</h3>
                                <p class="mt-1 flex items-center gap-1.5 text-sm text-slate-500">
                                    {{ optional($event->starts_at)->format('l, M j · g:i A') }}
                                    @if ($event->location)
                                        <span>·</span>
                                        <x-public.icon-pin class="h-3.5 w-3.5" /> {{ $event->location }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        @if ($past->isNotEmpty())
            <section class="mt-12">
                <h2 class="font-display text-2xl font-bold text-ink-900">Past events</h2>
                <ul class="mt-6 divide-y divide-slate-200 rounded-lg border border-slate-200 bg-white">
                    @foreach ($past as $event)
                        <li class="flex items-center justify-between gap-4 p-4">
                            <a href="{{ route('events.show', $event) }}" class="font-medium text-ink-900 hover:text-accent-600">{{ $event->title }}</a>
                            <span class="shrink-0 text-xs text-slate-400">{{ optional($event->starts_at)->format('M j, Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</x-public-layout>
