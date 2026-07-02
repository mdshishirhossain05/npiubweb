<x-layouts.app :title="$person->name.' — '.config('app.name')" :description="$person->seoDescription()">
    <div class="mx-auto max-w-5xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Faculty', 'url' => url('/faculty')], ['label' => $person->name]]" />

        <div class="mt-8 grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <x-ui.image-frame :src="$person->getFirstMediaUrl('photo') ?: null" :alt="$person->name" ratio="aspect-4/5" />
                <div class="mt-6 space-y-2 text-sm">
                    @if ($person->email)
                        <a href="mailto:{{ $person->email }}" class="flex items-center gap-2 text-slate-600 hover:text-primary-700"><span class="text-slate-400">✉</span>{{ $person->email }}</a>
                    @endif
                    @if ($person->contact)
                        <p class="flex items-center gap-2 text-slate-600"><span class="text-slate-400">☎</span>{{ $person->contact }}</p>
                    @endif
                    <div class="flex gap-3 pt-2">
                        @foreach (['facebook' => $person->facebook, 'linkedin' => $person->linkedin] as $label => $u)
                            @if ($u)<a href="{{ $u }}" target="_blank" rel="noopener" class="text-sm capitalize text-primary-700 hover:underline">{{ $label }}</a>@endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                @if ($person->department)
                    <span class="eyebrow">{{ $person->department->name }}</span>
                @endif
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">{{ $person->name }}</h1>
                <p class="mt-2 text-lg text-slate-600">{{ $person->position }}</p>

                @if (! empty($person->degrees))
                    <div class="mt-6">
                        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Education</h2>
                        <ul class="mt-2 flex flex-wrap gap-2">
                            @foreach ($person->degrees as $d)
                                <li class="rounded-full bg-slate-100 px-3 py-1 text-sm text-ink-900">{{ $d }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (! empty($person->research_interests))
                    <div class="mt-6">
                        <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Research Interests</h2>
                        <ul class="mt-2 flex flex-wrap gap-2">
                            @foreach ($person->research_interests as $r)
                                <li class="rounded-full border border-slate-200 px-3 py-1 text-sm text-slate-700">{{ $r }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($person->biography)
                    <div class="prose prose-slate mt-8 max-w-none">
                        {!! nl2br(e($person->biography)) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
