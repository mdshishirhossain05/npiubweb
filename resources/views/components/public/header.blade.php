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

<header x-data="{ open: false }" class="relative z-50">
    {{-- Slim utility bar --}}
    <div class="hidden bg-navy-900 text-navy-50/80 md:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-2 text-xs lg:px-8">
            <span>NPI University of Bangladesh · Manikganj</span>
            <div class="flex items-center gap-5">
                <a href="mailto:info@npiub.edu.bd" class="hover:text-white">info@npiub.edu.bd</a>
                <a href="{{ route('notices.index') }}" class="hover:text-white">Notices</a>
                <a href="/admin" class="hover:text-white">Portal</a>
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-4 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid h-12 w-12 place-items-center rounded-full border-2 border-brass-500 font-display text-lg font-bold text-navy-900">NP</span>
                <span class="leading-tight">
                    <span class="block font-display text-lg font-bold text-navy-900">NPI University</span>
                    <span class="block text-xs font-medium uppercase tracking-wider text-slate-500">of Bangladesh</span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 lg:flex">
                @foreach ($nav as $item)
                    @php $active = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="border-b-2 pb-1 text-sm font-medium transition
                              {{ $active ? 'border-brass-500 text-navy-900' : 'border-transparent text-slate-600 hover:text-navy-900' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <button @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-navy-900 hover:bg-slate-100 lg:hidden"
                    aria-label="Toggle navigation">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-collapse class="border-b border-slate-200 bg-white lg:hidden">
        <nav class="space-y-1 px-6 py-3">
            @foreach ($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="block rounded-md px-3 py-2 text-sm font-medium
                          {{ $active ? 'bg-navy-50 text-navy-900' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
