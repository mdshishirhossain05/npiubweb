@php
    $nav = [
        ['label' => 'About', 'route' => 'pages.show', 'param' => 'about'],
        ['label' => 'Academics', 'route' => 'departments.index'],
        ['label' => 'News', 'route' => 'posts.index'],
        ['label' => 'Notices', 'route' => 'notices.index'],
        ['label' => 'Events', 'route' => 'events.index'],
        ['label' => 'Faculty', 'route' => 'faculty.index'],
    ];
    $navUrl = fn ($item) => isset($item['param']) ? url('/'.$item['param']) : route($item['route']);
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50">
    {{-- Utility strip --}}
    <div class="hidden bg-ink-950 text-ink-200 md:block">
        <div class="mx-auto flex max-w-[1400px] items-center justify-between px-6 py-2 text-xs lg:px-10">
            <span class="tracking-wide">Basta, Singair, Manikganj, Dhaka · Est. 2015</span>
            <div class="flex items-center gap-6">
                <a href="tel:+8801703444111" class="hover:text-white">+880 1703-444111</a>
                <a href="mailto:info@npiub.edu.bd" class="hover:text-white">info@npiub.edu.bd</a>
                <a href="/admin" class="font-medium text-white hover:text-accent-400">Portal &rarr;</a>
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="border-b border-ink-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-6 px-6 py-4 lg:px-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3.5">
                <span class="grid h-11 w-11 place-items-center rounded-sm bg-accent-600 font-display text-lg font-black text-white">N</span>
                <span class="leading-none">
                    <span class="block font-display text-xl font-black tracking-tight text-ink-900">NPI University</span>
                    <span class="mt-1 block text-[11px] font-semibold uppercase tracking-[0.25em] text-ink-600">of Bangladesh</span>
                </span>
            </a>

            <nav class="hidden items-center gap-7 lg:flex">
                @foreach ($nav as $item)
                    @php $active = isset($item['param']) ? request()->is($item['param']) : request()->routeIs($item['route']); @endphp
                    <a href="{{ $navUrl($item) }}"
                       class="text-[15px] font-medium transition {{ $active ? 'text-accent-600' : 'text-ink-800 hover:text-accent-600' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="/about#admission"
                   class="ml-1 inline-flex items-center gap-2 rounded-sm bg-ink-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-accent-600">
                    Apply
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </a>
            </nav>

            <button @click="open = !open" class="inline-flex items-center justify-center rounded-sm p-2 text-ink-900 hover:bg-ink-50 lg:hidden" aria-label="Menu">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-collapse class="border-b border-ink-100 bg-white lg:hidden">
        <nav class="px-6 py-3">
            @foreach ($nav as $item)
                <a href="{{ $navUrl($item) }}" class="block border-b border-ink-50 py-3 text-sm font-medium text-ink-800">{{ $item['label'] }}</a>
            @endforeach
            <a href="/about#admission" class="mt-3 block rounded-sm bg-accent-600 px-4 py-2.5 text-center text-sm font-semibold text-white">Apply</a>
        </nav>
    </div>
</header>
