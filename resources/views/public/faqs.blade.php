<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FAQs | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/logo-white.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="bg-mustBlue pt-28 text-white">
        <nav class="fixed inset-x-0 top-0 z-50 flex flex-col gap-4 bg-mustBlue/95 px-4 py-4 text-white shadow-lg backdrop-blur lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('imgs/logo/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-12 w-12 object-contain">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gifted Hands Private Clinic') }}</span>
            </a>
            <div class="flex flex-wrap items-center gap-x-5 gap-y-3 text-sm font-semibold">
                <a href="{{ route('home') }}" class="hover:text-mustGreen">Home</a>
                <a href="{{ route('about') }}" class="hover:text-mustGreen">About Us</a>
                <a href="{{ route('services') }}" class="hover:text-mustGreen">Services</a>
                <a href="{{ route('doctors') }}" class="hover:text-mustGreen">Doctors</a>
                <a href="{{ route('home') }}#book-appointment" class="hover:text-mustGreen">Book Appointment</a>
                <a href="{{ route('home') }}#announcements" class="hover:text-mustGreen">Announcements</a>
                <a href="{{ route('gallery') }}" class="hover:text-mustGreen">Gallery</a>
                <a href="{{ route('faqs') }}" class="text-mustGreen">FAQs</a>
                <a href="{{ route('home') }}#contact-us" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>
        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Helpful answers</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">FAQs</h1>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-16">
        <div class="space-y-4">
            @foreach ([
                ['Do I need an appointment?', 'Appointments are recommended so the clinic can confirm availability before you visit.'],
                ['Can I request a specific service?', 'Yes. Select a service in the booking form and the appointments officer will follow up.'],
                ['Is ambulance support available?', 'The clinic advertises ambulance availability. Contact the clinic directly for urgent arrangements.'],
                ['Can children under five be attended to?', 'Yes. The Under-5 Clinic supports growth monitoring, immunizations, and wellness checks.'],
                ['Do you offer laboratory services?', 'Yes. Laboratory services support testing and diagnosis for better treatment decisions.'],
            ] as [$question, $answer])
                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="font-bold text-mustBlue">{{ $question }}</h2>
                    <p class="mt-2 text-sm leading-7 text-gray-600">{{ $answer }}</p>
                </article>
            @endforeach
        </div>
    </main>
</body>

</html>
