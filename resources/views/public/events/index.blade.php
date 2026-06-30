<x-public-layout title="Events" description="Upcoming and past events at NPI University of Bangladesh.">
    <x-public.page-header title="Events" subtitle="What's happening across the university." />

    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <section>
            <h2 class="text-xl font-bold text-slate-900">Upcoming</h2>
            @if ($upcoming->isEmpty())
                <x-public.empty class="mt-6" message="No upcoming events scheduled." />
            @else
                <div class="mt-6 space-y-4">
                    @foreach ($upcoming as $event)
                        <a href="{{ route('events.show', $event) }}"
                           class="flex items-center gap-5 rounded-xl border border-slate-200 bg-white p-5 transition hover:shadow-md">
                            <div class="grid h-16 w-16 shrink-0 place-items-center rounded-lg bg-blue-50 text-center">
                                <span class="text-lg font-bold leading-none text-blue-700">{{ optional($event->starts_at)->format('j') }}</span>
                                <span class="text-xs uppercase text-slate-400">{{ optional($event->starts_at)->format('M') }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ $event->title }}</h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ optional($event->starts_at)->format('l, M j · g:i A') }}
                                    @if ($event->location) · 📍 {{ $event->location }} @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        @if ($past->isNotEmpty())
            <section class="mt-12">
                <h2 class="text-xl font-bold text-slate-900">Past events</h2>
                <ul class="mt-6 divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white">
                    @foreach ($past as $event)
                        <li class="flex items-center justify-between gap-4 p-4">
                            <a href="{{ route('events.show', $event) }}" class="font-medium text-slate-700 hover:text-blue-700">{{ $event->title }}</a>
                            <span class="shrink-0 text-xs text-slate-400">{{ optional($event->starts_at)->format('M j, Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</x-public-layout>
