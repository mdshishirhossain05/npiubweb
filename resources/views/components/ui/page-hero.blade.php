@props(['title', 'eyebrow' => null, 'intro' => null, 'breadcrumbs' => []])

<section class="border-b border-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-12 lg:px-6 lg:py-16">
        @if (! empty($breadcrumbs))
            <x-ui.breadcrumbs :items="$breadcrumbs" />
        @endif
        @if ($eyebrow)
            <span class="eyebrow mt-8">{{ $eyebrow }}</span>
        @endif
        <h1 class="mt-4 max-w-4xl text-4xl font-semibold tracking-tight text-ink-900 sm:text-5xl lg:text-6xl">{{ $title }}</h1>
        @if ($intro)
            <p class="mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">{{ $intro }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
