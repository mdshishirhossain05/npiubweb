<x-public-layout :title="$notice->title" description="Official notice from NPI University of Bangladesh.">
    <x-public.page-header :title="$notice->title"
        :subtitle="optional($notice->notice_date)->format('F j, Y')" />

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="leading-relaxed text-slate-700">
            {!! nl2br(e($notice->body)) !!}
        </div>

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('notices.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">&larr; Back to all notices</a>
        </div>
    </article>
</x-public-layout>
