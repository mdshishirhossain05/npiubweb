@props([
    'src' => null,
    'alt' => '',
    'ratio' => 'aspect-4/3',
    'rounded' => 'rounded-2xl',
    'grayscale' => false,
])

<div {{ $attributes->merge(['class' => "relative overflow-hidden $ratio $rounded"]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy"
             class="h-full w-full object-cover {{ $grayscale ? 'grayscale transition duration-500 hover:grayscale-0' : '' }}">
    @else
        {{-- Vibrant branded fallback so empty media still looks intentional. --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-500 via-emerald-500 to-teal-500"></div>
        <div class="absolute inset-0 opacity-30"
             style="background-image: radial-gradient(circle at 30% 25%, rgba(255,255,255,0.5), transparent 45%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.25), transparent 40%);"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="h-12 w-12 text-white/70" fill="none" stroke="currentColor" stroke-width="1.25" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
        </div>
    @endif
    {{ $slot }}
</div>
