<x-public-layout title="Notices" description="Official notices and circulars from NPI University of Bangladesh.">
    <x-public.page-header title="Notices" subtitle="Official circulars and announcements." />

    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($notices->isEmpty())
            <x-public.empty message="No notices have been published yet." />
        @else
            <ul class="divide-y divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white">
                @foreach ($notices as $notice)
                    <li class="flex items-start gap-4 p-5 transition hover:bg-slate-50">
                        <div class="hidden w-16 shrink-0 text-center sm:block">
                            <div class="text-lg font-bold text-blue-700">{{ optional($notice->notice_date)->format('j') }}</div>
                            <div class="text-xs uppercase text-slate-400">{{ optional($notice->notice_date)->format('M Y') }}</div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                @if ($notice->is_pinned)
                                    <span class="rounded bg-amber-100 px-1.5 py-0.5 text-xs font-semibold text-amber-700">Pinned</span>
                                @endif
                                <a href="{{ route('notices.show', $notice) }}" class="font-medium text-slate-800 hover:text-blue-700">{{ $notice->title }}</a>
                            </div>
                            <p class="mt-1 text-xs text-slate-400 sm:hidden">{{ optional($notice->notice_date)->format('M j, Y') }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10">{{ $notices->links() }}</div>
        @endif
    </div>
</x-public-layout>
