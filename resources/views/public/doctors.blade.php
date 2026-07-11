<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctors | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
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
                <a href="{{ route('doctors') }}" class="text-mustGreen">Doctors</a>
                <a href="{{ route('home') }}#book-appointment" class="hover:text-mustGreen">Clinic Schedule</a>
                <a href="{{ route('home') }}#announcements" class="hover:text-mustGreen">Announcements</a>
                <a href="{{ route('gallery') }}" class="hover:text-mustGreen">Gallery</a>
                <a href="{{ route('faqs') }}" class="hover:text-mustGreen">FAQs</a>
                <a href="{{ route('home') }}#contact-us" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>
        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Medical team</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">Our Doctors</h1>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([
                ['Dr. Mercy Banda', 'General Practitioner', 'MBBS, Diploma in Family Medicine'],
                ['Dr. Thoko Phiri', 'Obstetrics & Gynaecology', 'MBBS, MMED Obstetrics & Gynaecology'],
                ['Dr. Daniel Kamanga', 'Physiotherapy & Rehabilitation', 'BSc Physiotherapy, Certified Rehabilitation Specialist'],
            ] as [$name, $specialization, $qualification])
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset('imgs/optimixed.jpg') }}" alt="{{ $name }}" class="h-72 w-full object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-mustBlue">{{ $name }}</h2>
                        <p class="mt-1 text-sm font-semibold text-orange-500">{{ $specialization }}</p>
                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ $qualification }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
</body>

</html>
