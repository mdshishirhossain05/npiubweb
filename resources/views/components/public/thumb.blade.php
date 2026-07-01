@props([
    'src' => null,
    'alt' => '',
])

{{-- Image slot with a neutral, intentional placeholder when empty. --}}
@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}"
         {{ $attributes->merge(['class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]']) }}>
@else
    <div {{ $attributes->merge(['class' => 'flex h-full w-full items-center justify-center bg-slate-100']) }}>
        <span class="font-display text-2xl font-bold tracking-wide text-slate-300">NPIUB</span>
    </div>
@endif
