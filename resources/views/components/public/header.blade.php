@php
    $nav = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'News', 'route' => 'posts.index'],
        ['label' => 'Notices', 'route' => 'notices.index'],
        ['label' => 'Events', 'route' => 'events.index'],
        ['label' => 'Departments', 'route' => 'departments.index'],
        ['label' => 'Faculty', 'route' => 'faculty.index'],
    ];
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 24"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'bg-blue-950/95 shadow-lg backdrop-blur' : 'bg-transparent'"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-amber-500 text-base font-extrabold text-blue-950 shadow-lg shadow-amber-500/20">NP</span>
            <span class="text-lg font-bold leading-tight text-white">
                NPI University<span class="block text-xs font-medium text-blue-200">of Bangladesh</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            @foreach ($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="relative rounded-md px-3.5 py-2 text-sm font-medium text-white/90 transition hover:text-white
                          after:absolute after:inset-x-3.5 after:-bottom-0.5 after:h-0.5 after:origin-left after:scale-x-0 after:bg-amber-400 after:transition-transform hover:after:scale-x-100
                          {{ $active ? 'after:scale-x-100 text-white' : '' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route('departments.index') }}"
               class="ml-2 inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-blue-950 shadow-lg shadow-amber-500/20 transition hover:bg-amber-400">
                Apply Now
            </a>
        </nav>

        <button @click="open = !open"
                class="inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-white/10 lg:hidden"
                aria-label="Toggle navigation">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-collapse class="bg-blue-950/95 backdrop-blur lg:hidden">
        <nav class="space-y-1 px-4 py-4">
            @foreach ($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="block rounded-md px-3 py-2 text-sm font-medium
                          {{ $active ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/5' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
