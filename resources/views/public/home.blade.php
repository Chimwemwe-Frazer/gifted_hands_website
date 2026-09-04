<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('public.partials.seo', [
    'seoTitle' => 'Gifted Hands Private Clinic | Private Healthcare in Lilongwe, Malawi',
    'seoDescription' => 'Gifted Hands Private Clinic provides patient-centered private healthcare in Lilongwe, Malawi, including general consultation, women’s health, Under-5 care, physiotherapy, laboratory services, scanning, appointments, and ambulance services.',
    'seoCanonical' => url('/'),
    ])

    @include('public.partials.structured-data')

    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="home-page bg-white text-gray-800">
    @php
        $heroSlides = [
            ['image' => 'imgs/Medical team home page.jpeg'],
        ];

        if (file_exists(public_path('imgs/stethoscope.jpg'))) {
            $heroSlides[] = ['image' => 'imgs/stethoscope.jpg'];
        }

        if (file_exists(public_path('imgs/Medicine.jpg'))) {
            $heroSlides[] = ['image' => 'imgs/Medicine.jpg'];
        }
    @endphp

    <header class="home-hero">
        <div class="home-hero-slides home-hero-slides--count-{{ count($heroSlides) }} {{ count($heroSlides) > 1 ? 'home-hero-slides--cycle' : '' }}" aria-hidden="true">
            @foreach ($heroSlides as $slide)
                <span class="home-hero-slide" style="--hero-slide-image: url('{{ asset($slide['image']) }}');"></span>
            @endforeach
        </div>

        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex max-w-7xl flex-col justify-center px-4 pb-14 pt-8 text-white sm:pb-20 sm:pt-10 md:pt-16">
            <div class="max-w-3xl md:max-w-[31rem] lg:max-w-3xl">
                <p class="mb-3 text-xs font-semibold tracking-[.1em] text-mustOrange sm:mb-4 sm:text-sm sm:tracking-[.12em]">Our confidence is our capability</p>
                <h1 class="text-[2rem] font-medium leading-[1.15] text-white sm:text-4xl sm:leading-tight md:text-5xl lg:text-6xl">
                    Gifted Hands <span class="text-mustOrange">Pvt</span><br>
                    Clinic
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-white/75 sm:mt-6 sm:text-lg sm:leading-8 md:max-w-[23rem] lg:max-w-[25rem] xl:max-w-[29rem]">
                    Professional outpatient care, health consultations, appointments, and direct clinic visits <span class="block xl:inline">delivered with privacy, respect, and timely attention.</span>
                </p>
                <div class="mt-7 grid gap-3 sm:mt-8 sm:flex sm:flex-wrap">
                    <a href="#book-appointment" class="inline-flex justify-center rounded-full bg-mustGreen px-5 py-3 text-center font-semibold text-white hover:bg-mustOrangeDark">Request appointment</a>
                    <a href="{{ route('services') }}" class="inline-flex justify-center rounded-full border border-white/60 px-5 py-3 text-center font-semibold text-white hover:bg-white hover:text-mustBlue">View services</a>
                </div>
                <div class="mt-7 flex max-w-2xl flex-col gap-2 border-l-4 border-mustGreen pl-4 text-xs font-semibold leading-5 text-white/70 sm:mt-8 sm:flex-row sm:flex-wrap sm:items-center sm:gap-3 sm:gap-x-6 sm:pl-5 sm:text-sm">
                    <span>Open 24/7</span>
                    <span class="hidden h-4 w-px bg-white/35 sm:block"></span>
                    <span>Ambulance Available</span>
                    <span class="hidden h-4 w-px bg-white/35 sm:block"></span>
                    <span>Experienced Medical Team</span>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="about-us" class="bg-white" style="background-color: #FFFFFF;">
            <div class="mx-auto grid max-w-7xl gap-7 px-4 py-12 md:gap-8 md:py-16 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">About the clinic</p>
                    <h2 class="section-heading mt-3">About Us</h2>
                </div>
                <div class="border-l-4 border-mustGreen pl-4 sm:pl-6">
                    <p class="text-base leading-7 text-gray-700 md:text-lg md:leading-9">
                        For many years, we have proudly served our community with professional, patient-centered healthcare. Our experienced doctors and dedicated medical team provide a comprehensive range of quality healthcare services designed to meet the diverse needs of individuals and families.
                    </p>
                    <a href="{{ route('about') }}" class="mt-6 inline-flex rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">
                        Read More
                    </a>
                </div>
            </div>
        </section>

        <section class="bg-white pt-4">
            <div class="bg-white/20">
                <div class="mx-auto grid max-w-[96rem] grid-cols-2 gap-8 px-4 py-12 text-mustBlue sm:py-14 lg:grid-cols-4">
                <article class="flex flex-col items-center justify-center gap-3 text-center sm:gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-mustGreen/15 text-mustGreen sm:h-20 sm:w-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-11 sm:w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-1 text-3xl font-bold leading-none opacity-75 sm:text-4xl md:text-5xl" x-data="countUp(6, '+')" x-text="value">6+</p>
                        <p class="mt-2 text-sm font-medium text-gray-600 sm:mt-3 sm:text-base md:text-lg">Years of Experience</p>
                    </div>
                </article>

                <article class="flex flex-col items-center justify-center gap-3 text-center sm:gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-mustGreen/15 text-mustGreen sm:h-20 sm:w-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-11 sm:w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M12 3.75 4.5 7.5v5.25c0 4.5 3.15 7.35 7.5 8.25 4.35-.9 7.5-3.75 7.5-8.25V7.5L12 3.75Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-1 text-3xl font-bold leading-none opacity-75 sm:text-4xl md:text-5xl" x-data="countUp(10, '+')" x-text="value">10+</p>
                        <p class="mt-2 text-sm font-medium text-gray-600 sm:mt-3 sm:text-base md:text-lg">Core Services</p>
                    </div>
                </article>

                <article class="flex flex-col items-center justify-center gap-3 text-center sm:gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-mustGreen/15 text-mustGreen sm:h-20 sm:w-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-11 sm:w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0M18 10.5h3m-1.5-1.5v3" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-1 text-3xl font-bold leading-none opacity-75 sm:text-4xl md:text-5xl" x-data="countUp(15, '+')" x-text="value">15+</p>
                        <p class="mt-2 text-sm font-medium text-gray-600 sm:mt-3 sm:text-base md:text-lg">Medical Staff</p>
                    </div>
                </article>

                <article class="flex flex-col items-center justify-center gap-3 text-center sm:gap-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-mustGreen/15 text-mustGreen sm:h-20 sm:w-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-11 sm:w-11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9-3.75h-9m11.25-9H5.25A2.25 2.25 0 0 0 3 8.25v9A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-9A2.25 2.25 0 0 0 18.75 6ZM8.25 3.75v4.5m7.5-4.5v4.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-1 text-3xl font-bold leading-none opacity-75 sm:text-4xl md:text-5xl" x-data="countUp(500, '+')" x-text="value">500+</p>
                        <p class="mt-2 text-sm font-medium text-gray-600 sm:mt-3 sm:text-base md:text-lg">Appointments Served</p>
                    </div>
                </article>
                </div>
            </div>
        </section>

        <section id="services" class="bg-[#EFEFEF]">
            <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end md:gap-8 lg:gap-10">
                    <div class="max-w-3xl md:max-w-[32rem] lg:max-w-3xl">
                        <h2 class="section-heading">Clinic Services</h2>
                        <p class="mt-4 text-gray-600">Explore the core healthcare services available at the clinic for individuals, women, children, and families.</p>
                    </div>
                    <a href="{{ route('services') }}" class="inline-flex shrink-0 items-center self-start whitespace-nowrap rounded-full border border-mustOrange px-5 py-3 text-sm font-semibold text-mustGreen hover:bg-mustOrangeDark hover:text-white md:self-auto">
                        View More <span class="ml-2">&rarr;</span>
                    </a>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($featuredServices as $service)
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                            @if ($service->image_url)
                                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-44 w-full object-cover">
                            @else
                                <div class="flex h-44 w-full items-center justify-center bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500">
                                    No Image Uploaded
                                </div>
                            @endif

                            <div class="p-5 sm:p-6">
                                <h3 class="text-lg font-bold text-mustBlue">{{ $service->name }}</h3>
                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-600">{{ Str::limit($service->description, 180) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-gray-600 shadow-sm md:col-span-2 lg:col-span-3">
                            No services are available right now. Please contact the clinic for assistance.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="ambulance" class="relative isolate overflow-hidden bg-white text-gray-800">
            <div class="absolute -right-24 -top-24 -z-10 h-72 w-72 rounded-full bg-mustGreen/15 blur-3xl" aria-hidden="true"></div>
            <div class="absolute -bottom-32 left-1/3 -z-10 h-80 w-80 rounded-full bg-mustBlue/5 blur-3xl" aria-hidden="true"></div>

            <div class="mx-auto grid max-w-7xl gap-6 px-4 py-12 md:py-16 lg:grid-cols-2 lg:items-stretch">
                <div class="flex h-full flex-col rounded-xl border border-gray-200 bg-[#EFEFEF] p-6 shadow-sm sm:p-8">
                    <div class="inline-flex items-center gap-2 rounded-full border border-mustGreen/40 bg-mustGreen/10 px-4 py-2 text-sm font-semibold text-mustOrange">
                        <span class="relative flex h-2.5 w-2.5" aria-hidden="true">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-mustGreen opacity-75"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-mustGreen"></span>
                        </span>
                        Available 24 hours, 7 days a week
                    </div>

                    <p class="mt-6 text-sm font-semibold uppercase tracking-[.2em] text-mustOrange">Help when you need it</p>
                    <h2 class="mt-3 text-3xl font-semibold text-mustBlue md:text-4xl">24/7 Ambulance Service</h2>
                    <p class="mt-5 max-w-xl text-base leading-7 text-gray-600 md:text-lg md:leading-8">
                        Our ambulance service is available around the clock to coordinate urgent pickups and safe patient transfers. Call us at any hour and share your location so our team can assist.
                    </p>

                    <div class="mt-7 grid gap-4 sm:grid-cols-2">
                        <div class="flex gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-mustGreen/10 text-mustOrange">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-mustBlue">Day &amp; night availability</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Ambulance assistance is available every day, including nights and weekends.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-mustGreen/10 text-mustOrange">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 2.25 2.25L15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-mustBlue">Coordinated patient transport</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-600">We help arrange safe transport for patients who need timely medical attention.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 rounded-lg border border-gray-200 bg-white p-5 lg:mt-auto lg:pt-5">
                        <p class="text-sm font-semibold text-mustBlue">Need ambulance assistance now?</p>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Call directly and share your location and contact details with our team.</p>
                        <div class="mt-4">
                            <a href="tel:+265995767137" class="inline-flex items-center justify-center gap-2 rounded-full bg-mustGreen px-5 py-3 text-sm font-semibold text-white transition hover:bg-mustOrangeDark">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                Call +265 995 76 71 37
                            </a>
                        </div>
                    </div>
                </div>

                <figure class="group relative h-full min-h-72 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl lg:min-h-[34rem]">
                    <img src="{{ asset('imgs/Gifted-hands-ambulance-enhanced.png') }}" alt="Gifted Hands Private Clinic ambulance" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]">
                </figure>
            </div>
        </section>

        <section id="doctors" class="bg-[#EFEFEF]">
            <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end md:gap-8 lg:gap-10">
                    <div class="max-w-3xl md:max-w-[32rem] lg:max-w-3xl">
                        <h2 class="section-heading">Doctors</h2>
                        <p class="mt-4 text-gray-600">Meet the experienced medical professionals supporting patient-centered care at the clinic.</p>
                    </div>
                    <a href="{{ route('doctors') }}" class="inline-flex shrink-0 items-center self-start whitespace-nowrap rounded-full border border-mustOrange px-5 py-3 text-sm font-semibold text-mustGreen hover:bg-mustOrangeDark hover:text-white md:self-auto">
                        View More <span class="ml-2">&rarr;</span>
                    </a>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    @forelse ($doctors as $doctor)
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            @if ($doctor->image_url)
                                <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="h-56 w-full object-cover object-[50%_22%] sm:h-64">
                            @else
                                <div class="flex h-56 w-full items-center justify-center bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500 sm:h-64">
                                    No Image Uploaded
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-mustBlue">{{ $doctor->name }}</h3>
                                <p class="mt-1 text-sm font-semibold text-mustGreen">{{ $doctor->specialization }}</p>
                                <p class="mt-3 text-sm leading-6 text-gray-600"><strong class="text-mustBlue">Languages:</strong> {{ implode(', ', $doctor->languages ?? []) }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-gray-600 shadow-sm md:col-span-3">
                            No doctor profiles are available right now.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="book-appointment" class="bg-white" style="background-color: #FFFFFF;">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 md:py-16 lg:grid-cols-[.85fr_1.15fr]">
                <div>
                    <h2 class="section-heading">Request An Appointment</h2>
                    <p class="mt-4 leading-7 text-gray-600">
                        Tell us how to reach you and which service you need. You can request an appointment here, call ahead, or visit the clinic directly during service hours.
                    </p>
                    <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                        Submitting this form does not confirm an appointment. Any date and time you provide is a preference; the clinic will send the confirmed schedule by email after approval.
                    </div>
                    <div class="mt-6 space-y-2 text-sm text-gray-700">
                        <p><strong class="text-mustBlue">Phones:</strong> <a href="tel:+265995767137" class="hover:text-mustGreen">+265 995 76 71 37</a> / <a href="tel:+265888467878" class="hover:text-mustGreen">+265 888 467 878</a></p>
                        <p><strong class="text-mustBlue">Email:</strong> <a href="mailto:giftedhandspvtclinic@gmail.com" class="break-words hover:text-mustGreen">giftedhandspvtclinic@gmail.com</a></p>
                        <p><strong class="text-mustBlue">Location:</strong> Barron Avenue, Lilongwe, Malawi</p>
                    </div>
                </div>

                <form action="{{ route('appointments.request') }}#book-appointment" method="POST" class="min-w-0 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6" aria-labelledby="appointment-form-heading">
                    @csrf

                    <h3 id="appointment-form-heading" class="text-xl font-bold text-mustBlue">Your appointment request</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        Fields marked <span class="font-semibold text-red-600">*</span> are required. We need your email address to send the pending confirmation and final decision.
                    </p>

                    @if (session('success'))
                        <div class="mt-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm leading-6 text-green-800" role="status">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->hasAny(['client_name', 'client_phone', 'client_email', 'service_id', 'preferred_at', 'request_message']))
                        <div class="mt-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm leading-6 text-red-800" role="alert">
                            Please check the highlighted fields and submit your request again.
                        </div>
                    @endif

                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="appointment-client-name" class="label">
                                Full name <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="appointment-client-name"
                                type="text"
                                name="client_name"
                                class="input @error('client_name') input-invalid @enderror"
                                value="{{ old('client_name') }}"
                                autocomplete="name"
                                required
                                aria-required="true"
                                @error('client_name') aria-invalid="true" aria-describedby="appointment-client-name-error" @enderror
                            >
                            @error('client_name')
                                <p id="appointment-client-name-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="appointment-client-phone" class="label">
                                Phone number <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="appointment-client-phone"
                                type="tel"
                                name="client_phone"
                                class="input @error('client_phone') input-invalid @enderror"
                                value="{{ old('client_phone') }}"
                                autocomplete="tel"
                                inputmode="tel"
                                required
                                aria-required="true"
                                @error('client_phone') aria-invalid="true" aria-describedby="appointment-client-phone-error" @enderror
                            >
                            @error('client_phone')
                                <p id="appointment-client-phone-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="appointment-client-email" class="label">
                                Email address <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="appointment-client-email"
                                type="email"
                                name="client_email"
                                class="input @error('client_email') input-invalid @enderror"
                                value="{{ old('client_email') }}"
                                autocomplete="email"
                                required
                                aria-required="true"
                                @error('client_email') aria-invalid="true" aria-describedby="appointment-client-email-error" @enderror
                            >
                            @error('client_email')
                                <p id="appointment-client-email-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="appointment-preferred-at" class="label">Preferred date and time <span class="font-normal text-gray-500">(optional)</span></label>
                            <input
                                id="appointment-preferred-at"
                                type="datetime-local"
                                name="preferred_at"
                                class="input datetime-no-placeholder {{ old('preferred_at') ? 'has-value' : '' }} @error('preferred_at') input-invalid @enderror"
                                value="{{ old('preferred_at') }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                onchange="this.classList.toggle('has-value', this.value !== '')"
                                oninput="this.classList.toggle('has-value', this.value !== '')"
                                aria-describedby="appointment-preferred-at-help @error('preferred_at') appointment-preferred-at-error @enderror"
                                @error('preferred_at') aria-invalid="true" @enderror
                            >
                            <p id="appointment-preferred-at-help" class="field-help">This helps us coordinate availability but is not a confirmed booking.</p>
                            @error('preferred_at')
                                <p id="appointment-preferred-at-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="appointment-service" class="label">
                                Service <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <select
                                id="appointment-service"
                                name="service_id"
                                class="input @error('service_id') input-invalid @enderror"
                                required
                                aria-required="true"
                                @error('service_id') aria-invalid="true" aria-describedby="appointment-service-error" @enderror
                            >
                                <option value="">Select a service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @selected((int) old('service_id') === $service->id)>{{ $service->name }}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p id="appointment-service-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="appointment-request-message" class="label">Additional information <span class="font-normal text-gray-500">(optional)</span></label>
                            <textarea
                                id="appointment-request-message"
                                name="request_message"
                                rows="4"
                                class="input @error('request_message') input-invalid @enderror"
                                @error('request_message') aria-invalid="true" aria-describedby="appointment-request-message-error" @enderror
                            >{{ old('request_message') }}</textarea>
                            @error('request_message')
                                <p id="appointment-request-message-error" class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-5 w-full rounded-full bg-mustGreen px-5 py-3 font-semibold text-white transition hover:bg-mustOrangeDark focus:outline-none focus:ring-4 focus:ring-mustGreen/25 sm:w-auto">
                        Submit appointment request
                    </button>
                </form>
            </div>
        </section>

        <section id="announcements" class="bg-white" style="background-color: #FFFFFF;">
            <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end md:gap-8 lg:gap-10">
                    <div class="max-w-3xl md:max-w-[32rem] lg:max-w-3xl">
                        <h2 class="section-heading">Announcements</h2>
                        <p class="mt-4 text-gray-600">Latest clinic updates, service notices, and important visitor information.</p>
                    </div>
                    <a href="{{ route('announcements') }}" class="inline-flex shrink-0 items-center self-start whitespace-nowrap rounded-full border border-mustOrange px-5 py-3 text-sm font-semibold text-mustGreen hover:bg-mustOrangeDark hover:text-white md:self-auto">
                        View More <span class="ml-2">&rarr;</span>
                    </a>
                </div>
                <div class="mt-8 grid grid-flow-row-dense gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($announcements as $announcement)
                        @if ($announcement->image_path)
                            <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                                <div class="aspect-[16/9] overflow-hidden bg-[#EAF4F9]">
                                    <img
                                        src="{{ $announcement->image_url }}"
                                        alt="{{ $announcement->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                </div>
                                <div class="p-5">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                                        @include('public.partials.announcement-posted-label', ['announcement' => $announcement])
                                    </div>
                                    <h3 class="mt-3 font-bold text-mustBlue">{{ $announcement->title }}</h3>
                                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ Str::limit($announcement->message, 180) }}</p>
                                </div>
                            </article>
                        @else
                            <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                                    @include('public.partials.announcement-posted-label', ['announcement' => $announcement])
                                </div>
                                <h3 class="mt-3 font-bold text-mustBlue">{{ $announcement->title }}</h3>
                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ Str::limit($announcement->message, 180) }}</p>
                            </article>
                        @endif
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-5 text-center text-sm text-gray-500 shadow-sm md:col-span-2 lg:col-span-3">
                            No announcements are available right now.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="gallery" class="bg-[#EFEFEF]">
            <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end md:gap-8 lg:gap-10">
                    <div class="max-w-3xl md:max-w-[32rem] lg:max-w-3xl">
                        <h2 class="section-heading">Gallery</h2>
                        <p class="mt-4 text-gray-600">A place to show clinic rooms, reception areas, equipment, and team moments for visitor confidence.</p>
                    </div>
                    <a href="{{ route('gallery') }}" class="inline-flex shrink-0 items-center self-start whitespace-nowrap rounded-full border border-mustOrange px-5 py-3 text-sm font-semibold text-mustGreen hover:bg-mustOrangeDark hover:text-white md:self-auto">
                        View More <span class="ml-2">&rarr;</span>
                    </a>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <figure data-gallery-item class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/_MG_2080.jpg') }}" alt="Clinic reception area" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Reception Area</figcaption>
                    </figure>
                    <figure data-gallery-item class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/consultation room.jpeg') }}" alt="Clinic consultation room" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Consultation Room</figcaption>
                    </figure>
                    <figure data-gallery-item class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/services/physiotherapy picture.jpeg') }}" alt="Clinic physiotherapy space" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Physiotherapy</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <section id="faqs" class="bg-[#EFEFEF]">
            <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end md:gap-8 lg:gap-10">
                    <div class="max-w-3xl md:max-w-[32rem] lg:max-w-3xl">
                        <h2 class="section-heading">FAQs</h2>
                        <p class="mt-4 text-gray-600">Answers to common visitor questions before they book or visit.</p>
                    </div>
                    <a href="{{ route('faqs') }}" class="inline-flex shrink-0 items-center self-start whitespace-nowrap rounded-full border border-mustOrange px-5 py-3 text-sm font-semibold text-mustGreen hover:bg-mustOrangeDark hover:text-white md:self-auto">
                        View More <span class="ml-2">&rarr;</span>
                    </a>
                </div>
                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    @forelse ($faqs as $faq)
                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="font-bold text-mustBlue">{{ $faq->question }}</h3>
                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ $faq->brief_answer }}</p>
                        </article>
                    @empty
                        <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-gray-600 shadow-sm md:col-span-2">
                            No FAQs are available right now.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>

    @include('public.partials.footer')
</body>

</html>
