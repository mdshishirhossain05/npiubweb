@props(['person'])

@php
    $photo = $person->getFirstMediaUrl('photo', 'thumb') ?: $person->getFirstMediaUrl('photo');
    $initials = \Illuminate\Support\Str::of($person->name)->explode(' ')->map(fn ($w) => \Illuminate\Support\Str::substr($w, 0, 1))->take(2)->implode('');
@endphp

<a href="{{ url('/faculties/'.$person->slug) }}"
   class="group relative block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
    <div class="relative aspect-4/5 w-full overflow-hidden bg-ink-700">
        @if ($photo)
            <img src="{{ $photo }}" alt="{{ $person->name }}" loading="lazy" class="h-full w-full object-cover opacity-95 transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-ink-600 to-primary-800 font-display text-5xl font-semibold text-gold-300/80">
                {{ $initials }}
            </div>
        @endif
        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-ink-900/85 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 p-4 text-white">
            <h3 class="font-display text-lg font-semibold leading-tight">{{ $person->name }}</h3>
            <p class="mt-0.5 text-sm text-gold-300">{{ $person->position }}</p>
        </div>
        <span class="absolute right-3 top-3 flex h-8 w-8 -translate-y-2 items-center justify-center rounded-full bg-gold-500 text-ink-800 opacity-0 transition group-hover:translate-y-0 group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </span>
    </div>
</a>
