<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
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
                <a href="{{ route('schedule') }}" class="hover:text-mustGreen">Clinic Schedule</a>
                <a href="{{ route('announcements') }}" class="hover:text-mustGreen">Announcements</a>
                <a href="{{ route('gallery') }}" class="hover:text-mustGreen">Gallery</a>
                <a href="{{ route('faqs') }}" class="hover:text-mustGreen">FAQs</a>
                <a href="{{ route('contact') }}" class="text-mustGreen">Contact Us</a>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Get in touch</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">Contact Us</h1>
            <p class="mt-4 max-w-2xl text-gray-200">Reach the clinic directly for directions, service availability, appointment coordination, and general enquiries.</p>
        </div>
    </header>

    <main class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-[0.8fr_1.2fr]">
        <section class="space-y-4">
            <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                <h2 class="font-bold text-mustBlue">Phone</h2>
                <p class="mt-2 text-sm text-gray-600">Add clinic phone number</p>
            </div>
            <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                <h2 class="font-bold text-mustBlue">Email</h2>
                <p class="mt-2 text-sm text-gray-600">Add clinic email address</p>
            </div>
            <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                <h2 class="font-bold text-mustBlue">Location</h2>
                <p class="mt-2 text-sm text-gray-600">Add clinic physical address</p>
            </div>
        </section>

        <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-mustBlue">Send An Enquiry</h2>
            <form class="mt-6 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="label">Name</label>
                    <input class="input" type="text">
                </div>
                <div>
                    <label class="label">Phone</label>
                    <input class="input" type="text">
                </div>
                <div class="md:col-span-2">
                    <label class="label">Email</label>
                    <input class="input" type="email">
                </div>
                <div class="md:col-span-2">
                    <label class="label">Message</label>
                    <textarea class="input" rows="5"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="button" class="rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">Submit Enquiry</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
