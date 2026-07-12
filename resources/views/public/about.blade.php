<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>About Us | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>

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
                <a href="{{ route('about') }}" class="text-mustGreen">About Us</a>
                <a href="{{ route('services') }}" class="hover:text-mustGreen">Services</a>
                <a href="{{ route('doctors') }}" class="hover:text-mustGreen">Doctors</a>
                <a href="{{ route('schedule') }}" class="hover:text-mustGreen">Clinic Schedule</a>
                <a href="{{ route('announcements') }}" class="hover:text-mustGreen">Announcements</a>
                <a href="{{ route('gallery') }}" class="hover:text-mustGreen">Gallery</a>
                <a href="{{ route('faqs') }}" class="hover:text-mustGreen">FAQs</a>
                <a href="{{ route('contact') }}" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">About the clinic</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">About Us</h1>
        </div>
    </header>

    <main>
        <section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 lg:grid-cols-[1fr_0.8fr] lg:items-start">
            <div>
                <p class="text-lg leading-9 text-gray-700">
                    For many years, we have proudly served our community with professional, patient-centered healthcare. Our experienced doctors and dedicated medical team provide a comprehensive range of quality healthcare services designed to meet the diverse needs of individuals and families.
                </p>
                <p class="mt-6 leading-8 text-gray-600">
                    Our work is guided by compassion, privacy, and reliable clinical attention. We aim to make every visit clear and comfortable, from the first appointment request to the care and guidance provided by our medical team.
                </p>
                <p class="mt-6 leading-8 text-gray-600">
                    The clinic continues to grow as a trusted place for families and individuals seeking accessible private healthcare, practical advice, and timely support.
                </p>
            </div>

            <aside class="rounded-lg border border-gray-200 bg-gray-50 p-6">
                <h2 class="text-xl font-bold text-mustBlue">Our Commitment</h2>
                <div class="mt-5 space-y-4 text-sm leading-6 text-gray-600">
                    <p><strong class="text-mustBlue">Patient-centered care:</strong> Respectful service focused on individual needs.</p>
                    <p><strong class="text-mustBlue">Experienced team:</strong> Dedicated doctors and medical staff supporting quality care.</p>
                    <p><strong class="text-mustBlue">Comprehensive services:</strong> Healthcare support for individuals and families.</p>
                </div>
                <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">
                    Book Appointment
                </a>
            </aside>
        </section>
    </main>

    @include('public.partials.footer')
</body>

</html>
