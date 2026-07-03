@php
    use App\Models\Department;
    use App\Models\Person;

    $departments = Department::activeNav();
    $offices = Person::leadershipNav();

    // Menu structure mirrors the previous NPIUB site, mapped to the new routes.
    $academics = collect();
    foreach ($departments as $d) {
        $academics->push(['label' => $d->name, 'url' => url('/departments/'.$d->slug)]);
    }
    $academics = $academics->merge([
        ['label' => 'News & Events', 'url' => url('/news')],
        ['label' => 'Gallery', 'url' => url('/galleries')],
        ['label' => 'Alumni', 'url' => url('/alumni')],
        ['label' => 'Research', 'url' => url('/research')],
    ]);

    $officeLinks = collect($offices)->map(fn ($o) => ['label' => $o->position ?: $o->name, 'url' => url('/offices/'.$o->slug)]);

    $menus = [
        'About' => [
            ['label' => 'Vision & Mission', 'url' => url('/vision-mission')],
            ['label' => 'Academic Council', 'url' => url('/academic-council')],
            ['label' => 'Syndicate', 'url' => url('/syndicate')],
            ['label' => 'Board of Trustees', 'url' => url('/board-of-trustees')],
            ['label' => 'Contact Us', 'url' => url('/contact')],
        ],
        'Academics' => $academics->all(),
        'Admissions' => [
            ['label' => 'Admissions Overview', 'url' => url('/admissions')],
            ['label' => 'Undergraduate Programs', 'url' => url('/admissions')],
            ['label' => 'Graduate Programs', 'url' => url('/admissions')],
            ['label' => 'Admission FAQs', 'url' => url('/faqs')],
            ['label' => 'Forms & Downloads', 'url' => url('/downloads')],
        ],
    ];
    if ($officeLinks->isNotEmpty()) {
        $menus['Offices'] = $officeLinks->all();
    }

    $link = 'text-sm text-slate-600 transition hover:text-ink-900';
    $iems = 'https://npiub.pipilikasoft.com/';
@endphp

<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 lg:px-6">
        <a href="{{ url('/') }}" class="flex items-center gap-3 py-4">
            <x-brand.logo class="h-11 w-auto" />
            <span class="hidden leading-none sm:block">
                <span class="block font-display text-base font-semibold tracking-tight text-ink-900">NPI University</span>
                <span class="mt-1 block text-[10px] uppercase tracking-[0.22em] text-slate-400">of Bangladesh</span>
            </span>
        </a>

        <nav class="hidden items-center gap-6 lg:flex" aria-label="Primary">
            <a href="{{ url('/') }}" class="{{ $link }}">Home</a>

            @foreach ($menus as $title => $items)
                <div x-data="{ open: false }" class="relative" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="{{ $link }} flex items-center gap-1" :aria-expanded="open">
                        {{ $title }}
                        <svg class="h-3.5 w-3.5 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition.origin.top class="absolute left-0 mt-3 w-72 border border-slate-200 bg-white p-2 shadow-lg">
                        @foreach ($items as $item)
                            <a href="{{ $item['url'] }}" class="block truncate px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50 hover:text-ink-900">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <a href="{{ url('/notices') }}" class="{{ $link }}">Notices</a>
            <a href="{{ url('/contact') }}" class="{{ $link }}">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ url('/search') }}" aria-label="Search" class="hidden p-2 text-slate-500 transition hover:text-ink-900 sm:block">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            </a>
            <a href="{{ $iems }}" target="_blank" rel="noopener" class="hidden rounded-md border border-slate-300 px-3.5 py-2 text-sm font-medium text-ink-900 transition hover:border-ink-900 md:inline-flex">i-EMS</a>
            <x-ui.button href="{{ url('/admissions') }}" size="sm" class="hidden sm:inline-flex">Apply</x-ui.button>
            <button @click="mobileOpen = !mobileOpen" class="-mr-2 p-2 text-ink-900 lg:hidden" aria-label="Toggle menu" :aria-expanded="mobileOpen">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak x-transition class="max-h-[80vh] overflow-y-auto border-t border-slate-200 lg:hidden">
        <nav class="space-y-1 px-4 py-4" aria-label="Mobile">
            <a href="{{ url('/') }}" class="block py-2 text-sm text-slate-700">Home</a>
            @foreach ($menus as $title => $items)
                <details class="group">
                    <summary class="flex cursor-pointer items-center justify-between py-2 text-sm text-slate-700">{{ $title }}</summary>
                    <div class="ml-3 border-l border-slate-200 pl-3">
                        @foreach ($items as $item)
                            <a href="{{ $item['url'] }}" class="block py-2 text-sm text-slate-600">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </details>
            @endforeach
            <a href="{{ url('/notices') }}" class="block py-2 text-sm text-slate-700">Notices</a>
            <a href="{{ url('/contact') }}" class="block py-2 text-sm text-slate-700">Contact</a>
            <div class="flex gap-3 pt-3">
                <a href="{{ $iems }}" target="_blank" rel="noopener" class="flex-1 rounded-md border border-slate-300 px-3.5 py-2 text-center text-sm font-medium text-ink-900">i-EMS</a>
                <x-ui.button href="{{ url('/admissions') }}" size="sm" class="flex-1">Apply</x-ui.button>
            </div>
        </nav>
    </div>
</header>
