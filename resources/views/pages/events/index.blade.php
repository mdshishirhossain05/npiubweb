<x-layouts.app :title="'Events — '.config('app.name')" description="Upcoming and past events at NPI University of Bangladesh.">
    <x-ui.page-hero title="Events" eyebrow="What's On" :breadcrumbs="[['label' => 'Events']]"
        intro="Convocations, seminars, workshops, and cultural programs at NPIUB." />

    <section class="mx-auto max-w-5xl px-4 py-14 lg:py-20">
        @if ($upcoming->isNotEmpty())
            <h2 class="text-2xl font-semibold tracking-tight text-ink-900">Upcoming</h2>
            <div class="mt-8">
                @foreach ($upcoming as $event)
                    <a href="{{ url('/events/'.$event->slug) }}" class="group flex flex-col gap-4 border-t border-slate-200 py-6 sm:flex-row sm:items-center sm:gap-8 first:border-t-0 hover:border-ink-900">
                        <div class="flex-none text-center sm:w-24">
                            <div class="font-display text-3xl font-semibold text-ink-900">{{ $event->starts_at?->format('d') }}</div>
                            <div class="text-sm uppercase tracking-wide text-slate-500">{{ $event->starts_at?->format('M Y') }}</div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $event->title }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $event->starts_at?->format('g:i A') }} @if ($event->venue) · {{ $event->venue }} @endif</p>
                        </div>
                        <svg class="hidden h-5 w-5 flex-none text-slate-300 transition group-hover:translate-x-1 group-hover:text-ink-900 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="{{ $upcoming->isNotEmpty() ? 'mt-16' : '' }}">
            <h2 class="text-2xl font-semibold tracking-tight text-ink-900">Past events</h2>
            @if ($past->isNotEmpty())
                <div class="mt-8 grid gap-x-8 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($past as $event)
                        <a href="{{ url('/events/'.$event->slug) }}" class="group block">
                            <x-ui.image-frame :src="$event->getFirstMediaUrl('cover', 'thumb') ?: null" :alt="$event->title" ratio="aspect-16/10" />
                            <p class="mt-3 text-xs uppercase tracking-wider text-slate-400">{{ $event->starts_at?->format('M d, Y') }}</p>
                            <h3 class="mt-1 font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $event->title }}</h3>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10">{{ $past->links() }}</div>
            @else
                <p class="mt-6 text-slate-500">No past events yet.</p>
            @endif
        </div>
    </section>
</x-layouts.app>
