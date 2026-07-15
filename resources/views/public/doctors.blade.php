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
    <header class="relative overflow-hidden bg-mustBlue bg-cover bg-center text-white" style="background-image: url('{{ asset('imgs/doctors.png') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[32%] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-16">
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

        <div class="mt-10 grid gap-6 lg:grid-cols-3">
            @foreach ([
                [
                    'name' => 'Dr. Mercy Banda',
                    'specialization' => 'General Practitioner',
                    'qualification' => 'MBBS, Diploma in Family Medicine',
                    'image' => 'imgs/doctors/mercy-banda.png',
                    'experience' => 'Years of experience: To be confirmed',
                    'bio' => 'Dr. Banda provides first-contact care for patients with everyday health concerns, routine reviews, and ongoing follow-up needs.',
                    'interests' => ['Family medicine', 'General consultation', 'Preventive health', 'Chronic condition follow-up'],
                    'languages' => ['English', 'Chichewa'],
                ],
                [
                    'name' => 'Dr. Thoko Phiri',
                    'specialization' => 'Obstetrics & Gynaecology',
                    'qualification' => 'MBBS, MMED Obstetrics & Gynaecology',
                    'image' => 'imgs/doctors/thoko-phiri.png',
                    'experience' => 'Years of experience: To be confirmed',
                    'bio' => 'Dr. Phiri supports women with antenatal care, reproductive health guidance, family planning, and routine gynaecological reviews.',
                    'interests' => ['Antenatal care', 'Family planning', 'Women\'s health reviews', 'Reproductive health'],
                    'languages' => ['English', 'Chichewa'],
                ],
                [
                    'name' => 'Dr. Daniel Kamanga',
                    'specialization' => 'Physiotherapy & Rehabilitation',
                    'qualification' => 'BSc Physiotherapy, Certified Rehabilitation Specialist',
                    'image' => 'imgs/doctors/daniel-kamanga.png',
                    'experience' => 'Years of experience: To be confirmed',
                    'bio' => 'Dr. Kamanga helps patients improve movement, manage pain, and recover strength through practical rehabilitation plans.',
                    'interests' => ['Mobility support', 'Pain management', 'Post-injury recovery', 'Functional rehabilitation'],
                    'languages' => ['English', 'Chichewa', 'Tumbuka'],
                ],
            ] as $doctor)
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset($doctor['image']) }}" alt="{{ $doctor['name'] }}" class="h-80 w-full object-cover object-top">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-mustBlue">{{ $doctor['name'] }}</h2>
                        <p class="mt-1 text-sm font-semibold text-mustGreen">{{ $doctor['specialization'] }}</p>
                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ $doctor['qualification'] }}</p>
                        <p class="mt-3 text-sm leading-7 text-gray-600">{{ $doctor['bio'] }}</p>

                        <div class="mt-5 border-t border-gray-200 pt-5">
                            <h3 class="font-bold text-mustBlue">Areas of interest</h3>
                            <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                                @foreach ($doctor['interests'] as $interest)
                                    <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $interest }}</span></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-5 grid gap-4 border-t border-gray-200 pt-5 text-sm leading-6 text-gray-600">
                            <p><strong class="text-mustBlue">Experience:</strong> {{ $doctor['experience'] }}</p>
                            <p><strong class="text-mustBlue">Languages:</strong> {{ implode(', ', $doctor['languages']) }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
