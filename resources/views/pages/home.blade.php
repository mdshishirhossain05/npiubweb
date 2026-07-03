<x-layouts.app :title="config('app.name').' — Official Website'">
    @php $heroImg = optional($sliders->first(fn ($s) => $s->getFirstMediaUrl('image')))?->getFirstMediaUrl('image'); @endphp

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden mesh-bg">
        {{-- drifting gradient blobs --}}
        <div class="animate-blob pointer-events-none absolute -left-24 -top-24 -z-10 h-96 w-96 rounded-full bg-primary-300/30 blur-3xl"></div>
        <div class="animate-blob pointer-events-none absolute -right-16 top-32 -z-10 h-80 w-80 rounded-full bg-teal-300/30 blur-3xl" style="animation-delay:-6s"></div>

        <div class="mx-auto max-w-7xl px-4 lg:px-6">
            <div class="grid items-center gap-12 py-16 lg:grid-cols-12 lg:py-24">
                <div class="lg:col-span-6" data-reveal>
                    <span class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-white/70 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-primary-700 backdrop-blur">
                        <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span></span>
                        NPI University of Bangladesh · Est. 2015
                    </span>
                    <h1 class="mt-6 text-5xl font-bold leading-[1.03] tracking-tight text-ink-900 sm:text-6xl lg:text-7xl">
                        Knowledge for a <span class="gradient-text">purposeful future.</span>
                    </h1>
                    <p class="mt-6 max-w-lg text-lg leading-relaxed text-slate-600">
                        A modern university shaping skilled, ethical graduates across engineering, business, and the arts — through hands-on learning and dedicated faculty.
                    </p>
                    <div class="mt-9 flex flex-wrap items-center gap-4">
                        <a href="{{ url('/admissions') }}" class="card-hover inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-primary-600 to-teal-500 px-7 py-3.5 text-base font-semibold text-white shadow-lg shadow-primary-500/30">
                            Apply for Admission
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ url('/about') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white/60 px-7 py-3.5 text-base font-semibold text-ink-900 backdrop-blur transition hover:border-primary-400 hover:text-primary-700">
                            Discover NPIUB
                        </a>
                    </div>
                </div>

                {{-- hero visual: gradient panel + floating glass cards --}}
                <div class="lg:col-span-6" data-reveal style="--reveal-delay:120ms">
                    <div class="relative mx-auto max-w-md lg:mr-0">
                        <div class="relative aspect-4/5 overflow-hidden rounded-[2rem] shadow-2xl shadow-primary-500/30 {{ $heroImg ? '' : 'gradient-brand' }}">
                            @if ($heroImg)
                                <img src="{{ $heroImg }}" alt="NPIUB campus" class="h-full w-full object-cover">
                            @else
                                <div class="absolute inset-0 opacity-30" style="background-image:radial-gradient(circle at 25% 20%, rgba(255,255,255,0.5), transparent 45%), radial-gradient(circle at 85% 85%, rgba(255,255,255,0.25), transparent 40%);"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="h-24 w-24 text-white/80" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                                </div>
                            @endif
                        </div>
                        {{-- floating glass stat --}}
                        <div class="glass animate-float absolute -left-5 top-10 rounded-2xl px-5 py-4 shadow-xl">
                            <div class="font-display text-2xl font-bold gradient-text"><span x-data="counter({{ (int) ($stats[2]['value'] ?? 2000) }})" x-text="value.toLocaleString()">2,000</span>+</div>
                            <div class="text-xs font-medium text-slate-500">Students</div>
                        </div>
                        {{-- floating UGC badge --}}
                        <div class="glass animate-float absolute -right-4 bottom-14 flex items-center gap-3 rounded-2xl px-5 py-4 shadow-xl" style="animation-delay:-3s">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-teal-500 text-white shadow-lg">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-ink-900">UGC Approved</div>
                                <div class="text-xs text-slate-500">Recognized University</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ QUICK ACCESS ============ --}}
    <section class="mx-auto -mt-4 max-w-7xl px-4 pb-4 lg:px-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @foreach ([
                ['Admissions', 'Apply & requirements', '/admissions', 'M12 4.5l9 5-9 5-9-5 9-5zM5 12v4.5c0 1 3 2.5 7 2.5s7-1.5 7-2.5V12'],
                ['Programs', 'Explore departments', '/departments', 'M4 6h16M4 12h16M4 18h10'],
                ['Notice Board', 'Latest circulars', '/notices', 'M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0'],
                ['i-EMS Portal', 'Student & staff login', 'https://npiub.pipilikasoft.com/', 'M11 16l-4-4m0 0l4-4m-4 4h14M5 20a2 2 0 01-2-2V6a2 2 0 012-2'],
            ] as $q)
                <a href="{{ \Illuminate\Support\Str::startsWith($q[2], 'http') ? $q[2] : url($q[2]) }}" @if(\Illuminate\Support\Str::startsWith($q[2], 'http')) target="_blank" rel="noopener" @endif
                   class="card-hover group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 hover:border-primary-300">
                    <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-50 to-teal-50 text-primary-600 transition group-hover:from-primary-500 group-hover:to-teal-500 group-hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $q[3] }}"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-ink-900">{{ $q[0] }}</div>
                        <div class="text-sm text-slate-500">{{ $q[1] }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ============ STATS BAND ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-20">
        <div class="gradient-brand relative overflow-hidden rounded-3xl px-6 py-12 shadow-2xl shadow-primary-500/25 sm:px-12" data-reveal>
            <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 20% 20%, rgba(255,255,255,0.6), transparent 40%), radial-gradient(circle at 80% 90%, rgba(255,255,255,0.3), transparent 40%);"></div>
            <div class="relative grid grid-cols-2 gap-8 text-white lg:grid-cols-4">
                @foreach ($stats as $stat)
                    <div class="text-center">
                        <div class="font-display text-4xl font-bold sm:text-5xl">
                            @if ($stat['count'] ?? false)
                                <span x-data="counter({{ (int) $stat['value'] }})" x-text="value.toLocaleString()">{{ number_format((int) $stat['value']) }}</span>{{ $stat['suffix'] ?? '' }}
                            @else
                                {{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}
                            @endif
                        </div>
                        <div class="mt-2 text-sm font-medium text-white/80">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ WHY NPIUB ============ --}}
    <section class="mx-auto max-w-7xl px-4 pb-8 lg:px-6">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <span class="eyebrow justify-center">Why NPIUB</span>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-ink-900 sm:text-4xl">An education that goes further.</h2>
            <p class="mt-4 text-lg leading-relaxed text-slate-600">Industry-aligned programs, experienced faculty, and modern facilities that prepare graduates to lead and contribute to national development.</p>
        </div>
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal style="--reveal-delay:80ms">
            @foreach ([
                ['Expert Faculty', 'Experienced educators and industry practitioners guiding every program.', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197'],
                ['Modern Campus', 'Well-equipped labs, a rich library, and facilities built for practice.', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3m4-16h10M9 9h6m-6 4h6'],
                ['Industry-Aligned', 'Curriculum designed with employability and real skills in mind.', 'M21 13.255A23.9 23.9 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01'],
                ['Career Outcomes', 'Strong industry links that help graduates launch their careers.', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
            ] as $f)
                <div class="card-hover rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-teal-500 text-white shadow-lg shadow-primary-500/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f[2] }}"/></svg>
                    </div>
                    <h3 class="mt-5 text-lg font-semibold text-ink-900">{{ $f[0] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $f[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ PROGRAMS ============ --}}
    @if ($programs->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-24">
            <div class="flex flex-wrap items-end justify-between gap-4" data-reveal>
                <div>
                    <span class="eyebrow">Academics</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-ink-900 sm:text-4xl">Programs built for the future.</h2>
                </div>
                <a href="{{ url('/admissions') }}" class="inline-flex items-center gap-1.5 rounded-full border border-slate-300 px-5 py-2.5 text-sm font-semibold text-ink-900 transition hover:border-primary-400 hover:text-primary-700">All programs</a>
            </div>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4" data-reveal style="--reveal-delay:80ms">
                @foreach ($programs as $i => $program)
                    <x-cards.program-card :program="$program" :index="$i + 1" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ DEPARTMENTS ============ --}}
    @if ($departments->isNotEmpty())
        <section class="relative overflow-hidden bg-slate-50">
            <div class="mesh-bg pointer-events-none absolute inset-0"></div>
            <div class="relative mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-24">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <span class="eyebrow justify-center">Faculties &amp; Departments</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-ink-900 sm:text-4xl">Where you'll study.</h2>
                </div>
                <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3" data-reveal style="--reveal-delay:80ms">
                    @foreach ($departments as $dept)
                        <a href="{{ url('/departments/'.$dept->slug) }}" class="card-hover group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-7 hover:border-primary-300">
                            <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-primary-100 to-teal-100 opacity-60 transition group-hover:scale-150"></div>
                            <div class="relative">
                                <span class="font-display text-sm font-bold text-primary-500">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="mt-3 text-xl font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700">{{ $dept->name }}</h3>
                                <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-700">
                                    View department
                                    <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ NOTICES + NEWS ============ --}}
    <section class="mx-auto grid max-w-7xl gap-12 px-4 py-16 lg:grid-cols-12 lg:px-6 lg:py-24">
        <div class="lg:col-span-5" data-reveal>
            <div class="flex items-end justify-between">
                <div>
                    <span class="eyebrow">Notice Board</span>
                    <h2 class="mt-4 text-2xl font-bold tracking-tight text-ink-900 sm:text-3xl">Latest Notices</h2>
                </div>
                <a href="{{ url('/notices') }}" class="pb-1 text-sm font-semibold text-primary-700 hover:text-primary-800">All →</a>
            </div>
            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-2">
                @forelse ($notices as $notice)
                    <div class="rounded-xl px-4 transition hover:bg-primary-50/60"><x-cards.notice-item :notice="$notice" /></div>
                @empty
                    <p class="p-4 text-slate-500">No notices yet.</p>
                @endforelse
            </div>
        </div>
        <div class="lg:col-span-6 lg:col-start-7" data-reveal style="--reveal-delay:100ms">
            <div class="flex items-end justify-between">
                <div>
                    <span class="eyebrow">Campus Life</span>
                    <h2 class="mt-4 text-2xl font-bold tracking-tight text-ink-900 sm:text-3xl">News &amp; Events</h2>
                </div>
                <a href="{{ url('/news') }}" class="pb-1 text-sm font-semibold text-primary-700 hover:text-primary-800">All →</a>
            </div>
            <div class="mt-8 grid gap-8 sm:grid-cols-2">
                @forelse ($news as $article)
                    <x-cards.news-card :article="$article" />
                @empty
                    <p class="text-slate-500">No news yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ LEADERSHIP DUO ============ --}}
    @if (! empty($leaders))
        <section class="bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-24">
                <div class="mx-auto max-w-2xl text-center" data-reveal>
                    <span class="eyebrow justify-center">From the Leadership</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-ink-900 sm:text-4xl">Guided by vision and integrity.</h2>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2" data-reveal style="--reveal-delay:80ms">
                    @foreach ($leaders as $leader)
                        <figure class="card-hover flex flex-col gap-6 rounded-3xl border border-slate-200 bg-white p-8 sm:flex-row">
                            <div class="flex-none">
                                <div class="rounded-2xl bg-gradient-to-br from-primary-500 to-teal-500 p-1 shadow-lg shadow-primary-500/30">
                                    <div class="w-28 overflow-hidden rounded-xl bg-white">
                                        <x-ui.image-frame :src="$leader['photo']" :alt="$leader['name']" ratio="aspect-4/5" rounded="rounded-xl" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <svg class="h-8 w-8 text-primary-200" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 6C6.5 7.5 5 10 5 13v5h5v-5H7.5c0-2 1-3.5 3-4.5L9.5 6zm9 0c-3 1.5-4.5 4-4.5 7v5h5v-5H16c0-2 1-3.5 3-4.5L18.5 6z"/></svg>
                                <blockquote class="mt-3 text-lg font-medium leading-snug text-ink-900">{{ $leader['quote'] }}</blockquote>
                                <figcaption class="mt-auto pt-6">
                                    <div class="text-base font-bold text-ink-900">{{ $leader['name'] }}</div>
                                    <div class="text-sm text-primary-700">{{ $leader['position'] }}</div>
                                    @if (! empty($leader['link']))
                                        <a href="{{ url($leader['link']) }}" class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-primary-700">
                                            Read more
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </a>
                                    @endif
                                </figcaption>
                            </div>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ CTA ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-20">
        <div class="gradient-brand relative overflow-hidden rounded-3xl px-6 py-16 text-center shadow-2xl shadow-primary-500/25 sm:px-12" data-reveal>
            <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 15% 20%, rgba(255,255,255,0.6), transparent 40%), radial-gradient(circle at 85% 85%, rgba(255,255,255,0.3), transparent 40%);"></div>
            <div class="relative mx-auto max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Begin your journey at NPIUB.</h2>
                <p class="mt-4 text-lg text-white/85">Admissions are open — take the first step toward a career that matters.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ url('/admissions') }}" class="card-hover inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-base font-semibold text-primary-700 shadow-lg">Apply Now</a>
                    <a href="{{ url('/contact') }}" class="inline-flex items-center gap-2 rounded-full border border-white/40 px-7 py-3.5 text-base font-semibold text-white transition hover:bg-white/10">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
