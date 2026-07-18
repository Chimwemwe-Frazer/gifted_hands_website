<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Services | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden md:bg-right lg:bg-center" style="background-image: url('{{ asset('imgs/stethoscope.jpg') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">What we offer</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Clinic Services</h1>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        <section class="max-w-3xl md:max-w-[36rem] lg:max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Patient services</p>
            <h2 class="mt-3 text-3xl font-bold text-mustBlue">Care That Supports Everyday Health Needs</h2>
            <p class="mt-4 leading-8 text-gray-600">
                Each service is designed to help patients understand their health concern, receive appropriate care, and know the next step before leaving the clinic.
            </p>
        </section>

        <section class="mt-10 space-y-8">
            @forelse ($services as $service)
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
                        @if ($service->image_url)
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-72 w-full object-cover md:hidden lg:block lg:h-full {{ $loop->even ? 'lg:order-2' : '' }}">
                        @else
                            <div class="flex h-72 w-full items-center justify-center bg-gray-100 px-4 text-center font-semibold text-gray-500 md:hidden lg:flex lg:h-full lg:min-h-96 {{ $loop->even ? 'lg:order-2' : '' }}">
                                No Image Uploaded
                            </div>
                        @endif

                        <div class="p-6 md:p-7 lg:p-8 {{ $loop->even ? 'lg:order-1' : '' }}">
                            <div class="grid gap-5 md:grid-cols-2 md:items-start lg:block">
                                <div>
                                    <h2 class="text-2xl font-bold text-mustBlue">{{ $service->name }}</h2>
                                    <p class="mt-3 whitespace-pre-line leading-8 text-gray-600">{{ $service->description }}</p>
                                </div>

                                @if ($service->image_url)
                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="hidden h-48 w-full rounded-lg object-cover md:block lg:hidden">
                                @else
                                    <div class="hidden h-48 w-full items-center justify-center rounded-lg bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500 md:flex lg:hidden">
                                        No Image Uploaded
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 grid gap-5 md:grid-cols-2">
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-[.14em] text-mustGreen">What is included</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                                        @forelse ($service->included_items ?? [] as $item)
                                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                                        @empty
                                            <li>Contact the clinic for details about what is included.</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-[.14em] text-mustGreen">Needs treated</h3>
                                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $service->needs_treated ?: 'Contact the clinic to discuss whether this service is suitable for your needs.' }}</p>
                                </div>
                            </div>

                            <div class="mt-6 grid gap-5 border-t border-gray-200 pt-5 md:grid-cols-2">
                                <div>
                                    <h3 class="font-bold text-mustBlue">What to bring</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                                        @forelse ($service->items_to_bring ?? [] as $item)
                                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                                        @empty
                                            <li>Contact the clinic to confirm what you should bring.</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="font-bold text-mustBlue">Appointments</h3>
                                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $service->appointment_details ?: 'Contact the clinic to confirm availability and appointment requirements.' }}</p>
                                </div>
                            </div>

                            <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex items-center justify-center rounded-full bg-mustGreen px-4 py-2.5 text-sm font-semibold text-white hover:bg-mustOrangeDark md:px-5 md:py-3 md:text-base">
                                <span class="md:hidden">Request Appointment</span>
                                <span class="hidden md:inline">Request appointment for this service</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-8 text-center text-gray-600">
                    No services are available right now. Please contact the clinic for assistance.
                </div>
            @endforelse
        </section>
    </main>
    @include('public.partials.footer')
</body>

</html>
