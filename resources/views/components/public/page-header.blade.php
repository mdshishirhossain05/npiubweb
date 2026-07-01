@props([
    'title',
    'subtitle' => null,
])

<section class="border-b-4 border-accent-500 bg-ink-900">
    <div class="mx-auto max-w-7xl px-6 py-14 sm:py-16 lg:px-8">
        <nav class="mb-3 text-sm text-ink-50/60">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span class="mx-1.5">/</span>
            <span class="text-ink-50/90">{{ $title }}</span>
        </nav>
        <h1 class="font-display text-4xl font-bold text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-ink-50/80">{{ $subtitle }}</p>
        @endif
    </div>
</section>
