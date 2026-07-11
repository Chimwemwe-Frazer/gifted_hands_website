<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic Schedule | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
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
                <a href="{{ route('schedule') }}" class="text-mustGreen">Clinic Schedule</a>
                <a href="{{ route('announcements') }}" class="hover:text-mustGreen">Announcements</a>
                <a href="{{ route('gallery') }}" class="hover:text-mustGreen">Gallery</a>
                <a href="{{ route('faqs') }}" class="hover:text-mustGreen">FAQs</a>
                <a href="{{ route('contact') }}" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Opening hours</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">Clinic Schedule</h1>
            <p class="mt-4 max-w-2xl text-gray-200">Plan your visit using the clinic operating schedule and service availability information.</p>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
            <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-2xl font-bold text-mustBlue">Weekly Schedule</h2>
                <div class="mt-6 divide-y divide-gray-200">
                    @foreach ([
                        ['Monday - Friday', '08:00 AM - 05:00 PM'],
                        ['Saturday', '08:00 AM - 01:00 PM'],
                        ['Sunday', 'Emergency support only'],
                        ['Public Holidays', 'Call ahead for availability'],
                    ] as [$day, $time])
                        <div class="flex flex-col justify-between gap-2 py-4 sm:flex-row sm:items-center">
                            <span class="font-semibold text-mustBlue">{{ $day }}</span>
                            <span class="text-gray-600">{{ $time }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <aside class="rounded-lg bg-mustBlue p-6 text-white">
                <h2 class="text-2xl font-bold">Service Availability</h2>
                <div class="mt-6 space-y-4 text-sm leading-7 text-gray-200">
                    <p><strong class="text-white">General Consultation:</strong> Available on regular clinic days.</p>
                    <p><strong class="text-white">Laboratory Services:</strong> Available during normal clinic hours.</p>
                    <p><strong class="text-white">Emergency Support:</strong> Contact the clinic directly for urgent help.</p>
                </div>
                <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">
                    Request Appointment
                </a>
            </aside>
        </div>
    </main>
</body>

</html>
