@props(['person'])

@php
    $photo = $person->getFirstMediaUrl('photo', 'thumb') ?: $person->getFirstMediaUrl('photo');
@endphp

<x-ui.card href="{{ url('/faculties/'.$person->slug) }}" class="text-center">
    <div class="aspect-square w-full overflow-hidden bg-slate-100">
        @if ($photo)
            <img src="{{ $photo }}" alt="{{ $person->name }}" loading="lazy" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-primary-50 text-4xl font-bold text-primary-300">
                {{ Str::of($person->name)->explode(' ')->map(fn ($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
            </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-semibold text-slate-900 group-hover:text-primary-700">{{ $person->name }}</h3>
        <p class="mt-0.5 text-sm text-slate-500">{{ $person->position }}</p>
    </div>
</x-ui.card>
