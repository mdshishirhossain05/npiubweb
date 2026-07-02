@props([
    'src' => null,
    'alt' => '',
    'ratio' => 'aspect-4/3',
    'rounded' => 'rounded-none',
    'grayscale' => false,
])

<div {{ $attributes->merge(['class' => "relative overflow-hidden bg-slate-100 $ratio $rounded"]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy"
             class="h-full w-full object-cover {{ $grayscale ? 'grayscale transition duration-500 hover:grayscale-0' : '' }}">
    @else
        {{-- Refined placeholder: neutral canvas + faint diagonal hatch + small mark --}}
        <div class="absolute inset-0"
             style="background-image: repeating-linear-gradient(135deg, rgba(15,133,80,0.05) 0px, rgba(15,133,80,0.05) 1px, transparent 1px, transparent 11px);"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="flex flex-col items-center gap-2 text-slate-300">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.25" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18v14H3z M3 16l5-5 4 4 4-5 5 6"/></svg>
            </span>
        </div>
    @endif
    {{ $slot }}
</div>
