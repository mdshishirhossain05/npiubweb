@php
    $departments = \App\Models\Department::query()
        ->where('is_active', true)
        ->orderBy('priority')
        ->orderBy('name')
        ->get(['name', 'slug']);

    $navLinks = [
        ['label' => 'About', 'url' => url('/about')],
        ['label' => 'Admissions', 'url' => url('/admissions')],
        ['label' => 'Faculty', 'url' => url('/faculty')],
        ['label' => 'Notices', 'url' => url('/notices')],
        ['label' => 'News', 'url' => url('/news')],
        ['label' => 'Contact', 'url' => url('/contact')],
    ];
@endphp

<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40">
    {{-- Utility bar --}}
    <div class="bg-primary-700 text-primary-50">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-1.5 text-xs sm:text-sm">
            <div class="flex items-center gap-4">
                <span class="hidden sm:inline">📞 {{ \App\Models\SiteSetting::get('contact', 'phone', '+880') }}</span>
                <span>✉️ {{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('/admissions') }}" class="font-semibold hover:underline">Apply Now</a>
                <span class="text-primary-300">|</span>
                <button class="hover:underline" type="button">বাংলা</button>
            </div>
        </div>
    </div>

    {{-- Main nav --}}
    <div class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <x-brand.logo class="h-12 w-auto" />
                <span class="hidden leading-tight sm:block">
                    <span class="block text-base font-bold text-slate-900">NPI University</span>
                    <span class="block text-xs text-slate-500">of Bangladesh</span>
                </span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
                <a href="{{ url('/') }}" class="rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700">Home</a>

                {{-- Academics dropdown --}}
                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="flex items-center gap-1 rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700" aria-haspopup="true" :aria-expanded="open">
                        Academics
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition class="absolute left-0 mt-1 w-64 rounded-lg border border-slate-200 bg-white p-2 shadow-lg">
                        <p class="px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-400">Departments</p>
                        @forelse ($departments as $dept)
                            <a href="{{ url('/departments/'.$dept->slug) }}" class="block rounded px-3 py-2 text-sm text-slate-700 hover:bg-primary-50 hover:text-primary-700">{{ $dept->name }}</a>
                        @empty
                            <span class="block px-3 py-2 text-sm text-slate-400">Coming soon</span>
                        @endforelse
                    </div>
                </div>

                @foreach ($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-700">{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <x-ui.button href="{{ url('/admissions') }}" size="sm" class="hidden sm:inline-flex">Admission</x-ui.button>
                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="rounded p-2 text-slate-700 hover:bg-slate-100 lg:hidden" aria-label="Toggle menu" :aria-expanded="mobileOpen">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile drawer --}}
        <div x-show="mobileOpen" x-cloak x-transition class="border-t border-slate-200 lg:hidden">
            <nav class="space-y-1 px-4 py-3" aria-label="Mobile">
                <a href="{{ url('/') }}" class="block rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">Home</a>
                <details class="group">
                    <summary class="flex cursor-pointer items-center justify-between rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">Academics</summary>
                    <div class="ml-3 border-l border-slate-200 pl-3">
                        @foreach ($departments as $dept)
                            <a href="{{ url('/departments/'.$dept->slug) }}" class="block rounded px-3 py-2 text-sm text-slate-600 hover:bg-primary-50">{{ $dept->name }}</a>
                        @endforeach
                    </div>
                </details>
                @foreach ($navLinks as $link)
                    <a href="{{ $link['url'] }}" class="block rounded px-3 py-2 text-sm font-medium text-slate-700 hover:bg-primary-50">{{ $link['label'] }}</a>
                @endforeach
                <x-ui.button href="{{ url('/admissions') }}" size="sm" class="mt-2 w-full">Admission</x-ui.button>
            </nav>
        </div>
    </div>
</header>
