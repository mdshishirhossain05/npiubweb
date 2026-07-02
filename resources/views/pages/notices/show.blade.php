<x-layouts.app :title="$notice->seoTitle().' — '.config('app.name')" :description="$notice->seoDescription()">
    <article class="mx-auto max-w-3xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Notices', 'url' => url('/notices')], ['label' => $notice->title]]" />

        <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-slate-500">
            <span class="capitalize text-primary-700">{{ $notice->category }}</span>
            <span class="h-1 w-1 rounded-full bg-slate-300"></span>
            <span>{{ $notice->notice_date?->format('F d, Y') }}</span>
            @if ($notice->is_important)
                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                <span class="font-semibold text-accent-600">Important</span>
            @endif
        </div>

        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">{{ $notice->title }}</h1>
        @if ($notice->published_by)
            <p class="mt-2 text-sm text-slate-500">Published by {{ $notice->published_by }}</p>
        @endif

        <div class="prose prose-slate mt-8 max-w-none prose-a:text-primary-700">
            {!! $notice->description !!}
        </div>

        @php $file = $notice->getFirstMedia('attachment'); @endphp
        @if ($file)
            <a href="{{ $file->getUrl() }}" target="_blank" rel="noopener"
               class="mt-8 inline-flex items-center gap-2 rounded-md border border-slate-300 px-4 py-2.5 text-sm font-medium text-ink-900 transition hover:border-ink-900">
                <svg class="h-5 w-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 6H7a2 2 0 01-2-2V6a2 2 0 012-2h5l5 5v9a2 2 0 01-2 2z"/></svg>
                Download attachment
            </a>
        @endif

        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-slate-200 pt-10">
                <h2 class="text-lg font-semibold tracking-tight text-ink-900">More notices</h2>
                <div class="mt-4">
                    @foreach ($related as $notice)
                        <x-cards.notice-item :notice="$notice" />
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</x-layouts.app>
