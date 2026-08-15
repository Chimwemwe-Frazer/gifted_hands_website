<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctors | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden" style="background-image: url('{{ asset('imgs/doctors-bg-enhanced.png') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Medical team</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Our Doctors</h1>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <section class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Trusted care team</p>
            <h2 class="mt-3 text-3xl font-bold text-mustBlue">Meet The Clinicians Supporting Your Care</h2>
            <p class="mt-4 leading-8 text-gray-600">
                Our doctors and clinicians support patients with clear communication, respectful consultations, and practical guidance for follow-up care.
            </p>
        </section>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($doctors as $doctor)
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="aspect-[4/4.05] overflow-hidden bg-[#EAF4F9]">
                        @if ($doctor->image_url)
                            <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover object-[50%_22%]">
                        @else
                            <div class="flex h-full w-full items-center justify-center px-4 text-center font-semibold text-gray-500">
                                No Image Uploaded
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-mustBlue">{{ $doctor->name }}</h2>
                        <p class="mt-1 text-sm font-semibold text-mustGreen">{{ $doctor->specialization }}</p>
                        <div class="mt-4 border-t border-gray-200 pt-4 text-sm leading-6 text-gray-600">
                            <p><strong class="text-mustBlue">Languages:</strong> {{ implode(', ', $doctor->languages ?? []) }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-8 text-center text-gray-600 md:col-span-2 lg:col-span-3">
                    No doctor profiles are available right now. Please contact the clinic for assistance.
                </div>
            @endforelse
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
