<x-layouts.app :title="config('app.name').' — Official Website'">
    {{-- ===================== HERO ===================== --}}
    @php $heroSlider = $sliders->first(fn ($s) => $s->getFirstMediaUrl('image')); @endphp

    @if ($heroSlider)
        <section x-data="{ active: 0, count: {{ $sliders->count() }} }"
                 x-init="setInterval(() => active = (active + 1) % count, 6000)"
                 class="relative bg-ink-800">
            @foreach ($sliders as $i => $slider)
                <div x-show="active === {{ $i }}" x-transition.opacity.duration.700ms>
                    <img src="{{ $slider->getFirstMediaUrl('image', 'web') ?: $slider->getFirstMediaUrl('image') }}" alt="{{ $slider->title }}" class="h-[540px] w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-ink-900/90 via-ink-800/70 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="mx-auto w-full max-w-7xl px-4">
                            <div class="max-w-xl text-white">
                                <span class="kicker !text-gold-300">NPI University of Bangladesh</span>
                                @if ($slider->title)<h1 class="mt-4 font-display text-4xl font-semibold sm:text-6xl">{{ $slider->title }}</h1>@endif
                                @if ($slider->subtitle)<p class="mt-5 text-lg text-primary-100">{{ $slider->subtitle }}</p>@endif
                                @if ($slider->cta_url)<x-ui.button href="{{ $slider->cta_url }}" variant="gold" size="lg" class="mt-8">{{ $slider->cta_label ?? 'Learn more' }}</x-ui.button>@endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @else
        <section class="relative overflow-hidden bg-grid-ink">
            {{-- ambient glows + crest watermark --}}
            <div class="pointer-events-none absolute -left-24 -top-24 h-96 w-96 rounded-full bg-primary-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 right-0 h-96 w-96 rounded-full bg-secondary-500/20 blur-3xl"></div>
            <x-brand.motif class="pointer-events-none absolute right-6 top-1/2 hidden h-[32rem] w-[32rem] -translate-y-1/2 text-white/5 lg:block" />

            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 lg:grid-cols-12 lg:py-28">
                <div class="text-white lg:col-span-7">
                    <span class="kicker !text-gold-300">Est. 2016 · Rajshahi, Bangladesh</span>
                    <h1 class="mt-5 font-display text-4xl font-semibold leading-[1.08] sm:text-5xl lg:text-6xl">
                        Where knowledge meets
                        <span class="relative whitespace-nowrap text-gold-300">purpose
                            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 12" fill="none" preserveAspectRatio="none"><path d="M2 9C60 3 140 3 198 9" stroke="currentColor" stroke-width="3" stroke-linecap="round" class="text-gold-500"/></svg>
                        </span>
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-primary-100">
                        A modern university shaping skilled, ethical graduates across engineering, business, and the arts — with hands-on learning and dedicated faculty.
                    </p>
                    <div class="mt-9 flex flex-wrap gap-3">
                        <x-ui.button href="{{ url('/admissions') }}" variant="gold" size="lg">Apply for Admission</x-ui.button>
                        <x-ui.button href="{{ url('/about') }}" variant="outline" size="lg" class="border-white/40 text-white hover:bg-white/10">
                            Discover NPIUB
                        </x-ui.button>
                    </div>
                    <div class="mt-10 flex items-center gap-6 text-sm text-primary-100/80">
                        <span class="flex items-center gap-2"><span class="text-gold-400">✓</span> UGC-recognized</span>
                        <span class="flex items-center gap-2"><span class="text-gold-400">✓</span> Industry-aligned curriculum</span>
                    </div>
                </div>

                {{-- floating info card --}}
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-sm rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-sm">
                        <div class="rounded-xl bg-white p-5 shadow-2xl">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-accent-50 text-accent-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6"/></svg>
                                </span>
                                <div>
                                    <p class="font-display font-semibold text-ink-700">Admissions Open</p>
                                    <p class="text-xs text-slate-500">Spring 2026 intake</p>
                                </div>
                            </div>
                            <ul class="mt-4 space-y-2.5 text-sm text-slate-600">
                                <li class="flex items-center gap-2"><span class="text-primary-600">→</span> Undergraduate &amp; graduate programs</li>
                                <li class="flex items-center gap-2"><span class="text-primary-600">→</span> Scholarships available</li>
                                <li class="flex items-center gap-2"><span class="text-primary-600">→</span> Easy online application</li>
                            </ul>
                            <x-ui.button href="{{ url('/admissions') }}" class="mt-5 w-full">Start your application</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats band merged into hero base --}}
            <div class="relative border-t border-white/10 bg-ink-800/60">
                <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-10 sm:grid-cols-4">
                    @foreach ($stats as $stat)
                        <x-ui.stat :value="$stat['value']" :label="$stat['label']" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== WHY NPIUB ===================== --}}
    <section class="mx-auto max-w-7xl px-4 py-20">
        <x-ui.section-header kicker="Why NPIUB" title="An education built for the real world" align="center"
            subtitle="We combine academic rigour with practical skills, modern facilities, and a supportive community." />
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([
                ['t' => 'Expert Faculty', 'd' => 'Learn from experienced educators and industry practitioners dedicated to your success.', 'i' => 'M12 14l9-5-9-5-9 5 9 5z M12 14v7'],
                ['t' => 'Modern Campus', 'd' => 'Well-equipped labs, library, and facilities designed for hands-on, collaborative learning.', 'i' => 'M4 21V9l8-6 8 6v12M9 21v-6h6v6'],
                ['t' => 'Career Outcomes', 'd' => 'Industry-aligned curriculum and strong links that help graduates launch their careers.', 'i' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ] as $f)
                <div class="group rounded-2xl border border-slate-200 bg-white p-8 transition hover:border-primary-200 hover:shadow-lg">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-600 text-white shadow-lg shadow-primary-600/30 transition group-hover:scale-105">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f['i'] }}"/></svg>
                    </div>
                    <h3 class="mt-6 font-display text-xl font-semibold text-ink-700">{{ $f['t'] }}</h3>
                    <p class="mt-2 leading-relaxed text-slate-600">{{ $f['d'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===================== PROGRAMS ===================== --}}
    <section class="border-y border-slate-100 bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-ui.section-header kicker="Academics" title="Explore our programs" class="mb-0" />
                <x-ui.button href="{{ url('/admissions') }}" variant="outline" class="mb-10">View all programs →</x-ui.button>
            </div>
            @if ($programs->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $program)
                        <x-cards.program-card :program="$program" />
                    @endforeach
                </div>
            @else
                <p class="text-slate-500">Programs will appear here once added in the admin panel.</p>
            @endif
        </div>
    </section>

    {{-- ===================== NOTICES + NEWS ===================== --}}
    <section class="mx-auto max-w-7xl px-4 py-20">
        <div class="grid gap-12 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <x-ui.section-header kicker="Notice Board" title="Latest Notices" />
                <div class="space-y-3">
                    @forelse ($notices as $notice)
                        <x-cards.notice-item :notice="$notice" />
                    @empty
                        <p class="text-slate-500">No notices yet.</p>
                    @endforelse
                </div>
                <x-ui.button href="{{ url('/notices') }}" variant="ghost" class="mt-5">All notices →</x-ui.button>
            </div>
            <div class="lg:col-span-3">
                <x-ui.section-header kicker="Campus Life" title="News & Events" />
                <div class="grid gap-6 sm:grid-cols-2">
                    @forelse ($news as $article)
                        <x-cards.news-card :article="$article" />
                    @empty
                        <p class="text-slate-500">No news yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== LEADERSHIP ===================== --}}
    @if ($leadership)
        <section class="relative overflow-hidden bg-grid-ink py-20 text-white">
            <x-brand.motif class="pointer-events-none absolute -left-16 bottom-0 h-80 w-80 text-white/5" />
            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-3">
                <div class="mx-auto max-w-xs text-center lg:mx-0">
                    @php $vc = $leadership->getFirstMediaUrl('photo', 'thumb') ?: $leadership->getFirstMediaUrl('photo'); @endphp
                    <div class="relative">
                        <div class="aspect-square overflow-hidden rounded-2xl border-4 border-white/10 bg-ink-600">
                            @if ($vc)<img src="{{ $vc }}" alt="{{ $leadership->name }}" class="h-full w-full object-cover">
                            @else<div class="flex h-full w-full items-center justify-center font-display text-6xl text-gold-300/70">VC</div>@endif
                        </div>
                        <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 rounded-full bg-gold-500 px-4 py-1 text-xs font-semibold uppercase tracking-wider text-ink-800">{{ $leadership->position }}</span>
                    </div>
                    <h3 class="mt-7 font-display text-xl font-semibold">{{ $leadership->name }}</h3>
                </div>
                <div class="lg:col-span-2">
                    <span class="kicker !text-gold-300">From the Desk of Leadership</span>
                    <svg class="mt-4 h-12 w-12 text-gold-500/60" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 8C6.5 8 4 10.5 4 13.5S6.5 19 9.5 19c.3 0 .5-.2.5-.5s-.2-.5-.5-.5C7 18 5 16 5 13.5S7 9 9.5 9h.5V8h-.5zM19 8c-3 0-5.5 2.5-5.5 5.5S16 19 19 19c.3 0 .5-.2.5-.5s-.2-.5-.5-.5c-2.5 0-4.5-2-4.5-4.5S16.5 9 19 9h.5V8H19z"/></svg>
                    <p class="mt-4 font-display text-2xl font-medium leading-relaxed text-primary-50">
                        {{ \Illuminate\Support\Str::limit(strip_tags($leadership->biography), 320) ?: 'Welcome to NPI University of Bangladesh.' }}
                    </p>
                    <x-ui.button href="{{ url('/about') }}" variant="outline" class="mt-8 border-white/40 text-white hover:bg-white/10">Read more about us</x-ui.button>
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== CTA ===================== --}}
    <section class="mx-auto max-w-7xl px-4 py-20">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-700 to-ink-700 px-8 py-14 text-center shadow-xl sm:px-16">
            <x-brand.motif class="pointer-events-none absolute -right-10 -top-10 h-64 w-64 text-white/5" />
            <div class="relative mx-auto max-w-2xl text-white">
                <h2 class="font-display text-3xl font-semibold sm:text-4xl">Begin your journey at NPIUB</h2>
                <p class="mt-4 text-lg text-primary-100">Admissions are open. Take the first step toward a career that matters.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <x-ui.button href="{{ url('/admissions') }}" variant="gold" size="lg">Apply Now</x-ui.button>
                    <x-ui.button href="{{ url('/contact') }}" variant="outline" size="lg" class="border-white/40 text-white hover:bg-white/10">Contact Us</x-ui.button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
