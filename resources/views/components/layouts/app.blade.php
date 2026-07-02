@props([
    'title' => null,
    'description' => null,
    'ogImage' => null,
    'ogType' => 'website',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo :title="$title" :description="$description" :image="$ogImage" :type="$ogType" />

    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-white font-sans text-slate-700 antialiased">
    <a href="#main"
       class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-primary-600 focus:px-4 focus:py-2 focus:text-white">
        Skip to content
    </a>

    <x-site.navbar />

    <main id="main">
        {{ $slot }}
    </main>

    <x-site.footer />
</body>
</html>
