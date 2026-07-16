<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="bg-mustBlue text-white">
        @include('public.partials.nav')

        <div class="mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Get in touch</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Contact Us</h1>
            <p class="mt-4 max-w-2xl text-gray-200">Reach the clinic directly for directions, service availability, appointment coordination, and general enquiries.</p>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
            <section class="space-y-4">
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h2 class="font-bold text-mustBlue">Phone</h2>
                    <p class="mt-2 text-sm text-gray-600"><a href="tel:+265995767137" class="hover:text-mustGreen">+265 995 76 71 37</a></p>
                </div>
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h2 class="font-bold text-mustBlue">Email</h2>
                    <p class="mt-2 text-sm text-gray-600"><a href="mailto:giftedhandspvtclinic@gmail.com" class="hover:text-mustGreen">giftedhandspvtclinic@gmail.com</a></p>
                </div>
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h2 class="font-bold text-mustBlue">Location</h2>
                    <p class="mt-2 text-sm text-gray-600">Barron Avenue, Lilongwe, Malawi</p>
                    <a href="https://www.google.com/maps/search/?api=1&query=Gifted%20Hands%20Private%20Clinic%20Barron%20Avenue%20Lilongwe%20Malawi" target="_blank" rel="noopener" class="mt-4 inline-flex rounded-full bg-mustGreen px-4 py-2 text-sm font-semibold text-white hover:bg-mustOrangeDark">
                        Open in Google Maps
                    </a>
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
                        <button type="button" class="rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">Submit Enquiry</button>
                    </div>
                </form>
            </section>
        </div>

        <section class="mt-8 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col justify-between gap-4 p-6 md:flex-row md:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[.16em] text-mustGreen">Directions</p>
                    <h2 class="mt-2 text-2xl font-bold text-mustBlue">Find Gifted Hands Private Clinic</h2>
                    <p class="mt-2 text-sm leading-7 text-gray-600">Use the map below to find the clinic around Barron Avenue, Lilongwe.</p>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query=Gifted%20Hands%20Private%20Clinic%20Barron%20Avenue%20Lilongwe%20Malawi" target="_blank" rel="noopener" class="inline-flex rounded-full border border-mustBlue px-4 py-2 text-sm font-semibold text-mustBlue hover:bg-mustBlue hover:text-white">
                    Get Directions
                </a>
            </div>
            <iframe
                title="Google map showing Gifted Hands Private Clinic on Barron Avenue in Lilongwe"
                src="https://www.google.com/maps?q=Gifted%20Hands%20Private%20Clinic%20Barron%20Avenue%20Lilongwe%20Malawi&output=embed"
                class="h-80 w-full border-0 md:h-96"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>
    </main>
    @include('public.partials.footer')
</body>

</html>
