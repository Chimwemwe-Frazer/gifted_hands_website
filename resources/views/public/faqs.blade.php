<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FAQs | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="bg-mustBlue text-white">
        <nav class="relative z-50 flex flex-col gap-4 bg-mustBlue/95 px-4 py-4 text-white shadow-lg backdrop-blur lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('imgs/logo/gifted-hands-logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-12 object-contain">
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
                <a href="{{ route('faqs') }}" class="text-mustGreen">FAQs</a>
                <a href="{{ route('contact') }}" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>
        <div class="mx-auto max-w-7xl px-4 py-16">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Helpful answers</p>
            <h1 class="mt-3 text-4xl font-bold leading-tight md:text-5xl">FAQs</h1>
            <p class="mt-4 max-w-2xl text-gray-200">Quick answers to help patients decide when to visit, what to bring, and how to prepare.</p>
        </div>
    </header>

    <main class="bg-gray-50">
        <div class="mx-auto max-w-4xl px-4 py-16">
            <div class="space-y-4">
            @foreach ([
                [
                    'question' => 'Do I need an appointment?',
                    'brief' => 'Appointments are recommended before visiting.',
                    'full' => 'Appointments are recommended so the clinic can confirm the right service, provider availability, and the best time for your visit. You can request an appointment through the website or call the clinic before coming.',
                ],
                [
                    'question' => 'How does the appointment process work?',
                    'brief' => 'Submit a request and wait for clinic confirmation.',
                    'full' => 'Send an appointment request with your name, contact details, preferred service, and preferred visit time. The clinic team will review the request and contact you to confirm availability. For same-day or urgent visits, calling before visiting is the best option.',
                ],
                [
                    'question' => 'Can I walk in without booking?',
                    'brief' => 'Walk-ins may be assisted depending on availability.',
                    'full' => 'Walk-in patients may be assisted depending on the day, clinic schedule, and patient volume. Booking or calling first is recommended, especially for Obstetrics and Gynae, Under-5 Clinic, Diet and Nutrition, and Physiotherapy services.',
                ],
                [
                    'question' => 'Can patients call before visiting?',
                    'brief' => 'Yes, calling ahead is encouraged.',
                    'full' => 'Yes. Patients are encouraged to call before visiting to confirm opening times, service availability, booking requirements, and what documents or samples may be needed for their visit.',
                ],
                [
                    'question' => 'What payment methods are accepted?',
                    'brief' => 'Please confirm payment options before your visit.',
                    'full' => 'Payment options may vary by service and day. Patients should call the clinic before visiting to confirm whether cash, mobile money, bank transfer, card payment, or other payment methods are available at that time.',
                ],
                [
                    'question' => 'Do you accept insurance or medical schemes?',
                    'brief' => 'Please check with the clinic before attending.',
                    'full' => 'Insurance and medical scheme acceptance can depend on the scheme, service type, and current clinic arrangements. Please call ahead with your scheme details so the clinic can confirm whether it is accepted and explain any payment or claim requirements.',
                ],
                [
                    'question' => 'What should I do in an emergency?',
                    'brief' => 'Call the clinic or seek urgent emergency care immediately.',
                    'full' => 'For urgent symptoms, call the clinic immediately for guidance. If the situation is severe or life-threatening, go to the nearest emergency facility or call local emergency support without waiting for an online appointment response. Sunday services are for emergencies and special bookings.',
                ],
                [
                    'question' => 'What is needed for the Under-5 Clinic?',
                    'brief' => 'Bring the child health record and any medicines.',
                    'full' => 'For Under-5 Clinic visits, bring the child health passport or clinic card, immunization record, any current medicines, and previous test results if available. A parent or guardian should be present to provide the child\'s medical history and consent for care.',
                ],
                [
                    'question' => 'How are lab results collected?',
                    'brief' => 'The clinic will advise when and how results are ready.',
                    'full' => 'After sample collection or testing, the clinic team will advise when results are expected and how they can be collected. Some results may require review by a clinician so the findings can be explained and the next step can be discussed.',
                ],
                [
                    'question' => 'Is my information private and confidential?',
                    'brief' => 'Yes, patient information is handled confidentially.',
                    'full' => 'Patient consultations, personal details, and medical information are handled with confidentiality. Information is used for patient care and clinic administration, and sensitive details should only be shared with authorized clinic staff.',
                ],
                [
                    'question' => 'Where is the clinic located?',
                    'brief' => 'Gifted Hands Private Clinic is on Barron Avenue, Lilongwe.',
                    'full' => 'The clinic is located on Barron Avenue in Lilongwe. If you are unsure of the exact entrance, parking point, or nearby landmark, call the clinic before travelling so the team can guide you using the most current directions.',
                ],
                [
                    'question' => 'Can I request a specific service?',
                    'brief' => 'Yes, choose the service when requesting an appointment.',
                    'full' => 'Yes. Select or mention the service you need when requesting an appointment, such as General Clinic, Obs and Gynae, Under-5 Clinic, Diet and Nutrition, Physiotherapy, or Laboratory Services. The clinic team will follow up based on availability.',
                ],
                [
                    'question' => 'Is ambulance support available?',
                    'brief' => 'Contact the clinic directly for urgent arrangements.',
                    'full' => 'The clinic advertises ambulance availability. For urgent arrangements, contact the clinic directly by phone so the team can advise what support is available and what immediate steps to take.',
                ],
            ] as $faq)
                <article x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <button type="button" class="flex w-full items-start justify-between gap-4 text-left" @click="open = ! open" :aria-expanded="open.toString()">
                        <span class="font-bold text-mustBlue">{{ $faq['question'] }}</span>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-mustBlue text-xl font-bold leading-none text-mustBlue" x-text="open ? '-' : '+'">+</span>
                    </button>
                    <p class="mt-2 text-sm leading-7 text-gray-600" x-show="! open">{{ $faq['brief'] }}</p>
                    <p class="mt-3 text-sm leading-7 text-gray-600" x-show="open">{{ $faq['full'] }}</p>
                </article>
            @endforeach
            </div>
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
