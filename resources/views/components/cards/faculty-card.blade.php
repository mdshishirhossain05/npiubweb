@props(['person'])

@php
    $photo = $person->getFirstMediaUrl('photo', 'thumb') ?: $person->getFirstMediaUrl('photo');
@endphp

<a href="{{ url('/faculties/'.$person->slug) }}" class="group block">
    <x-ui.image-frame :src="$photo ?: null" :alt="$person->name" ratio="aspect-4/5" :grayscale="true" />
    <div class="mt-4">
        <h3 class="font-display text-lg font-semibold tracking-tight text-ink-900">{{ $person->name }}</h3>
        <p class="mt-1 text-sm text-slate-500">{{ $person->position }}</p>
        <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-medium text-primary-700 opacity-0 transition group-hover:opacity-100">
            View profile
            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </span>
    </div>
</a>
