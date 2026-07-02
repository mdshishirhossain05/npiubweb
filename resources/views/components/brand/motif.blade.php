@props(['class' => ''])

{{-- Decorative academic crest motif (open book + flame of knowledge), echoing
     the NPIUB seal. Purely decorative — hidden from assistive tech. --}}
<svg viewBox="0 0 200 200" fill="none" aria-hidden="true" {{ $attributes->merge(['class' => $class]) }}>
    <g stroke="currentColor" stroke-width="2.5" opacity="0.9">
        <path d="M100 60 C96 48 104 44 100 30 C112 42 108 54 100 60 Z" fill="currentColor" stroke="none"/>
        <path d="M100 72 C82 60 58 60 40 66 v78 c18 -6 42 -6 60 6 c18 -12 42 -12 60 -6 V66 c-18 -6 -42 -6 -60 6 Z"/>
        <path d="M100 72 v78"/>
        <path d="M52 82 h30 M52 98 h30 M52 114 h30 M118 82 h30 M118 98 h30 M118 114 h30" opacity="0.6"/>
    </g>
</svg>
