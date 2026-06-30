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

<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-blue-900 font-bold text-white">NP</span>
            <span class="hidden text-lg font-bold leading-tight text-blue-900 sm:block">
                NPI University<span class="block text-xs font-medium text-slate-500">of Bangladesh</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            @foreach ($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="rounded-md px-3 py-2 text-sm font-medium transition
                          {{ $active ? 'bg-blue-50 text-blue-900' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-900' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <button @click="open = !open"
                class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                aria-label="Toggle navigation">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-collapse class="border-t border-slate-200 lg:hidden">
        <nav class="space-y-1 px-4 py-3">
            @foreach ($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="block rounded-md px-3 py-2 text-sm font-medium
                          {{ $active ? 'bg-blue-50 text-blue-900' : 'text-slate-600 hover:bg-slate-100' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>
