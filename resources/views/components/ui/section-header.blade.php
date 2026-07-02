@props(['title', 'subtitle' => null, 'align' => 'left'])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : '' }} mb-8">
    <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h2>
    <div class="mt-2 h-1 w-16 rounded bg-primary-500 {{ $align === 'center' ? 'mx-auto' : '' }}"></div>
    @if ($subtitle)
        <p class="mt-4 text-slate-600">{{ $subtitle }}</p>
    @endif
</div>
