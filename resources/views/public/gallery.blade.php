<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gallery | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="bg-mustBlue text-white">
        @include('public.partials.nav')

        <div class="mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Clinic moments</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Gallery</h1>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <div class="grid gap-5 md:grid-cols-3">
            @foreach (['Reception Area', 'Consultation Room', 'Laboratory', 'Care Team', 'Clinic Exterior', 'Treatment Area'] as $caption)
                <figure class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset('imgs/optimixed.jpg') }}" alt="{{ $caption }}" class="h-64 w-full object-cover">
                    <figcaption class="p-4 text-sm font-semibold text-mustBlue">{{ $caption }}</figcaption>
                </figure>
            @endforeach
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
