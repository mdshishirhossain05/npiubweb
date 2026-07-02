<x-layouts.app :title="'Search — '.config('app.name')">
    <x-ui.page-hero title="Search" eyebrow="Find" :breadcrumbs="[['label' => 'Search']]">
        <form method="GET" action="{{ url('/search') }}" class="mt-8 flex max-w-xl gap-3">
            <input name="q" value="{{ $q }}" placeholder="Search notices, news, faculty, programs…" autofocus
                   class="w-full rounded-md border border-slate-300 px-4 py-3 text-sm focus:border-ink-900 focus:outline-none">
            <x-ui.button type="submit" size="lg">Search</x-ui.button>
        </form>
    </x-ui.page-hero>

    <section class="mx-auto max-w-3xl px-4 py-14 lg:py-16">
        @if ($q === '')
            <p class="text-slate-500">Type a keyword above to search the site.</p>
        @elseif ($results->isEmpty())
            <p class="text-slate-500">No results found for “<span class="font-medium text-ink-900">{{ $q }}</span>”.</p>
        @else
            <p class="mb-6 text-sm text-slate-500">{{ $results->count() }} result(s) for “<span class="font-medium text-ink-900">{{ $q }}</span>”</p>
            <div class="divide-y divide-slate-200 border-y border-slate-200">
                @foreach ($results as $r)
                    <a href="{{ $r['url'] }}" class="group flex items-center justify-between gap-4 py-4">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-primary-700">{{ $r['type'] }}</span>
                            <h3 class="mt-0.5 font-medium text-ink-900 group-hover:text-primary-700">{{ $r['title'] }}</h3>
                        </div>
                        @if (! empty($r['date']))<span class="flex-none text-sm text-slate-400">{{ \Illuminate\Support\Carbon::parse($r['date'])->format('M Y') }}</span>@endif
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
