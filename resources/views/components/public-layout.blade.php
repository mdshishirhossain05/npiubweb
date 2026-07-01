@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? $title . ' — ' . config('app.name') : config('app.name') }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Fraunces: a modern, characterful display serif for an editorial identity.
         Inter: clean, neutral body copy. --}}
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900|inter:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-ink-700 antialiased">
    <x-public.header />

    <main>
        {{ $slot }}
    </main>

    <x-public.footer />
</body>
</html>
