<x-public-layout :description="'NPI University of Bangladesh — a UGC-approved private university in Manikganj offering programmes across engineering, business, arts and health sciences.'">

    {{-- ============ HERO ============ --}}
    <section class="bg-ink-950 text-white">
        <div class="mx-auto grid max-w-[1400px] items-stretch gap-0 px-6 lg:grid-cols-12 lg:px-10">
            <div class="flex flex-col justify-center py-16 lg:col-span-7 lg:py-24 lg:pr-12">
                <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-[0.25em] text-accent-400">
                    <span class="h-px w-8 bg-accent-500"></span> NPI University of Bangladesh
                </div>
                <h1 class="mt-6 font-display text-5xl font-black leading-[1.02] tracking-tight sm:text-6xl lg:text-7xl">
                    Where knowledge<br>becomes <span class="italic text-accent-400">purpose.</span>
                </h1>
                <p class="mt-7 max-w-xl text-lg leading-relaxed text-ink-200">
                    A UGC-approved private university in Manikganj, educating the next generation
                    across engineering, business, arts and health sciences since 2015.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('departments.index') }}" class="inline-flex items-center gap-2 rounded-sm bg-accent-600 px-7 py-4 text-sm font-semibold text-white transition hover:bg-accent-500">
                        Explore Programmes
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </a>
                    <a href="/about" class="inline-flex items-center rounded-sm border border-white/25 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                        About the University
                    </a>
                </div>
            </div>

            <div class="relative lg:col-span-5">
                <div class="relative h-72 overflow-hidden sm:h-96 lg:absolute lg:inset-0 lg:h-full">
                    @if ($slides->first()?->imageUrl())
                        <img src="{{ $slides->first()->imageUrl() }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-950/60 to-transparent"></div>
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-ink-900">
                            <span class="font-display text-6xl font-black text-white/5">NPIUB</span>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 border-t-2 border-accent-500 bg-ink-950/80 px-5 py-3 text-xs font-semibold uppercase tracking-widest text-ink-200 backdrop-blur">
                        Campus · Manikganj
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ QUICK FACTS ============ --}}
    <section class="border-b border-ink-100 bg-white">
        <div class="mx-auto grid max-w-[1400px] grid-cols-2 divide-ink-100 px-6 py-10 sm:grid-cols-4 sm:divide-x lg:px-10">
            @foreach ([['2015','Established'],['4','Faculties'],[max($departments->count(),7),'Departments'],['12+','Programmes']] as [$n,$l])
                <div class="px-2 text-center sm:px-6">
                    <div class="font-display text-4xl font-black text-ink-900 sm:text-5xl">{{ $n }}</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.18em] text-ink-600">{{ $l }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ STATEMENT ============ --}}
    <section class="mx-auto max-w-[1400px] px-6 py-24 lg:px-10">
        <x-public.reveal class="max-w-4xl">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent-600">Our mission</p>
            <p class="mt-6 font-display text-3xl font-medium leading-[1.25] tracking-tight text-ink-900 sm:text-4xl lg:text-[2.75rem]">
                We prepare students to think critically, act with integrity and lead in their
                fields — through <span class="text-accent-600">rigorous teaching</span>, research
                and a community that believes in every learner's potential.
            </p>
            <a href="/about" class="link-underline mt-8 inline-block text-sm font-semibold text-ink-900">Read our story</a>
        </x-public.reveal>
    </section>

    {{-- ============ NEWS (editorial, asymmetric) ============ --}}
    @if ($posts->isNotEmpty())
        @php $lead = $posts->first(); $rest = $posts->slice(1, 4); @endphp
        <section class="border-y border-ink-100 bg-ink-50/50 py-20">
            <div class="mx-auto max-w-[1400px] px-6 lg:px-10">
                <x-public.heading eyebrow="Newsroom" title="Latest News" :link="route('posts.index')" />
                <div class="mt-10 grid gap-10 lg:grid-cols-2">
                    {{-- Lead story --}}
                    <a href="{{ route('posts.show', $lead) }}" class="group block">
                        <div class="aspect-[16/10] overflow-hidden rounded-sm">
                            <x-public.thumb :src="$lead->featuredImageUrl()" :alt="$lead->title" />
                        </div>
                        <div class="mt-5 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-accent-600">
                            @if ($lead->category)<span>{{ $lead->category->name }}</span><span class="text-ink-200">/</span>@endif
                            <span class="text-ink-600">{{ optional($lead->published_at)->format('M j, Y') }}</span>
                        </div>
                        <h3 class="mt-3 font-display text-3xl font-bold leading-tight text-ink-900 transition group-hover:text-accent-600">{{ $lead->title }}</h3>
                        @if ($lead->excerpt)<p class="mt-3 max-w-xl leading-relaxed text-ink-600">{{ $lead->excerpt }}</p>@endif
                    </a>

                    {{-- Secondary list --}}
                    <div class="divide-y divide-ink-100">
                        @foreach ($rest as $post)
                            <a href="{{ route('posts.show', $post) }}" class="group flex gap-5 py-5 first:pt-0">
                                <div class="hidden aspect-square w-24 shrink-0 overflow-hidden rounded-sm sm:block">
                                    <x-public.thumb :src="$post->featuredImageUrl()" :alt="$post->title" />
                                </div>
                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-wide text-accent-600">{{ optional($post->published_at)->format('M j, Y') }}</div>
                                    <h4 class="mt-1.5 font-display text-lg font-semibold leading-snug text-ink-900 transition group-hover:text-accent-600">{{ $post->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ ACADEMICS (numbered editorial list) ============ --}}
    @if ($departments->isNotEmpty())
        <section class="mx-auto max-w-[1400px] px-6 py-24 lg:px-10">
            <x-public.heading eyebrow="Academics" title="Departments" :link="route('departments.index')" />
            <div class="mt-8 border-t border-ink-900">
                @foreach ($departments->take(7) as $i => $department)
                    <a href="{{ route('departments.show', $department) }}"
                       class="group grid grid-cols-12 items-center gap-4 border-b border-ink-100 py-6 transition hover:bg-ink-50">
                        <span class="col-span-2 font-display text-sm font-bold text-accent-600 sm:col-span-1">{{ sprintf('%02d', $i + 1) }}</span>
                        <span class="col-span-8 font-display text-2xl font-bold text-ink-900 transition group-hover:translate-x-2 sm:col-span-8 sm:text-3xl">{{ $department->name }}</span>
                        <span class="col-span-2 hidden text-right text-sm text-ink-600 sm:col-span-2 sm:block">{{ $department->programs_count ?? $department->programs()->count() }} programmes</span>
                        <span class="col-span-2 flex justify-end sm:col-span-1">
                            <svg class="h-6 w-6 text-ink-300 transition group-hover:text-accent-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ NOTICES + EVENTS ============ --}}
    <section class="border-t border-ink-100 bg-ink-50/50 py-20">
        <div class="mx-auto grid max-w-[1400px] gap-14 px-6 lg:grid-cols-2 lg:px-10">
            <div>
                <x-public.heading eyebrow="Announcements" title="Notices" :link="route('notices.index')" />
                @if ($notices->isEmpty())
                    <x-public.empty class="mt-8" message="No notices yet." />
                @else
                    <ul class="mt-4 divide-y divide-ink-100">
                        @foreach ($notices as $notice)
                            <li>
                                <a href="{{ route('notices.show', $notice) }}" class="flex items-baseline gap-4 py-4 transition hover:text-accent-600">
                                    <span class="w-24 shrink-0 text-sm text-ink-600">{{ optional($notice->notice_date)->format('M j, Y') }}</span>
                                    <span class="flex-1 font-medium text-ink-900">
                                        {{ $notice->title }}
                                        @if ($notice->is_pinned)<span class="ml-1 text-xs font-semibold uppercase text-accent-600">· Pinned</span>@endif
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div>
                <x-public.heading eyebrow="Calendar" title="Upcoming Events" :link="route('events.index')" />
                @if ($events->isEmpty())
                    <x-public.empty class="mt-8" message="No upcoming events scheduled." />
                @else
                    <div class="mt-6 space-y-4">
                        @foreach ($events as $event)
                            <a href="{{ route('events.show', $event) }}" class="flex items-center gap-5 border border-ink-100 bg-white p-4 transition hover:border-accent-500">
                                <div class="grid h-16 w-16 shrink-0 place-items-center bg-ink-950 text-center text-white">
                                    <span class="font-display text-xl font-black leading-none">{{ optional($event->starts_at)->format('j') }}</span>
                                    <span class="text-[10px] uppercase tracking-wide text-ink-200">{{ optional($event->starts_at)->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-display font-semibold text-ink-900">{{ $event->title }}</h3>
                                    <p class="mt-1 flex items-center gap-1.5 text-sm text-ink-600">
                                        {{ optional($event->starts_at)->format('g:i A') }}
                                        @if ($event->location)<span>·</span><x-public.icon-pin class="h-3.5 w-3.5" /> {{ $event->location }}@endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ CTA ============ --}}
    <section class="bg-accent-600">
        <div class="mx-auto flex max-w-[1400px] flex-col items-start justify-between gap-8 px-6 py-16 lg:flex-row lg:items-center lg:px-10">
            <div>
                <h2 class="font-display text-4xl font-black leading-tight text-white sm:text-5xl">Your future starts here.</h2>
                <p class="mt-3 max-w-xl text-lg text-white/85">Admissions are open across all faculties. Take the first step today.</p>
            </div>
            <div class="flex shrink-0 gap-4">
                <a href="/admission" class="rounded-sm bg-white px-7 py-4 text-sm font-semibold text-accent-600 transition hover:bg-ink-950 hover:text-white">Apply Now</a>
                <a href="/about" class="rounded-sm border border-white/50 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">Learn More</a>
            </div>
        </div>
    </section>
</x-public-layout>
