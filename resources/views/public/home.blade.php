<x-public-layout :description="'Official website of NPI University of Bangladesh — programmes, departments, news, notices and events.'">

    {{-- ===================== HERO ===================== --}}
    <section
        x-data="{ active: 0, count: {{ max($slides->count(), 1) }},
                  next() { this.active = (this.active + 1) % this.count } }"
        x-init="count > 1 && setInterval(() => next(), 7000)"
        class="relative bg-navy-900"
    >
        <div class="relative h-[520px] sm:h-[600px]">
            @foreach ($slides as $index => $slide)
                <div x-show="active === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     class="absolute inset-0">
                    @if ($slide->imageUrl())
                        <img src="{{ $slide->imageUrl() }}" alt="" class="h-full w-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-900/85 to-navy-900/40"></div>
                </div>
            @endforeach

            <div class="relative mx-auto flex h-full max-w-7xl items-center px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brass-500">
                        Established for excellence
                    </p>
                    <h1 class="mt-5 font-display text-4xl font-bold leading-[1.1] text-white sm:text-6xl">
                        @if ($slides->isNotEmpty())
                            <span x-text="[{{ $slides->map(fn ($s) => json_encode($s->title ?: 'A university built on knowledge and character'))->implode(',') }}][active]"></span>
                        @else
                            A university built on knowledge and character
                        @endif
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-navy-50/85">
                        NPI University of Bangladesh offers rigorous academic programmes, dedicated
                        faculty and a supportive campus community in the heart of Manikganj.
                    </p>
                    <div class="mt-9 flex flex-wrap gap-4">
                        <a href="{{ route('departments.index') }}"
                           class="inline-flex items-center rounded-md bg-brass-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brass-600">
                            Explore Programmes
                        </a>
                        <a href="{{ route('posts.index') }}"
                           class="inline-flex items-center rounded-md border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            Read the Latest News
                        </a>
                    </div>
                </div>
            </div>

            @if ($slides->count() > 1)
                <div class="absolute inset-x-0 bottom-6 z-10 flex justify-center gap-2">
                    @foreach ($slides as $index => $slide)
                        <button @click="active = {{ $index }}"
                                :class="active === {{ $index }} ? 'w-8 bg-brass-500' : 'w-2.5 bg-white/40'"
                                class="h-1.5 rounded-full transition-all" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ===================== STATS ===================== --}}
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto grid max-w-6xl grid-cols-2 gap-8 px-6 py-12 lg:grid-cols-4 lg:px-8">
            <x-public.stat text="2015" label="Established" />
            <x-public.stat :value="4" label="Faculties" />
            <x-public.stat :value="max($departments->count(), 7)" label="Departments" />
            <x-public.stat :value="12" suffix="+" label="Programmes" />
        </div>
    </section>

    {{-- ===================== WELCOME / ABOUT ===================== --}}
    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <x-public.reveal>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brass-600">Welcome to NPIUB</p>
                <h2 class="mt-3 font-display text-3xl font-bold leading-tight text-navy-900 sm:text-4xl">
                    An education grounded in scholarship and purpose
                </h2>
                <p class="mt-6 leading-relaxed text-slate-600">
                    Established in 2015 at Basta, Singair, Manikganj, NPI University of Bangladesh
                    is a UGC-approved private university committed to academic rigour, research and
                    the personal growth of every student.
                </p>
                <p class="mt-4 leading-relaxed text-slate-600">
                    Through our Faculties of Engineering, Business, Arts &amp; Social Science, and
                    Health Science &amp; Technology, students learn from dedicated faculty in a
                    supportive community that values integrity and excellence.
                </p>
                <a href="/about" class="mt-8 inline-flex items-center text-sm font-semibold text-navy-700 underline-offset-4 hover:text-brass-600 hover:underline">
                    More about the university &rarr;
                </a>
            </x-public.reveal>

            <x-public.reveal :delay="120">
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $pillars = [
                            ['t' => 'Accredited Programmes', 'd' => 'Recognised diplomas and degrees across disciplines.'],
                            ['t' => 'Experienced Faculty', 'd' => 'Teachers and researchers dedicated to your success.'],
                            ['t' => 'Modern Facilities', 'd' => 'Well-equipped labs, libraries and classrooms.'],
                            ['t' => 'Student Support', 'd' => 'Guidance, advising and a welcoming community.'],
                        ];
                    @endphp
                    @foreach ($pillars as $p)
                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">
                            <h3 class="font-display font-semibold text-navy-900">{{ $p['t'] }}</h3>
                            <p class="mt-2 text-sm text-slate-600">{{ $p['d'] }}</p>
                        </div>
                    @endforeach
                </div>
            </x-public.reveal>
        </div>
    </section>

    {{-- ===================== LATEST NEWS ===================== --}}
    @if ($posts->isNotEmpty())
        <section class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <x-public.heading eyebrow="Campus News" title="Latest News" :link="route('posts.index')" />
                <div class="mt-10 grid gap-8 lg:grid-cols-3">
                    @foreach ($posts->take(3) as $i => $post)
                        <x-public.reveal :delay="$i * 100">
                            <article class="group flex h-full flex-col overflow-hidden rounded-lg border border-slate-200 bg-white">
                                <a href="{{ route('posts.show', $post) }}" class="block aspect-[16/10] overflow-hidden">
                                    <x-public.thumb :src="$post->featuredImageUrl()" />
                                </a>
                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        @if ($post->category)
                                            <span class="font-semibold uppercase tracking-wide text-brass-600">{{ $post->category->name }}</span>
                                            <span>·</span>
                                        @endif
                                        <span>{{ optional($post->published_at)->format('M j, Y') }}</span>
                                    </div>
                                    <h3 class="mt-3 font-display text-xl font-semibold leading-snug text-navy-900">
                                        <a href="{{ route('posts.show', $post) }}" class="transition group-hover:text-brass-600">{{ $post->title }}</a>
                                    </h3>
                                    @if ($post->excerpt)
                                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
                                    @endif
                                </div>
                            </article>
                        </x-public.reveal>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== NOTICES + EVENTS ===================== --}}
    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8">
        <div class="grid gap-14 lg:grid-cols-2">
            <div>
                <x-public.heading eyebrow="Announcements" title="Notices" :link="route('notices.index')" />
                @if ($notices->isEmpty())
                    <x-public.empty class="mt-8" message="No notices yet." />
                @else
                    <ul class="mt-6 divide-y divide-slate-200">
                        @foreach ($notices as $notice)
                            <li>
                                <a href="{{ route('notices.show', $notice) }}" class="flex items-baseline gap-4 py-4 transition hover:text-brass-600">
                                    <span class="w-24 shrink-0 text-sm text-slate-400">{{ optional($notice->notice_date)->format('M j, Y') }}</span>
                                    <span class="flex-1 font-medium text-navy-900">
                                        {{ $notice->title }}
                                        @if ($notice->is_pinned)
                                            <span class="ml-1 align-middle text-xs font-semibold uppercase text-brass-600">· Pinned</span>
                                        @endif
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
                            <a href="{{ route('events.show', $event) }}"
                               class="flex items-center gap-5 rounded-lg border border-slate-200 p-4 transition hover:border-brass-500/60">
                                <div class="grid h-16 w-16 shrink-0 place-items-center rounded-md bg-navy-900 text-center text-white">
                                    <span class="font-display text-xl font-bold leading-none">{{ optional($event->starts_at)->format('j') }}</span>
                                    <span class="text-[10px] uppercase tracking-wide text-navy-50/70">{{ optional($event->starts_at)->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-display font-semibold text-navy-900">{{ $event->title }}</h3>
                                    <p class="mt-1 flex items-center gap-1.5 text-sm text-slate-500">
                                        {{ optional($event->starts_at)->format('g:i A') }}
                                        @if ($event->location)
                                            <span>·</span>
                                            <x-public.icon-pin class="h-3.5 w-3.5" /> {{ $event->location }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===================== DEPARTMENTS ===================== --}}
    @if ($departments->isNotEmpty())
        <section class="border-y border-slate-200 bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <x-public.heading eyebrow="Academics" title="Departments" :link="route('departments.index')" />
                <div class="mt-10 grid gap-px overflow-hidden rounded-lg border border-slate-200 bg-slate-200 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($departments->take(6) as $department)
                        <a href="{{ route('departments.show', $department) }}"
                           class="group flex items-start gap-4 bg-white p-6 transition hover:bg-navy-50">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full border border-navy-900/15 font-display text-sm font-bold text-navy-800">
                                {{ \Illuminate\Support\Str::substr($department->short_name ?: $department->name, 0, 2) }}
                            </span>
                            <div>
                                <h3 class="font-display font-semibold text-navy-900 group-hover:text-brass-600">{{ $department->name }}</h3>
                                @if ($department->short_name)
                                    <p class="text-sm text-slate-500">{{ $department->short_name }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== CTA ===================== --}}
    <section class="bg-navy-900">
        <div class="mx-auto max-w-4xl px-6 py-16 text-center lg:px-8">
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">Begin your journey at NPIUB</h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-navy-50/80">
                Explore our programmes and discover a place to learn, grow and belong.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('departments.index') }}" class="rounded-md bg-brass-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brass-600">Explore Programmes</a>
                <a href="{{ route('faculty.index') }}" class="rounded-md border border-white/40 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Meet our Faculty</a>
            </div>
        </div>
    </section>
</x-public-layout>
