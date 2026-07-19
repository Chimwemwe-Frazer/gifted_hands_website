<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>About Us | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>

    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden md:bg-right lg:bg-center" style="background-image: url('{{ asset('imgs/about-us-bg.jpg') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">About the clinic</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">About Us</h1>
        </div>
    </header>

    <main>
        <section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 md:grid-cols-[1fr_0.72fr] md:items-start md:gap-8 lg:grid-cols-[1fr_0.8fr] lg:gap-10">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Who we are</p>
                <h2 class="mt-3 text-3xl font-bold text-mustBlue">Patient-Centered Private Healthcare</h2>
                <p class="mt-4 text-lg leading-9 text-gray-700">
                    For many years, we have proudly served our community with professional, patient-centered healthcare. Our experienced doctors and dedicated medical team provide a comprehensive range of quality healthcare services designed to meet the diverse needs of individuals and families.
                </p>
                <p class="mt-6 text-lg leading-9 text-gray-700">
                    Our work is guided by compassion, privacy, and reliable clinical attention. We aim to make every visit clear and comfortable, from the first appointment request to the care and guidance provided by our medical team.
                </p>
                <p class="mt-6 text-lg leading-9 text-gray-700">
                    The clinic continues to grow as a trusted place for families and individuals seeking accessible private healthcare, practical advice, and timely support.
                </p>
            </div>

            <aside class="rounded-lg border border-gray-200 bg-[#EFEFEF] p-6">
                <h2 class="text-xl font-bold text-mustBlue">At A Glance</h2>
                <div class="mt-5 space-y-4 text-sm leading-6 text-gray-600">
                    <p><strong class="text-mustBlue">Located in:</strong> Barron Avenue, Lilongwe, Malawi.</p>
                    <p><strong class="text-mustBlue">Serving:</strong> Individuals, mothers, children, workers, and families.</p>
                    <p><strong class="text-mustBlue">Focused on:</strong> Clear communication, respectful care, and timely support.</p>
                </div>
            </aside>
        </section>

        <section class="bg-[#EFEFEF] px-4 py-16">
            <div class="mx-auto grid max-w-7xl gap-10 md:grid-cols-[0.9fr_1.1fr] md:items-start md:gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:gap-10">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Our story</p>
                    <h2 class="mt-3 text-3xl font-bold text-mustBlue">Clinic History</h2>
                    <p class="mt-4 leading-8 text-gray-600">
                        {{ config('app.name', 'Gifted Hands Private Clinic') }} was established to provide accessible, respectful, and reliable private healthcare for patients and families in Lilongwe. The clinic exists to make everyday healthcare easier to reach, easier to understand, and more responsive to the needs of the community.
                    </p>
                    <p class="mt-4 leading-8 text-gray-600">
                        Since opening, the clinic has focused on serving individuals, children, mothers, families, and workers who need timely medical attention, practical advice, and coordinated follow-up care. Exact founding details can be added here once confirmed.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3 md:grid-cols-1 lg:grid-cols-3">
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[.16em] text-mustGreen">Opened</p>
                        <p class="mt-3 text-lg font-bold text-mustBlue">Add founding year</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Placeholder for the year the clinic officially opened.</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[.16em] text-mustGreen">Purpose</p>
                        <p class="mt-3 text-lg font-bold text-mustBlue">Accessible private care</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Built to support clear, compassionate, and timely healthcare.</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[.16em] text-mustGreen">Community</p>
                        <p class="mt-3 text-lg font-bold text-mustBlue">Lilongwe families</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Serving patients and households around Barron Avenue and greater Lilongwe.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16">
            <div class="grid gap-10 md:grid-cols-[0.78fr_1.22fr] md:items-start md:gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:gap-10">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Why visit us</p>
                    <h2 class="mt-3 text-3xl font-bold text-mustBlue">Why Visit Gifted Hands</h2>
                    <p class="mt-4 leading-8 text-gray-600">
                        Patients visit the clinic for attentive service, practical guidance, and healthcare support that is close to home.
                    </p>
                    <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">
                        Request Appointment
                    </a>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ([
                        ['Comprehensive care', 'General consultation, women\'s health, child wellness, laboratory services, and physiotherapy support in one clinic.'],
                        ['Patient-centered service', 'Care is organized around clear communication, respect, and the needs of each patient.'],
                        ['Convenient Lilongwe location', 'The clinic is located on Barron Avenue for easier access by patients in and around the city.'],
                        ['Responsive appointment support', 'Patients can request appointments online and receive follow-up from the clinic team.'],
                    ] as [$title, $description])
                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-bold text-mustBlue">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-[#EFEFEF] px-4 py-16">
            <div class="mx-auto max-w-7xl">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">How we care</p>
                    <h2 class="mt-3 text-3xl font-bold text-mustBlue">Care Principles</h2>
                    <p class="mt-4 leading-8 text-gray-600">
                        Every visit should feel organized, respectful, and safe. These principles guide how the clinic receives patients, handles information, and coordinates care.
                    </p>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['Confidentiality', 'Patient information is handled with privacy and respect at every stage of care.'],
                        ['Patient Safety', 'Clinical attention is delivered with careful assessment, clean processes, and appropriate follow-up.'],
                        ['Compassion', 'Patients are listened to with kindness, dignity, and patience.'],
                        ['Timely Care', 'The clinic aims to respond promptly and guide patients clearly on the next step.'],
                    ] as [$title, $description])
                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-bold text-mustBlue">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-gray-600">{{ $description }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-8 bg-white py-16">
            <div class="mx-auto max-w-7xl px-4">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Our facility</p>
                    <h2 class="mt-3 text-3xl font-bold text-mustBlue">Facility Highlights</h2>
                    <p class="mt-4 leading-8 text-gray-600">
                        The clinic is organized to support essential outpatient care, family health services, diagnostics, and rehabilitation. Specific room photos and equipment details can be added as they become available.
                    </p>
                </div>

                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['Consultation Rooms', 'Private spaces for assessment, diagnosis, counselling, and follow-up care.', 'imgs/facilities/consultation-room.png'],
                        ['Laboratory', 'A dedicated area for diagnostic testing and sample handling.', 'imgs/facilities/laboratory.png'],
                        ['Under-5 Area', 'Child-focused care space for growth monitoring, wellness checks, and immunization support.', 'imgs/facilities/under-5-area.png'],
                        ['Physiotherapy Space', 'Room for rehabilitation, mobility support, and guided recovery sessions.', 'imgs/facilities/physiotherapy-space.png'],
                    ] as [$title, $description, $image])
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <img src="{{ asset($image) }}" alt="{{ $title }}" class="h-44 w-full object-cover md:h-52 lg:h-44">
                            <div class="p-5">
                                <h3 class="text-lg font-bold text-mustBlue">{{ $title }}</h3>
                                <p class="mt-3 text-sm leading-7 text-gray-600">{{ $description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    @include('public.partials.footer')
</body>

</html>
