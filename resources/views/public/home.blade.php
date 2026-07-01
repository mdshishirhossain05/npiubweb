<x-public-layout :description="'Official website of NPI University of Bangladesh — programmes, departments, news, notices and events.'">

    {{-- ===================== HERO CAROUSEL ===================== --}}
    <section
        x-data="{
            active: 0,
            count: {{ max($slides->count(), 1) }},
            next() { this.active = (this.active + 1) % this.count },
            prev() { this.active = (this.active - 1 + this.count) % this.count },
        }"
        x-init="setInterval(() => next(), 6500)"
        class="relative h-screen min-h-[620px] w-full overflow-hidden bg-blue-950"
    >
        @forelse ($slides as $index => $slide)
            <div x-show="active === {{ $index }}" x-transition.opacity.duration.1000ms class="absolute inset-0">
                <div class="absolute inset-0 animate-kenburns bg-cover bg-center"
                     style="background-image: url('{{ $slide->imageUrl() ?: 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22/%3E' }}'); {{ $slide->imageUrl() ? '' : 'background:linear-gradient(135deg,#0c1b4d,#1e3a8a 60%,#0c1b4d);' }}"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-950/95 via-blue-950/70 to-blue-950/30"></div>
            </div>
        @empty
            <div class="absolute inset-0" style="background:linear-gradient(135deg,#0c1b4d,#1e3a8a 60%,#0c1b4d);"></div>
        @endforelse

        <div class="bg-grid absolute inset-0 opacity-40"></div>

        <div class="relative mx-auto flex h-full max-w-7xl items-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                @forelse ($slides as $index => $slide)
                    <div x-show="active === {{ $index }}"
                         x-transition:enter="transition ease-out duration-700 delay-200"
                         x-transition:enter-start="opacity-0 translate-y-6"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="inline-flex items-center gap-2 rounded-full border border-amber-400/40 bg-amber-400/10 px-4 py-1.5 text-sm font-semibold text-amber-300">
                            {{ $slide->subtitle ?: 'NPI University of Bangladesh' }}
                        </p>
                        <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-6xl">
                            {{ $slide->title ?: 'Shaping the next generation of leaders' }}
                        </h1>
                    </div>
                @empty
                    <p class="inline-flex items-center gap-2 rounded-full border border-amber-400/40 bg-amber-400/10 px-4 py-1.5 text-sm font-semibold text-amber-300">
                        Welcome to NPI University of Bangladesh
                    </p>
                    <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-6xl">
                        Shaping the next generation of leaders
                    </h1>
                @endforelse

                <p class="mt-6 max-w-xl text-lg text-blue-100">
                    Quality education, world-class research and a vibrant campus community —
                    discover where your future begins.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('departments.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3.5 text-sm font-semibold text-blue-950 shadow-xl shadow-amber-500/25 transition hover:bg-amber-400">
                        Explore Programmes <span>&rarr;</span>
                    </a>
                    <a href="{{ route('posts.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-white/30 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                        Latest News
                    </a>
                </div>
            </div>
        </div>

        @if ($slides->count() > 1)
            <div class="absolute inset-x-0 bottom-8 z-10 flex justify-center gap-2.5">
                @foreach ($slides as $index => $slide)
                    <button @click="active = {{ $index }}"
                            :class="active === {{ $index }} ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/40'"
                            class="h-2.5 rounded-full transition-all duration-300"
                            aria-label="Go to slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ===================== STATS BAND ===================== --}}
    <section class="relative z-10 -mt-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-6 rounded-2xl bg-blue-900 px-8 py-10 shadow-2xl shadow-blue-950/30 lg:grid-cols-4">
                <x-public.stat :value="5000" label="Students" />
                <x-public.stat :value="max($departments->count(), 4) * 6" label="Programmes" />
                <x-public.stat :value="150" label="Faculty" />
                <x-public.stat :value="25" label="Years of Excellence" />
            </div>
        </div>
    </section>

    {{-- ===================== WHY CHOOSE US ===================== --}}
    <section class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <x-public.reveal class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-amber-600">Why NPIUB</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">An education built for the real world</h2>
            <p class="mt-4 text-lg text-slate-600">Everything you need to learn, grow and launch a career you love.</p>
        </x-public.reveal>

        <div class="mt-16 grid gap-8 md:grid-cols-3">
            @php
                $features = [
                    ['icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42a12 12 0 01.84 4.42 12 12 0 01-7 1 12 12 0 01-7-1 12 12 0 01.84-4.42L12 14z', 'title' => 'Academic Excellence', 'body' => 'Rigorous, industry-aligned programmes taught by experienced faculty and researchers.'],
                    ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-3m-9 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1', 'title' => 'Modern Campus', 'body' => 'State-of-the-art labs, libraries and facilities designed for hands-on learning.'],
                    ['icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4z', 'title' => 'Vibrant Community', 'body' => 'A diverse, supportive community where every student belongs and thrives.'],
                ];
            @endphp
            @foreach ($features as $i => $feature)
                <x-public.reveal :delay="$i * 120">
                    <div class="group h-full rounded-2xl border border-slate-200 bg-white p-8 transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl">
                        <div class="grid h-14 w-14 place-items-center rounded-xl bg-blue-50 text-blue-700 transition group-hover:bg-blue-700 group-hover:text-white">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-bold text-slate-900">{{ $feature['title'] }}</h3>
                        <p class="mt-3 text-slate-600">{{ $feature['body'] }}</p>
                    </div>
                </x-public.reveal>
            @endforeach
        </div>
    </section>

    {{-- ===================== LATEST NEWS ===================== --}}
    @if ($posts->isNotEmpty())
        <section class="bg-white py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-public.heading eyebrow="From the campus" title="Latest News" :link="route('posts.index')" />

                <div class="mt-12 grid gap-8 lg:grid-cols-3">
                    @foreach ($posts->take(3) as $i => $post)
                        <x-public.reveal :delay="$i * 100">
                            <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-xl">
                                <a href="{{ route('posts.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden">
                                    @if ($post->featuredImageUrl())
                                        <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}"
                                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-800 to-blue-950 text-3xl font-bold text-white/20">NPIUB</div>
                                    @endif
                                    @if ($post->category)
                                        <span class="absolute left-4 top-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold text-blue-950">{{ $post->category->name }}</span>
                                    @endif
                                </a>
                                <div class="flex flex-1 flex-col p-6">
                                    <p class="text-xs font-medium text-slate-400">{{ optional($post->published_at)->format('F j, Y') }}</p>
                                    <h3 class="mt-2 text-lg font-bold text-slate-900">
                                        <a href="{{ route('posts.show', $post) }}" class="transition hover:text-blue-700">{{ $post->title }}</a>
                                    </h3>
                                    @if ($post->excerpt)
                                        <p class="mt-3 line-clamp-3 text-sm text-slate-600">{{ $post->excerpt }}</p>
                                    @endif
                                    <a href="{{ route('posts.show', $post) }}" class="mt-4 inline-flex items-center gap-1 pt-2 text-sm font-semibold text-blue-700">
                                        Read more <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                                    </a>
                                </div>
                            </article>
                        </x-public.reveal>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== NOTICES + EVENTS ===================== --}}
    <section class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <x-public.reveal>
                <x-public.heading eyebrow="Stay informed" title="Notices" :link="route('notices.index')" />
                @if ($notices->isEmpty())
                    <x-public.empty class="mt-8" message="No notices yet." />
                @else
                    <ul class="mt-8 space-y-3">
                        @foreach ($notices as $notice)
                            <li>
                                <a href="{{ route('notices.show', $notice) }}"
                                   class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-blue-200 hover:shadow-md">
                                    <div class="grid h-14 w-14 shrink-0 place-items-center rounded-lg bg-blue-50 text-center">
                                        <span class="text-lg font-bold leading-none text-blue-700">{{ optional($notice->notice_date)->format('j') }}</span>
                                        <span class="text-[10px] uppercase text-slate-400">{{ optional($notice->notice_date)->format('M') }}</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        @if ($notice->is_pinned)
                                            <span class="rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold uppercase text-amber-700">Pinned</span>
                                        @endif
                                        <p class="truncate font-medium text-slate-800">{{ $notice->title }}</p>
                                    </div>
                                    <span class="text-slate-300 transition group-hover:text-blue-700">&rarr;</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-public.reveal>

            <x-public.reveal :delay="120">
                <x-public.heading eyebrow="Mark your calendar" title="Upcoming Events" :link="route('events.index')" />
                @if ($events->isEmpty())
                    <x-public.empty class="mt-8" message="No upcoming events scheduled." />
                @else
                    <div class="mt-8 space-y-4">
                        @foreach ($events as $event)
                            <a href="{{ route('events.show', $event) }}"
                               class="flex items-center gap-5 rounded-xl border border-slate-200 bg-white p-5 transition hover:border-blue-200 hover:shadow-md">
                                <div class="grid h-16 w-16 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-blue-700 to-blue-900 text-center text-white">
                                    <span class="text-xl font-bold leading-none">{{ optional($event->starts_at)->format('j') }}</span>
                                    <span class="text-[10px] uppercase opacity-80">{{ optional($event->starts_at)->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $event->title }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ optional($event->starts_at)->format('g:i A') }}
                                        @if ($event->location) · 📍 {{ $event->location }} @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </x-public.reveal>
        </div>
    </section>

    {{-- ===================== DEPARTMENTS ===================== --}}
    @if ($departments->isNotEmpty())
        <section class="bg-slate-100 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-public.heading eyebrow="Find your field" title="Academic Departments" :link="route('departments.index')" />
                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($departments->take(6) as $i => $department)
                        <x-public.reveal :delay="($i % 3) * 100">
                            <a href="{{ route('departments.show', $department) }}"
                               class="group flex h-full items-start gap-4 rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl">
                                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-blue-700 font-bold text-white">
                                    {{ \Illuminate\Support\Str::substr($department->short_name ?: $department->name, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 transition group-hover:text-blue-700">{{ $department->name }}</h3>
                                    @if ($department->short_name)
                                        <p class="text-sm text-slate-500">{{ $department->short_name }}</p>
                                    @endif
                                </div>
                            </a>
                        </x-public.reveal>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== CTA BAND ===================== --}}
    <section class="relative overflow-hidden bg-blue-950">
        <div class="bg-grid absolute inset-0 opacity-40"></div>
        <div class="absolute -left-20 bottom-0 h-72 w-72 rounded-full bg-amber-500/20 blur-3xl"></div>
        <div class="relative mx-auto max-w-4xl px-4 py-20 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Ready to begin your journey?</h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-blue-100">
                Join a community committed to your success. Explore our programmes and take the first step today.
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('departments.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-7 py-3.5 text-sm font-semibold text-blue-950 shadow-xl shadow-amber-500/25 transition hover:bg-amber-400">
                    Explore Programmes <span>&rarr;</span>
                </a>
                <a href="{{ route('faculty.index') }}"
                   class="inline-flex items-center rounded-lg border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                    Meet our Faculty
                </a>
            </div>
        </div>
    </section>
</x-public-layout>
