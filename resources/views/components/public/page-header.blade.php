@props([
    'title',
    'subtitle' => null,
])

<section class="bg-blue-900">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-3 max-w-2xl text-lg text-blue-100">{{ $subtitle }}</p>
        @endif
    </div>
</section>
