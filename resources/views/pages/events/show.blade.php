<x-layouts.app :title="$event->seoTitle().' — '.config('app.name')" :description="$event->seoDescription()">
    <article class="mx-auto max-w-3xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Events', 'url' => url('/events')], ['label' => $event->title]]" />
        <h1 class="mt-8 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl lg:text-5xl">{{ $event->title }}</h1>

        <div class="mt-5 flex flex-wrap gap-x-8 gap-y-2 border-y border-slate-200 py-4 text-sm">
            <div><span class="text-slate-500">Date</span> <span class="font-medium text-ink-900">{{ $event->starts_at?->format('F d, Y') }}</span></div>
            <div><span class="text-slate-500">Time</span> <span class="font-medium text-ink-900">{{ $event->starts_at?->format('g:i A') }}</span></div>
            @if ($event->venue)<div><span class="text-slate-500">Venue</span> <span class="font-medium text-ink-900">{{ $event->venue }}</span></div>@endif
        </div>

        @php $cover = $event->getFirstMediaUrl('cover'); @endphp
        @if ($cover)<img src="{{ $cover }}" alt="{{ $event->title }}" class="mt-8 w-full rounded-lg object-cover">@endif

        <div class="prose prose-slate mt-8 max-w-none prose-a:text-primary-700">{!! $event->description !!}</div>
    </article>
</x-layouts.app>
