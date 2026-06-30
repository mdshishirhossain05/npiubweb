@props([
    'title',
    'subtitle' => null,
])

<section class="relative overflow-hidden bg-blue-950">
    <div class="bg-grid absolute inset-0 opacity-60"></div>
    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-amber-500/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 pb-14 pt-32 sm:px-6 sm:pb-20 sm:pt-36 lg:px-8">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-blue-100">{{ $subtitle }}</p>
        @endif
    </div>
</section>
