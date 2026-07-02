@php
    $departments = \App\Models\Department::query()
        ->where('is_active', true)->orderBy('priority')->orderBy('name')->get(['name', 'slug']);

    $navLinks = [
        ['label' => 'About', 'url' => url('/about')],
        ['label' => 'Admissions', 'url' => url('/admissions')],
        ['label' => 'Faculty', 'url' => url('/faculty')],
        ['label' => 'Notices', 'url' => url('/notices')],
        ['label' => 'News', 'url' => url('/news')],
        ['label' => 'Contact', 'url' => url('/contact')],
    ];

    $linkClass = 'relative rounded px-3 py-2 text-sm font-medium text-slate-700 transition after:absolute after:inset-x-3 after:-bottom-0.5 after:h-0.5 after:origin-left after:scale-x-0 after:bg-gold-500 after:transition-transform hover:text-primary-700 hover:after:scale-x-100';
@endphp

<header x-data="{ mobileOpen: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 8"
        class="sticky top-0 z-40">
    {{-- Utility bar --}}
    <div class="bg-ink-700 text-xs text-primary-50/90">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
            <div class="flex items-center gap-5">
                <span class="hidden items-center gap-1.5 sm:flex">
                    <svg class="h-3.5 w-3.5 text-gold-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    {{ \App\Models\SiteSetting::get('contact', 'phone', '+880 1XXX-XXXXXX') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-gold-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    {{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ url('/notices') }}" class="hidden hover:text-white sm:inline">Notices</a>
                <span class="hidden h-3 w-px bg-white/20 sm:inline-block"></span>
                <button type="button" class="font-semibold text-gold-300 hover:text-gold-200">বাংলা</button>
            </div>
        </div>
    </div>

    {{-- Main nav --}}
    <div class="border-b border-slate-200 bg-white/95 backdrop-blur transition-shadow"
         :class="scrolled ? 'shadow-md' : ''">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <x-brand.logo class="h-14 w-auto" />
                <span class="hidden border-l border-slate-200 pl-3 leading-tight sm:block">
                    <span class="block font-display text-lg font-semibold text-ink-700">NPI University</span>
                    <span class="block text-[11px] uppercase tracking-[0.2em] text-gold-600">of Bangladesh</span>
                </span>
            </a>

            <nav class="hidden items-center gap-0.5 lg:flex" aria-label="Primary">
                <a href="{{ url('/') }}" class="{{ $linkClass }}">Home</a>

                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="{{ $linkClass }} flex items-center gap-1" :aria-expanded="open">
                        Academics
                        <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition.origin.top class="absolute left-0 mt-2 w-72 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xl ring-1 ring-black/5">
                        <div class="bg-ink-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-widest text-gold-300">Departments</div>
                        <div class="p-2">
                            @forelse ($departments as $dept)
                                <a href="{{ url('/departments/'.$dept->slug) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-slate-700 transition hover:bg-primary-50 hover:text-primary-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-500"></span>{{ $dept->name }}
                                </a>
                            @empty
                                <span class="block px-3 py-2 text-sm text-slate-400">Coming soon</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @foreach ($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="{{ $linkClass }}">{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ url('/admissions') }}" size="sm" class="hidden sm:inline-flex">Apply Now</x-ui.button>
                <button @click="mobileOpen = !mobileOpen" class="rounded-lg p-2 text-slate-700 hover:bg-slate-100 lg:hidden" aria-label="Toggle menu" :aria-expanded="mobileOpen">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileOpen" x-cloak x-transition class="border-t border-slate-200 lg:hidden">
            <nav class="space-y-1 px-4 py-3" aria-label="Mobile">
                <a href="{{ url('/') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">Home</a>
                <details class="group">
                    <summary class="flex cursor-pointer items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">Academics</summary>
                    <div class="ml-3 border-l border-slate-200 pl-3">
                        @foreach ($departments as $dept)
                            <a href="{{ url('/departments/'.$dept->slug) }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-primary-50">{{ $dept->name }}</a>
                        @endforeach
                    </div>
                </details>
                @foreach ($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">{{ $link['label'] }}</a>
                @endforeach
                <x-ui.button href="{{ url('/admissions') }}" size="sm" class="mt-2 w-full">Apply Now</x-ui.button>
            </nav>
        </div>
    </div>
</header>
