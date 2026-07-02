@php
    $departments = \App\Models\Department::activeNav();

    $navLinks = [
        ['label' => 'About', 'url' => url('/about')],
        ['label' => 'Admissions', 'url' => url('/admissions')],
        ['label' => 'Faculty', 'url' => url('/faculty')],
        ['label' => 'Notices', 'url' => url('/notices')],
        ['label' => 'News', 'url' => url('/news')],
        ['label' => 'Contact', 'url' => url('/contact')],
    ];

    $link = 'text-sm text-slate-600 transition hover:text-ink-900';
@endphp

<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 lg:px-6">
        <a href="{{ url('/') }}" class="flex items-center gap-3 py-4">
            <x-brand.logo class="h-11 w-auto" />
            <span class="hidden leading-none sm:block">
                <span class="block font-display text-base font-semibold tracking-tight text-ink-900">NPI University</span>
                <span class="mt-1 block text-[10px] uppercase tracking-[0.22em] text-slate-400">of Bangladesh</span>
            </span>
        </a>

        <nav class="hidden items-center gap-7 lg:flex" aria-label="Primary">
            <a href="{{ url('/') }}" class="{{ $link }}">Home</a>
            <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                <button @click="open = !open" class="{{ $link }} flex items-center gap-1" :aria-expanded="open">
                    Academics
                    <svg class="h-3.5 w-3.5 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-cloak x-transition.origin.top class="absolute left-1/2 mt-3 w-64 -translate-x-1/2 border border-slate-200 bg-white p-2 shadow-sm">
                    @forelse ($departments as $dept)
                        <a href="{{ url('/departments/'.$dept->slug) }}" class="block px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50 hover:text-ink-900">{{ $dept->name }}</a>
                    @empty
                        <span class="block px-3 py-2 text-sm text-slate-400">Coming soon</span>
                    @endforelse
                </div>
            </div>
            @foreach ($navLinks as $l)
                <a href="{{ $l['url'] }}" class="{{ $link }}">{{ $l['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ url('/search') }}" aria-label="Search" class="hidden p-2 text-slate-500 transition hover:text-ink-900 sm:block">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            </a>
            <x-ui.button href="{{ url('/admissions') }}" size="sm" class="hidden sm:inline-flex">Apply</x-ui.button>
            <button @click="mobileOpen = !mobileOpen" class="-mr-2 p-2 text-ink-900 lg:hidden" aria-label="Toggle menu" :aria-expanded="mobileOpen">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition class="border-t border-slate-200 lg:hidden">
        <nav class="space-y-1 px-4 py-4" aria-label="Mobile">
            <a href="{{ url('/') }}" class="block py-2 text-sm text-slate-700">Home</a>
            <details class="group">
                <summary class="flex cursor-pointer items-center justify-between py-2 text-sm text-slate-700">Academics</summary>
                <div class="ml-3 border-l border-slate-200 pl-3">
                    @foreach ($departments as $dept)
                        <a href="{{ url('/departments/'.$dept->slug) }}" class="block py-2 text-sm text-slate-600">{{ $dept->name }}</a>
                    @endforeach
                </div>
            </details>
            @foreach ($navLinks as $l)
                <a href="{{ $l['url'] }}" class="block py-2 text-sm text-slate-700">{{ $l['label'] }}</a>
            @endforeach
            <x-ui.button href="{{ url('/admissions') }}" size="sm" class="mt-3 w-full">Apply</x-ui.button>
        </nav>
    </div>
</header>
