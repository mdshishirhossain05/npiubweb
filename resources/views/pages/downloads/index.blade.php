<x-layouts.app :title="'Downloads — '.config('app.name')" description="Forms, prospectus, and documents from NPI University of Bangladesh.">
    <x-ui.page-hero title="Downloads" eyebrow="Documents & Forms" :breadcrumbs="[['label' => 'Downloads']]"
        intro="Prospectus, application forms, results, and official documents." />

    <section class="mx-auto max-w-4xl px-4 py-14 lg:py-20">
        @forelse ($downloads as $category => $items)
            <div class="mb-12">
                <h2 class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $category }}</h2>
                <div class="divide-y divide-slate-200 border-y border-slate-200">
                    @foreach ($items as $download)
                        @php $file = $download->getFirstMedia('file'); @endphp
                        <a href="{{ $file?->getUrl() ?? '#' }}" @if ($file) target="_blank" rel="noopener" @endif
                           class="group flex items-center justify-between gap-4 py-4">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 flex-none text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 3h7l5 5v13H7z M14 3v5h5"/></svg>
                                <span class="font-medium text-ink-900 group-hover:text-primary-700">{{ $download->title }}</span>
                            </div>
                            <span class="text-sm text-slate-400 group-hover:text-ink-900">Download ↓</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-slate-500">No documents available yet.</p>
        @endforelse
    </section>
</x-layouts.app>
