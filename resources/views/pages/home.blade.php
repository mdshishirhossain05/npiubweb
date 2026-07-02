<x-layouts.app :title="config('app.name').' — Official Website'">
    {{-- Hero --}}
    @if ($sliders->isNotEmpty())
        <section x-data="{ active: 0, count: {{ $sliders->count() }} }" class="relative bg-slate-900">
            @foreach ($sliders as $i => $slider)
                <div x-show="active === {{ $i }}" x-transition.opacity.duration.700ms class="relative">
                    <img src="{{ $slider->getFirstMediaUrl('image', 'web') ?: $slider->getFirstMediaUrl('image') }}"
                         alt="{{ $slider->title }}" class="h-[420px] w-full object-cover opacity-70 sm:h-[520px]">
                    <div class="absolute inset-0 flex items-center bg-gradient-to-r from-slate-900/80 to-transparent">
                        <div class="mx-auto w-full max-w-7xl px-4">
                            <div class="max-w-xl text-white">
                                @if ($slider->title)<h1 class="text-3xl font-extrabold sm:text-5xl">{{ $slider->title }}</h1>@endif
                                @if ($slider->subtitle)<p class="mt-4 text-lg text-slate-200">{{ $slider->subtitle }}</p>@endif
                                @if ($slider->cta_url)<x-ui.button href="{{ $slider->cta_url }}" size="lg" class="mt-6">{{ $slider->cta_label ?? 'Learn more' }}</x-ui.button>@endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @else
        <section class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-600 to-secondary-700">
            <div class="mx-auto max-w-7xl px-4 py-24 sm:py-32">
                <div class="max-w-2xl text-white">
                    <span class="inline-block rounded-full bg-white/15 px-3 py-1 text-sm font-medium">NPI University of Bangladesh</span>
                    <h1 class="mt-4 text-4xl font-extrabold leading-tight sm:text-5xl">Shaping skilled graduates for a stronger Bangladesh</h1>
                    <p class="mt-5 text-lg text-primary-50">Quality education, modern facilities, and dedicated faculty across engineering, business, and the arts.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <x-ui.button href="{{ url('/admissions') }}" variant="white" size="lg">Apply for Admission</x-ui.button>
                        <x-ui.button href="{{ url('/about') }}" variant="outline" size="lg" class="border-white text-white hover:bg-white/10">Discover NPIUB</x-ui.button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Stats band --}}
    <section class="bg-primary-700">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-10 sm:grid-cols-4">
            @foreach ($stats as $stat)
                <x-ui.stat :value="$stat['value']" :label="$stat['label']" />
            @endforeach
        </div>
    </section>

    {{-- Featured programs --}}
    <section class="mx-auto max-w-7xl px-4 py-16">
        <x-ui.section-header title="Featured Programs" subtitle="Explore our undergraduate and graduate programs designed for the modern workforce." align="center" />
        @if ($programs->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($programs as $program)
                    <x-cards.program-card :program="$program" />
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-500">Programs will appear here once added in the admin panel.</p>
        @endif
    </section>

    {{-- Notices + News --}}
    <section class="bg-slate-50 py-16">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 lg:grid-cols-2">
            <div>
                <x-ui.section-header title="Latest Notices" />
                <div class="space-y-3">
                    @forelse ($notices as $notice)
                        <x-cards.notice-item :notice="$notice" />
                    @empty
                        <p class="text-slate-500">No notices yet.</p>
                    @endforelse
                </div>
                <x-ui.button href="{{ url('/notices') }}" variant="ghost" class="mt-4">All notices →</x-ui.button>
            </div>
            <div>
                <x-ui.section-header title="News & Events" />
                <div class="grid gap-5 sm:grid-cols-2">
                    @forelse ($news as $article)
                        <x-cards.news-card :article="$article" />
                    @empty
                        <p class="text-slate-500">No news yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Leadership message --}}
    @if ($leadership)
        <section class="mx-auto max-w-7xl px-4 py-16">
            <div class="grid items-center gap-10 rounded-2xl bg-secondary-50 p-8 sm:p-12 lg:grid-cols-3">
                <div class="mx-auto max-w-xs text-center">
                    @php $vc = $leadership->getFirstMediaUrl('photo', 'thumb') ?: $leadership->getFirstMediaUrl('photo'); @endphp
                    <div class="aspect-square overflow-hidden rounded-xl bg-secondary-100">
                        @if ($vc)<img src="{{ $vc }}" alt="{{ $leadership->name }}" class="h-full w-full object-cover">@endif
                    </div>
                    <h3 class="mt-4 font-bold text-slate-900">{{ $leadership->name }}</h3>
                    <p class="text-sm text-secondary-700">{{ $leadership->position }}</p>
                </div>
                <div class="lg:col-span-2">
                    <x-ui.section-header title="Message from Leadership" />
                    <p class="leading-relaxed text-slate-700">{{ \Illuminate\Support\Str::limit(strip_tags($leadership->biography), 400) ?: 'Welcome to NPI University of Bangladesh.' }}</p>
                </div>
            </div>
        </section>
    @endif

    {{-- CTA band --}}
    <section class="bg-secondary-700">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 py-12 text-center sm:flex-row sm:text-left">
            <div class="text-white">
                <h2 class="text-2xl font-bold">Ready to begin your journey?</h2>
                <p class="mt-1 text-secondary-100">Admissions are open. Apply today or reach out to our team.</p>
            </div>
            <div class="flex gap-3">
                <x-ui.button href="{{ url('/admissions') }}" variant="white" size="lg">Apply Now</x-ui.button>
                <x-ui.button href="{{ url('/contact') }}" variant="outline" size="lg" class="border-white text-white hover:bg-white/10">Contact Us</x-ui.button>
            </div>
        </div>
    </section>
</x-layouts.app>
