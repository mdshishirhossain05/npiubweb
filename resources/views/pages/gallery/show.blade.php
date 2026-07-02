<x-layouts.app :title="$album->title.' — '.config('app.name')">
    <div x-data="{ open: false, src: '' }" class="mx-auto max-w-7xl px-4 py-12 lg:px-6 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Gallery', 'url' => url('/galleries')], ['label' => $album->title]]" />
        <h1 class="mt-8 text-3xl font-semibold tracking-tight text-ink-900 sm:text-4xl">{{ $album->title }}</h1>
        @if ($album->description)<p class="mt-3 max-w-2xl text-slate-600">{{ $album->description }}</p>@endif

        @if ($album->images->isNotEmpty())
            <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($album->images as $image)
                    @php $url = $image->getFirstMediaUrl('image', 'large') ?: $image->getFirstMediaUrl('image'); $thumb = $image->getFirstMediaUrl('image', 'thumb') ?: $url; @endphp
                    <button type="button" @click="src = '{{ $url }}'; open = true" class="group block overflow-hidden bg-slate-100">
                        <x-ui.image-frame :src="$thumb ?: null" :alt="$image->title ?? $album->title" ratio="aspect-square" />
                    </button>
                @endforeach
            </div>
        @else
            <p class="mt-10 text-slate-500">No photos in this album yet.</p>
        @endif

        {{-- Lightbox --}}
        <div x-show="open" x-cloak @keydown.escape.window="open = false" @click="open = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" x-transition.opacity>
            <img :src="src" alt="" class="max-h-[90vh] max-w-full object-contain">
            <button @click="open = false" class="absolute right-4 top-4 text-white/80 hover:text-white" aria-label="Close">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</x-layouts.app>
