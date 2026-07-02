@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'publishedTime' => null,
])

@php
    $siteName = config('app.name');
    $title = $title ?: $siteName;
    $description = \Illuminate\Support\Str::limit(trim((string) ($description ?: 'NPI University of Bangladesh — official website.')), 160);
    $url = url()->current();
    $ogImage = $image
        ?: (file_exists(public_path('images/logo.png')) ? asset('images/logo.png') : asset('images/logo.svg'));
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@if ($publishedTime)
    <meta property="article:published_time" content="{{ $publishedTime }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Organization JSON-LD --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'CollegeOrUniversity',
    'name' => $siteName,
    'url' => url('/'),
    'logo' => $ogImage,
    'email' => \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd'),
    'telephone' => \App\Models\SiteSetting::get('contact', 'phone', null),
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => \App\Models\SiteSetting::get('contact', 'address', 'Bangladesh'),
        'addressCountry' => 'BD',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@stack('schema')
