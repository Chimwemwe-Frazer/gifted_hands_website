<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Announcements | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-hidden bg-mustBlue bg-cover text-white" style="background-image: url('{{ asset('imgs/image.png') }}'); background-position: center 38%;">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[32%] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Clinic updates</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Announcements</h1>
            <p class="mt-4 max-w-md text-gray-200">Stay informed about clinic schedules, service availability, and important visitor notices.</p>
        </div>
    </header>

    <main class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-[1.2fr_0.8fr]">
        <section>
            <h2 class="section-heading">All Announcements</h2>
            <div class="mt-8 space-y-5">
                @foreach ([
                    ['Clinic hours', 'Weekend Schedule Update', 'Saturday services are available from 08:00 AM to 01:00 PM. Please call ahead for availability.'],
                    ['Services', 'Laboratory Services Available', 'Reliable diagnostic and laboratory testing services are available during normal clinic hours.'],
                    ['Appointments', 'Book Before Your Visit', 'Visitors are encouraged to request appointments in advance so the team can confirm service availability.'],
                    ['Under-5 Clinic', 'Child Wellness Services', 'Growth monitoring, immunizations, and routine child wellness checks are available for young children.'],
                    ['Women\'s Health', 'Obstetrics & Gynaecology Care', 'Pregnancy care, reproductive health, and family planning support are available at the clinic.'],
                ] as [$category, $title, $body])
                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $category }}</p>
                        <h3 class="mt-3 text-xl font-bold text-mustBlue">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-gray-600">{{ $body }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <aside class="h-fit rounded-lg bg-mustBlue p-6 text-white">
            <h2 class="text-2xl font-bold">Subscribe For Updates</h2>
            <p class="mt-3 text-sm leading-7 text-gray-200">Receive Gifted Hands announcements, service updates, and clinic notices by email.</p>

            @if (session('subscription_success'))
                <div class="mt-5 rounded-md bg-green-50 p-3 text-sm text-green-800">{{ session('subscription_success') }}</div>
            @endif

            <form action="{{ route('announcements.subscribe') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-100">Email address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="mt-2 block w-full rounded-md border-white/20 bg-white px-3 py-2 text-gray-800 shadow-sm focus:border-mustGreen focus:ring-mustGreen">
                    <span class="mt-1 block text-sm text-red-200">{{ $errors->first('email') }}</span>
                </div>
                <button type="submit" class="rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">Subscribe</button>
            </form>
        </aside>
    </main>
    @include('public.partials.footer')
</body>

</html>
