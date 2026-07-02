<x-layouts.app :title="'Notices — '.config('app.name')" description="Latest notices and announcements from NPI University of Bangladesh.">
    <x-ui.page-hero title="Notices" eyebrow="Notice Board" :breadcrumbs="[['label' => 'Notices']]"
        intro="Official announcements, examination schedules, and important updates." />

    <section class="mx-auto max-w-4xl px-4 py-12 lg:py-16">
        {{-- Filters --}}
        <div class="mb-8 flex flex-wrap items-center gap-2">
            <a href="{{ url('/notices') }}" class="rounded-full border px-3.5 py-1.5 text-sm transition {{ ! request('category') ? 'border-ink-900 bg-ink-900 text-white' : 'border-slate-300 text-slate-600 hover:border-ink-900' }}">All</a>
            @foreach ($categories as $cat)
                <a href="{{ url('/notices?category='.urlencode($cat)) }}" class="rounded-full border px-3.5 py-1.5 text-sm capitalize transition {{ request('category') === $cat ? 'border-ink-900 bg-ink-900 text-white' : 'border-slate-300 text-slate-600 hover:border-ink-900' }}">{{ $cat }}</a>
            @endforeach
        </div>

        @forelse ($notices as $notice)
            <x-cards.notice-item :notice="$notice" />
        @empty
            <p class="border-t border-slate-200 py-12 text-center text-slate-500">No notices found.</p>
        @endforelse

        <div class="mt-10">{{ $notices->links() }}</div>
    </section>
</x-layouts.app>
