@props(['items' => [], 'light' => false])

{{-- $items: array of ['label' => string, 'url' => ?string] --}}
@php
    $muted = $light ? 'text-white/70' : 'text-slate-500';
    $link = $light ? 'text-white/80 hover:text-white' : 'hover:text-primary-700';
    $current = $light ? 'font-medium text-white' : 'font-medium text-slate-700';
    $sep = $light ? 'text-white/40' : 'text-slate-300';
@endphp

<nav aria-label="Breadcrumb" class="text-sm {{ $muted }}">
    <ol class="flex flex-wrap items-center gap-1">
        <li><a href="{{ url('/') }}" class="{{ $link }}">Home</a></li>
        @foreach ($items as $item)
            <li aria-hidden="true" class="px-1 {{ $sep }}">/</li>
            <li>
                @if (! empty($item['url']) && ! $loop->last)
                    <a href="{{ $item['url'] }}" class="{{ $link }}">{{ $item['label'] }}</a>
                @else
                    <span class="{{ $current }}" @if ($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
