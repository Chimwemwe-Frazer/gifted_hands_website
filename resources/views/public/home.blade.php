<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gifted Hands Private Clinic') }}</title>

    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="home-page bg-white text-gray-800">
    @php
        $heroSlides = [
            ['image' => 'imgs/hero section image.png'],
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
                    Professional outpatient care, health consultations, and appointment-based clinical services <span class="block xl:inline">delivered with privacy, respect, and timely attention.</span>
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
                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:p-6">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-mustGreen/10 text-mustGreen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8m3.75 0A7.75 7.75 0 1 1 4.25 12a7.75 7.75 0 0 1 15.5 0Z" />
                            </svg>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-mustBlue">General Consultation</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Receive comprehensive medical assessments and expert diagnosis for a wide range of health concerns from our experienced healthcare professionals.</p>
                    </article>

                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:p-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-mustGreen/10 text-mustGreen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.35 7-11.25A4.75 4.75 0 0 0 10.5 6.8 4.75 4.75 0 0 0 2 9.75C2 16.65 9 21 9 21h3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.5v5m-2.5-2.5h5" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-mustBlue">Obstetrics &amp; Gynaecology</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Compassionate healthcare for women, including pregnancy care, reproductive health, family planning, and routine gynaecological services.</p>
                </article>

                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:p-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-mustGreen/10 text-mustGreen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM5.25 20.25a6.75 6.75 0 0 1 13.5 0" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 4.5h3m-1.5-1.5v3" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-mustBlue">Under-5 Clinic</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Dedicated healthcare services for infants and young children, including growth monitoring, immunizations, and routine child wellness check-ups.</p>
                </article>

                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:p-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-mustGreen/10 text-mustGreen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25 12 3.75l4.5 4.5M12 4.5V15m-5.25 5.25h10.5M8.25 15.75c-1.5.75-2.25 1.5-2.25 2.25 0 1.25 2.7 2.25 6 2.25s6-1 6-2.25c0-.75-.75-1.5-2.25-2.25" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-mustBlue">Physiotherapy</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Restore mobility, reduce pain, and improve physical function through personalized rehabilitation and physiotherapy treatment plans.</p>
                </article>

                <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md sm:p-6 md:col-span-2 lg:col-span-1">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-mustGreen/10 text-mustGreen">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 3.75v5.1L5.4 17.1A2.25 2.25 0 0 0 7.32 20.5h9.36a2.25 2.25 0 0 0 1.92-3.4l-5.1-8.25v-5.1" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75h6M8.25 15.75h7.5" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-mustBlue">Laboratory Services</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Reliable laboratory testing and diagnostic services that support accurate diagnosis and effective treatment for better patient care.</p>
                </article>
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
                    <img src="{{ asset('imgs/ambulance/ambulance-response-vehicle.png') }}" alt="Ambulance response vehicle ready outside a clinic" class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]">
                    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-mustBlue/90 to-transparent px-5 pb-4 pt-14 text-sm font-semibold text-white">Response vehicle</figcaption>
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
                    <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/doctors/mercy-banda.png') }}" alt="Dr. Mercy Banda" class="h-56 w-full object-cover object-[50%_22%] sm:h-64">
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-mustBlue">Dr. Mercy Banda</h3>
                            <p class="mt-1 text-sm font-semibold text-mustGreen">General Practitioner</p>
                            <p class="mt-3 text-sm leading-6 text-gray-600">MBBS, Diploma in Family Medicine</p>
                        </div>
                    </article>

                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset('imgs/doctors/thoko-phiri.png') }}" alt="Dr. Thoko Phiri" class="h-56 w-full object-cover object-[50%_22%] sm:h-64">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-mustBlue">Dr. Thoko Phiri</h3>
                        <p class="mt-1 text-sm font-semibold text-mustGreen">Obstetrics &amp; Gynaecology</p>
                        <p class="mt-3 text-sm leading-6 text-gray-600">MBBS, MMED Obstetrics &amp; Gynaecology</p>
                    </div>
                </article>

                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset('imgs/doctors/daniel-kamanga.png') }}" alt="Dr. Daniel Kamanga" class="h-56 w-full object-cover object-[50%_22%] sm:h-64">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-mustBlue">Dr. Daniel Kamanga</h3>
                        <p class="mt-1 text-sm font-semibold text-mustGreen">Physiotherapy &amp; Rehabilitation</p>
                        <p class="mt-3 text-sm leading-6 text-gray-600">BSc Physiotherapy, Certified Rehabilitation Specialist</p>
                    </div>
                </article>
                </div>
            </div>
        </section>

        <section id="book-appointment" class="bg-white" style="background-color: #FFFFFF;">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 md:py-16 lg:grid-cols-[.85fr_1.15fr]">
                <div>
                    <h2 class="section-heading">Request An Appointment</h2>
                    <p class="mt-4 leading-7 text-gray-600">
                        This form is for appointment coordination only. It collects contact details so the appointments officer can respond; it is not a patient records system.
                    </p>
                    <div class="mt-6 space-y-2 text-sm text-gray-700">
                        <p><strong class="text-mustBlue">Phone:</strong> <a href="tel:+265995767137" class="hover:text-mustGreen">+265 995 76 71 37</a></p>
                        <p><strong class="text-mustBlue">Email:</strong> <a href="mailto:giftedhandspvtclinic@gmail.com" class="break-words hover:text-mustGreen">giftedhandspvtclinic@gmail.com</a></p>
                        <p><strong class="text-mustBlue">Location:</strong> Barron Avenue, Lilongwe, Malawi</p>
                    </div>
                </div>

                <form action="{{ route('appointments.request') }}" method="POST" class="min-w-0 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                @csrf

                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-800">{{ session('success') }}</div>
                @endif

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="label">Name</label>
                        <input name="client_name" class="input" required value="{{ old('client_name') }}">
                        <span class="text-sm text-red-500">{{ $errors->first('client_name') }}</span>
                    </div>
                    <div>
                        <label class="label">Phone</label>
                        <input name="client_phone" class="input" required value="{{ old('client_phone') }}">
                        <span class="text-sm text-red-500">{{ $errors->first('client_phone') }}</span>
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" name="client_email" class="input" value="{{ old('client_email') }}">
                        <span class="text-sm text-red-500">{{ $errors->first('client_email') }}</span>
                    </div>
                    <div>
                        <label class="label">Preferred date and time</label>
                        <input type="datetime-local" name="appointment_at" class="input" value="{{ old('appointment_at') }}">
                        <span class="text-sm text-red-500">{{ $errors->first('appointment_at') }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <label class="label">Service</label>
                        <select name="service_id" class="input" required>
                            <option value="">Select a service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected((int) old('service_id') === $service->id)>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-sm text-red-500">{{ $errors->first('service_id') }}</span>
                    </div>
                    <div class="md:col-span-2">
                        <label class="label">Message</label>
                        <textarea name="reason" rows="4" class="input">{{ old('reason') }}</textarea>
                        <span class="text-sm text-red-500">{{ $errors->first('reason') }}</span>
                    </div>
                </div>

                <button type="submit" class="mt-5 w-full rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark sm:w-auto">Send request</button>
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
                            <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm md:col-span-2">
                                <div class="grid h-full md:grid-cols-2">
                                    <div>
                                        <img
                                            src="{{ $announcement->image_url }}"
                                            alt="{{ $announcement->title }}"
                                            class="h-52 w-full object-cover md:h-full md:min-h-56"
                                        >
                                    </div>
                                    <div class="flex flex-col justify-center p-5">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                                            <p class="text-xs font-medium text-gray-400">{{ $announcement->posted_label }}</p>
                                        </div>
                                        <h3 class="mt-3 font-bold text-mustBlue">{{ $announcement->title }}</h3>
                                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ Str::limit($announcement->message, 240) }}</p>
                                    </div>
                                </div>
                            </article>
                        @else
                            <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                                    <p class="text-xs font-medium text-gray-400">{{ $announcement->posted_label }}</p>
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
                    <figure class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/optimixed.jpg') }}" alt="Clinic reception area" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Reception Area</figcaption>
                    </figure>
                    <figure class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/optimixed.jpg') }}" alt="Clinic consultation room" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Consultation Room</figcaption>
                    </figure>
                    <figure class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('imgs/optimixed.jpg') }}" alt="Clinic laboratory services" class="h-48 w-full object-cover">
                        <figcaption class="p-4 text-sm font-semibold text-mustBlue">Laboratory</figcaption>
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
                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-mustBlue">Do I need an appointment?</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Appointments are recommended so the clinic can confirm availability before you visit.</p>
                    </article>
                    <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <h3 class="font-bold text-mustBlue">Can I request a specific service?</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Yes. Select a service in the booking form and the appointments officer will follow up.</p>
                    </article>
                </div>
            </div>
        </section>

    </main>

    @include('public.partials.footer')
</body>

</html>
