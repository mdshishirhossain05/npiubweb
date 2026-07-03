<x-layouts.app :title="config('app.name').' — Official Website'">
    @php $heroImg = optional($sliders->first(fn ($s) => $s->getFirstMediaUrl('image')))?->getFirstMediaUrl('image'); @endphp

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden">
        {{-- faint diagonal grid backdrop --}}
        <div class="pointer-events-none absolute inset-0 -z-10"
             style="background-image: repeating-linear-gradient(135deg, rgba(15,133,80,0.035) 0px, rgba(15,133,80,0.035) 1px, transparent 1px, transparent 22px);"></div>
        <div class="mx-auto max-w-7xl px-4 lg:px-6">
            <div class="grid items-center gap-10 py-14 lg:grid-cols-12 lg:gap-12 lg:py-24">
                <div class="lg:col-span-7" data-reveal>
                    <span class="eyebrow">NPI University of Bangladesh · Est. 2015</span>
                    <h1 class="mt-6 text-5xl font-semibold leading-[1.02] tracking-tight text-ink-900 sm:text-6xl lg:text-[5rem]">
                        Knowledge<br>for a purposeful<br><span class="relative inline-block text-primary-600">future.<span class="absolute -bottom-1 left-0 h-[3px] w-full bg-primary-500/30"></span></span>
                    </h1>
                    <p class="mt-7 max-w-lg text-lg leading-relaxed text-slate-600">
                        A modern university shaping skilled, ethical graduates across engineering, business, and the arts — through hands-on learning and dedicated faculty.
                    </p>
                    <div class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-3">
                        <x-ui.button href="{{ url('/admissions') }}" size="lg">Apply for Admission</x-ui.button>
                        <x-ui.button href="{{ url('/about') }}" variant="link">
                            Discover NPIUB
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </x-ui.button>
                    </div>
                </div>
                <div class="lg:col-span-5" data-reveal style="--reveal-delay:120ms">
                    <div class="relative">
                        <x-ui.image-frame :src="$heroImg ?: null" alt="NPIUB campus" ratio="aspect-4/5" />
                        {{-- floating accreditation chip --}}
                        <div class="absolute -bottom-5 -left-5 hidden bg-ink-900 px-6 py-5 text-white shadow-xl sm:block">
                            <div class="font-display text-3xl font-semibold leading-none">UGC</div>
                            <div class="mt-1 text-xs tracking-wide text-slate-400">Approved University</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- stats row, hairline separated, animated counters --}}
            <div class="grid grid-cols-2 divide-x divide-slate-200 border-y border-slate-200 sm:grid-cols-4" data-reveal>
                @foreach ($stats as $i => $stat)
                    <div class="px-6 py-8 {{ $i === 0 ? 'pl-0' : '' }}">
                        <x-ui.stat :value="$stat['value']" :label="$stat['label']" :suffix="$stat['suffix'] ?? ''" :count="$stat['count'] ?? false" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ INTRO ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
        <div class="grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-5" data-reveal>
                <span class="eyebrow">Who we are</span>
                <h2 class="mt-5 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">A university built for the real world.</h2>
            </div>
            <div class="lg:col-span-6 lg:col-start-7" data-reveal style="--reveal-delay:100ms">
                <p class="text-lg leading-relaxed text-slate-600">
                    NPIUB combines academic rigour with practical skills, modern facilities, and a supportive community. Our industry-aligned programs and experienced faculty prepare graduates to lead and contribute to national development.
                </p>
                <div class="mt-8 grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                    @foreach ([
                        ['Expert faculty', 'Experienced educators and practitioners.'],
                        ['Modern campus', 'Well-equipped labs, library and facilities.'],
                        ['Industry-aligned', 'Curriculum built with employability in mind.'],
                        ['Career outcomes', 'Strong links that help graduates launch.'],
                    ] as $f)
                        <div class="border-t border-slate-200 pt-4">
                            <h3 class="text-base font-semibold text-ink-900">{{ $f[0] }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $f[1] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ ACADEMICS BENTO ============ --}}
    <section class="border-t border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-4" data-reveal>
                <x-ui.section-header eyebrow="Why NPIUB" title="An education that goes further." />
                <x-ui.button href="{{ url('/about') }}" variant="outline">About the university</x-ui.button>
            </div>
            <div class="mt-12 grid gap-4 md:grid-cols-3 md:grid-rows-2" data-reveal style="--reveal-delay:80ms">
                {{-- large feature tile --}}
                <div class="group relative flex flex-col justify-between overflow-hidden bg-ink-900 p-8 text-white md:col-span-2 md:row-span-2 md:p-10">
                    <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
                         style="background-image: repeating-linear-gradient(135deg, #fff 0px, #fff 1px, transparent 1px, transparent 16px);"></div>
                    <span class="eyebrow !text-primary-300">Hands-on learning</span>
                    <div class="relative mt-auto pt-16">
                        <h3 class="max-w-md text-3xl font-semibold tracking-tight sm:text-4xl">Learn by doing, in labs and studios built for practice.</h3>
                        <p class="mt-4 max-w-md text-slate-300">From engineering workshops to business simulations, our programs are grounded in real projects and industry tools — so graduates arrive ready.</p>
                    </div>
                </div>
                {{-- small tiles --}}
                <div class="flex flex-col justify-between bg-white p-8">
                    <div class="font-display text-4xl font-semibold text-primary-600"><span x-data="counter({{ (int) ($stats[1]['value'] ?? 6) }})" x-text="value">{{ $stats[1]['value'] ?? 6 }}</span></div>
                    <div>
                        <h3 class="text-lg font-semibold text-ink-900">Departments</h3>
                        <p class="mt-1 text-sm text-slate-500">Across engineering, business &amp; arts.</p>
                    </div>
                </div>
                <div class="flex flex-col justify-between bg-white p-8">
                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                    <div>
                        <h3 class="text-lg font-semibold text-ink-900">Scholarships</h3>
                        <p class="mt-1 text-sm text-slate-500">Merit &amp; need-based support for students.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ PROGRAMS ============ --}}
    @if ($programs->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-4" data-reveal>
                <x-ui.section-header eyebrow="Academics" title="Programs" />
                <x-ui.button href="{{ url('/admissions') }}" variant="outline">All programs</x-ui.button>
            </div>
            <div class="mt-12 grid gap-px border border-slate-200 bg-slate-200 sm:grid-cols-2 lg:grid-cols-4" data-reveal style="--reveal-delay:80ms">
                @foreach ($programs as $i => $program)
                    <div class="bg-white"><x-cards.program-card :program="$program" :index="$i + 1" /></div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ DEPARTMENTS (big type list) ============ --}}
    @if ($departments->isNotEmpty())
        <section class="border-t border-slate-200 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
                <div data-reveal><x-ui.section-header eyebrow="Faculties &amp; Departments" title="Where you'll study." /></div>
                <div class="mt-12 border-t border-slate-200" data-reveal style="--reveal-delay:60ms">
                    @foreach ($departments as $dept)
                        <a href="{{ url('/departments/'.$dept->slug) }}" class="group flex items-center justify-between gap-6 border-b border-slate-200 py-7 transition hover:px-4 hover:bg-white">
                            <div class="flex items-baseline gap-6">
                                <span class="font-display text-sm text-slate-400">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="text-2xl font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700 sm:text-3xl">{{ $dept->name }}</h3>
                            </div>
                            <svg class="h-6 w-6 flex-none text-slate-300 transition group-hover:translate-x-1 group-hover:text-ink-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ NOTICES + NEWS ============ --}}
    <section class="mx-auto grid max-w-7xl gap-12 px-4 py-20 lg:grid-cols-12 lg:px-6 lg:py-28">
        <div class="lg:col-span-5" data-reveal>
            <div class="flex items-end justify-between">
                <x-ui.section-header eyebrow="Notice Board" title="Notices" />
                <a href="{{ url('/notices') }}" class="pb-1 text-sm font-medium text-primary-700 hover:text-primary-800">All →</a>
            </div>
            <div class="mt-10">
                @forelse ($notices as $notice)
                    <x-cards.notice-item :notice="$notice" />
                @empty
                    <p class="text-slate-500">No notices yet.</p>
                @endforelse
            </div>
        </div>
        <div class="lg:col-span-6 lg:col-start-7" data-reveal style="--reveal-delay:100ms">
            <div class="flex items-end justify-between">
                <x-ui.section-header eyebrow="Campus Life" title="News &amp; Events" />
                <a href="{{ url('/news') }}" class="pb-1 text-sm font-medium text-primary-700 hover:text-primary-800">All →</a>
            </div>
            <div class="mt-10 grid gap-x-8 gap-y-10 sm:grid-cols-2">
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
        <section class="border-t border-slate-200 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
                <div data-reveal><x-ui.section-header eyebrow="From the leadership" title="Guided by vision and integrity." /></div>
                <div class="mt-12 grid gap-px border border-slate-200 bg-slate-200 md:grid-cols-2">
                    @foreach ($leaders as $leader)
                        <figure class="flex flex-col gap-6 bg-white p-8 sm:flex-row sm:p-10" data-reveal style="--reveal-delay:{{ $loop->index * 100 }}ms">
                            <div class="w-28 flex-none sm:w-32">
                                <x-ui.image-frame :src="$leader['photo']" :alt="$leader['name']" ratio="aspect-4/5" :grayscale="true" />
                            </div>
                            <div class="flex flex-col">
                                <svg class="h-8 w-8 text-primary-200" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 6C6.5 7.5 5 10 5 13v5h5v-5H7.5c0-2 1-3.5 3-4.5L9.5 6zm9 0c-3 1.5-4.5 4-4.5 7v5h5v-5H16c0-2 1-3.5 3-4.5L18.5 6z"/></svg>
                                <blockquote class="mt-3 text-lg font-medium leading-snug tracking-tight text-ink-900">{{ $leader['quote'] }}</blockquote>
                                <figcaption class="mt-auto pt-6">
                                    <div class="text-base font-semibold text-ink-900">{{ $leader['name'] }}</div>
                                    <div class="text-sm text-slate-500">{{ $leader['position'] }}</div>
                                    @if (! empty($leader['link']))
                                        <a href="{{ url($leader['link']) }}" class="mt-2 inline-flex items-center gap-1 text-sm font-medium text-primary-700 hover:text-primary-800">
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
    <section class="relative overflow-hidden bg-ink-900">
        <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
             style="background-image: repeating-linear-gradient(135deg, #fff 0px, #fff 1px, transparent 1px, transparent 18px);"></div>
        <div class="relative mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-4 py-16 lg:flex-row lg:items-center lg:px-6">
            <div>
                <h2 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">Begin your journey at NPIUB.</h2>
                <p class="mt-3 text-lg text-slate-400">Admissions are open — take the first step toward a career that matters.</p>
            </div>
            <div class="flex flex-none gap-3">
                <x-ui.button href="{{ url('/admissions') }}" variant="white" size="lg">Apply Now</x-ui.button>
                <x-ui.button href="{{ url('/contact') }}" variant="outline" size="lg" class="border-white/30 text-white hover:border-white">Contact</x-ui.button>
            </div>
        </div>
    </section>
</x-layouts.app>
