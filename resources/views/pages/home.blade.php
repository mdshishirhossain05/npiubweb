<x-layouts.app :title="config('app.name').' — Official Website'">
    @php $heroImg = optional($sliders->first(fn ($s) => $s->getFirstMediaUrl('image')))?->getFirstMediaUrl('image'); @endphp

    {{-- ============ HERO ============ --}}
    <section class="mx-auto max-w-7xl px-4 lg:px-6">
        <div class="grid items-center gap-10 py-14 lg:grid-cols-12 lg:gap-12 lg:py-24">
            <div class="lg:col-span-7">
                <span class="eyebrow">NPI University of Bangladesh · Est. 2016</span>
                <h1 class="mt-6 text-5xl font-semibold leading-[1.02] tracking-tight text-ink-900 sm:text-6xl lg:text-7xl">
                    Knowledge<br>for a purposeful<br><span class="text-primary-600">future.</span>
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
            <div class="lg:col-span-5">
                <x-ui.image-frame :src="$heroImg ?: null" alt="NPIUB campus" ratio="aspect-4/5" />
            </div>
        </div>

        {{-- stats row, hairline separated --}}
        <div class="grid grid-cols-2 divide-x divide-slate-200 border-y border-slate-200 sm:grid-cols-4">
            @foreach ($stats as $i => $stat)
                <div class="px-6 py-8 {{ $i === 0 ? 'pl-0' : '' }}">
                    <x-ui.stat :value="$stat['value']" :label="$stat['label']" />
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ INTRO ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
        <div class="grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <span class="eyebrow">Who we are</span>
                <h2 class="mt-5 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">A university built for the real world.</h2>
            </div>
            <div class="lg:col-span-6 lg:col-start-7">
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

    {{-- ============ PROGRAMS ============ --}}
    @if ($programs->isNotEmpty())
        <section class="border-t border-slate-200 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-ui.section-header eyebrow="Academics" title="Programs" />
                    <x-ui.button href="{{ url('/admissions') }}" variant="outline">All programs</x-ui.button>
                </div>
                <div class="mt-12 grid gap-px bg-slate-200 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $i => $program)
                        <div class="bg-slate-50"><x-cards.program-card :program="$program" :index="$i + 1" /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ DEPARTMENTS (big type list) ============ --}}
    @if ($departments->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
            <x-ui.section-header eyebrow="Faculties & Departments" title="Where you'll study." />
            <div class="mt-12 border-t border-slate-200">
                @foreach ($departments as $dept)
                    <a href="{{ url('/departments/'.$dept->slug) }}" class="group flex items-center justify-between gap-6 border-b border-slate-200 py-7 transition hover:px-4">
                        <div class="flex items-baseline gap-6">
                            <span class="font-display text-sm text-slate-400">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="text-2xl font-semibold tracking-tight text-ink-900 transition group-hover:text-primary-700 sm:text-3xl">{{ $dept->name }}</h3>
                        </div>
                        <svg class="h-6 w-6 flex-none text-slate-300 transition group-hover:translate-x-1 group-hover:text-ink-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============ NOTICES + NEWS ============ --}}
    <section class="border-t border-slate-200 bg-slate-50">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-20 lg:grid-cols-12 lg:px-6 lg:py-28">
            <div class="lg:col-span-5">
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
            <div class="lg:col-span-6 lg:col-start-7">
                <div class="flex items-end justify-between">
                    <x-ui.section-header eyebrow="Campus Life" title="News & Events" />
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
        </div>
    </section>

    {{-- ============ LEADERSHIP QUOTE ============ --}}
    @if ($leadership)
        <section class="mx-auto max-w-7xl px-4 py-20 lg:px-6 lg:py-28">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-3">
                    <x-ui.image-frame :src="$leadership->getFirstMediaUrl('photo', 'thumb') ?: null" :alt="$leadership->name" ratio="aspect-4/5" :grayscale="true" />
                    <h3 class="mt-5 text-lg font-semibold tracking-tight text-ink-900">{{ $leadership->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $leadership->position }}</p>
                </div>
                <div class="lg:col-span-8 lg:col-start-5">
                    <span class="eyebrow">From the leadership</span>
                    <blockquote class="mt-6 text-2xl font-medium leading-snug tracking-tight text-ink-900 sm:text-3xl">
                        “{{ \Illuminate\Support\Str::limit(strip_tags($leadership->biography), 280) ?: 'Welcome to NPI University of Bangladesh.' }}”
                    </blockquote>
                    <x-ui.button href="{{ url('/about') }}" variant="link" class="mt-8">
                        Read more about us
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </x-ui.button>
                </div>
            </div>
        </section>
    @endif

    {{-- ============ CTA ============ --}}
    <section class="bg-ink-900">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-4 py-16 lg:flex-row lg:items-center lg:px-6">
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
