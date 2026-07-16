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
    <header class="relative overflow-hidden bg-mustBlue bg-cover bg-center text-white md:bg-right lg:bg-center" style="background-image: url('{{ asset('imgs/stethoscope.jpg') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-16 md:py-20 lg:py-16">
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
            @foreach ([
                [
                    'title' => 'General Consultation',
                    'image' => 'imgs/services/general-consultation.png',
                    'summary' => 'Comprehensive medical assessment for everyday illness, new symptoms, ongoing concerns, and follow-up care.',
                    'includes' => ['Clinical history and examination', 'Diagnosis and treatment plan', 'Prescriptions where appropriate', 'Referral guidance when specialist care is needed'],
                    'needs' => ['Fever, cough, headache, stomach pain, infections, fatigue, minor injuries, blood pressure concerns, and general wellness checks'],
                    'bring' => ['National ID or clinic card if available', 'Current medicines or prescriptions', 'Previous test results or referral notes'],
                    'access' => 'Appointments are preferred so the clinic can prepare for your visit. Walk-ins may be assisted depending on daily availability.',
                ],
                [
                    'title' => 'Obstetrics & Gynaecology',
                    'image' => 'imgs/services/obstetrics-gynaecology.png',
                    'summary' => 'Respectful women\'s health support, maternity care, reproductive health guidance, and routine gynaecological reviews.',
                    'includes' => ['Antenatal care and pregnancy reviews', 'Family planning counselling', 'Reproductive health consultations', 'Routine gynaecological assessment and follow-up'],
                    'needs' => ['Pregnancy care, menstrual concerns, pelvic discomfort, fertility questions, contraception needs, postnatal reviews, and women\'s wellness checks'],
                    'bring' => ['Health passport or antenatal records', 'Previous scan or laboratory results', 'Current medicines and any referral notes'],
                    'access' => 'Appointments are strongly recommended for maternity and gynaecology visits so the clinic can confirm provider availability.',
                ],
                [
                    'title' => 'Under-5 Clinic',
                    'image' => 'imgs/services/under-5-clinic.png',
                    'summary' => 'Child-focused care for infants and young children, including wellness checks, growth monitoring, and parent guidance.',
                    'includes' => ['Growth monitoring', 'Child wellness checks', 'Immunization support and guidance', 'Nutrition and caregiver counselling'],
                    'needs' => ['Routine child check-ups, feeding concerns, fever, cough, growth concerns, immunization questions, and follow-up reviews'],
                    'bring' => ['Child health passport', 'Immunization records', 'Any previous prescriptions or test results'],
                    'access' => 'Appointments are preferred, especially for child wellness reviews. Walk-ins can call ahead to confirm availability.',
                ],
                [
                    'title' => 'Physiotherapy',
                    'image' => 'imgs/services/physiotherapy.png',
                    'summary' => 'Rehabilitation support to improve mobility, reduce pain, restore function, and guide recovery after injury or illness.',
                    'includes' => ['Movement and functional assessment', 'Personalized exercise guidance', 'Pain and mobility support', 'Recovery planning and progress reviews'],
                    'needs' => ['Back pain, joint pain, muscle strain, post-injury recovery, mobility limitations, weakness, and rehabilitation after medical events'],
                    'bring' => ['Referral notes if available', 'Previous scans or reports', 'Comfortable clothing for movement assessment'],
                    'access' => 'Appointments are preferred so the physiotherapy team can plan enough time for assessment and guided exercises.',
                ],
                [
                    'title' => 'Laboratory Services',
                    'image' => 'imgs/services/laboratory-services.png',
                    'summary' => 'Diagnostic testing support for accurate assessment, treatment decisions, and follow-up care.',
                    'includes' => ['Sample collection and handling', 'Common tests such as malaria screening, pregnancy testing, urinalysis, blood sugar checks, and other requested tests where available', 'Results support for clinical decision-making', 'Guidance on when results may be ready'],
                    'needs' => ['Routine tests, infection checks, pregnancy-related tests, follow-up monitoring, and tests requested during consultation'],
                    'bring' => ['Test request form if referred', 'Clinic notes or doctor request', 'Any preparation instructions already given, such as fasting guidance'],
                    'access' => 'Sample collection is available during normal clinic hours. Turnaround time depends on the test type, so patients should ask the clinic team for expected timing.',
                ],
            ] as $service)
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <div class="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
                        <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" class="h-72 w-full object-cover md:hidden lg:block lg:h-full {{ $loop->even ? 'lg:order-2' : '' }}">

                        <div class="p-6 md:p-7 lg:p-8 {{ $loop->even ? 'lg:order-1' : '' }}">
                            <div class="grid gap-5 md:grid-cols-2 md:items-start lg:block">
                                <div>
                                    <h2 class="text-2xl font-bold text-mustBlue">{{ $service['title'] }}</h2>
                                    <p class="mt-3 leading-8 text-gray-600">{{ $service['summary'] }}</p>
                                </div>

                                <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" class="hidden h-48 w-full rounded-lg object-cover md:block lg:hidden">
                            </div>

                            <div class="mt-6 grid gap-5 md:grid-cols-2">
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-[.14em] text-mustGreen">What is included</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                                        @foreach ($service['includes'] as $item)
                                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-[.14em] text-mustGreen">Needs treated</h3>
                                    <p class="mt-3 text-sm leading-7 text-gray-600">{{ $service['needs'][0] }}</p>
                                </div>
                            </div>

                            <div class="mt-6 grid gap-5 border-t border-gray-200 pt-5 md:grid-cols-2">
                                <div>
                                    <h3 class="font-bold text-mustBlue">What to bring</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                                        @foreach ($service['bring'] as $item)
                                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="font-bold text-mustBlue">Appointments</h3>
                                    <p class="mt-3 text-sm leading-7 text-gray-600">{{ $service['access'] }}</p>
                                </div>
                            </div>

                            <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">
                                Request appointment for this service
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    </main>
    @include('public.partials.footer')
</body>

</html>
