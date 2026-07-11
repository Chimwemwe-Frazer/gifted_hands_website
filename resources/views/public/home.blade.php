<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gifted Hands Private Clinic') }}</title>

    <link rel="icon" href="{{ asset('imgs/logo/logo-white.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative min-h-[92vh] bg-cover bg-center" style="background-image: linear-gradient(rgba(16, 39, 74, .72), rgba(16, 39, 74, .45)), url('{{ asset('imgs/optimixed.jpg') }}');">
        <nav class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 text-white lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('imgs/logo/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-12 w-12 object-contain">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gifted Hands Private Clinic') }}</span>
            </a>
            <div class="flex flex-wrap items-center gap-x-5 gap-y-3 text-sm font-semibold">
                <a href="{{ route('home') }}" class="hover:text-mustGreen">Home</a>
                <a href="#about-us" class="hover:text-mustGreen">About Us</a>
                <a href="#services" class="hover:text-mustGreen">Services</a>
                <a href="#doctors" class="hover:text-mustGreen">Doctors</a>
                <a href="#book-appointment" class="hover:text-mustGreen">Book Appointment</a>
                <a href="#announcements" class="hover:text-mustGreen">Announcements</a>
                <a href="#gallery" class="hover:text-mustGreen">Gallery</a>
                <a href="#faqs" class="hover:text-mustGreen">FAQs</a>
                <a href="#contact-us" class="hover:text-mustGreen">Contact Us</a>
            </div>
        </nav>

        <div class="mx-auto flex max-w-7xl flex-col justify-center px-4 pb-20 pt-20 text-white md:pt-28">
            <div class="max-w-3xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Private clinic care</p>
                <h1 class="text-4xl font-extrabold leading-tight md:text-6xl">{{ config('app.name', 'Gifted Hands Private Clinic') }}</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-100">
                    Professional outpatient care, health consultations, and appointment-based clinical services delivered with privacy, respect, and timely attention.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#book-appointment" class="rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">Request appointment</a>
                    <a href="#services" class="rounded-md border border-white/60 px-5 py-3 font-semibold text-white hover:bg-white hover:text-mustBlue">View services</a>
                </div>
                <div class="mt-8 flex max-w-2xl flex-col gap-3 border-l-4 border-mustGreen pl-5 text-sm font-semibold text-gray-100 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-6">
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
        <section id="services" class="mx-auto max-w-7xl px-4 py-16">
            <div class="max-w-3xl">
                <h2 class="section-heading">Clinic Services</h2>
                <p class="mt-4 text-gray-600">The clinic website is focused on helping visitors understand what care is available and how to request an appointment.</p>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($services as $service)
                    <article class="rounded-lg border border-gray-200 p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-mustBlue">{{ $service->name }}</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">{{ $service->description ?: 'Contact the clinic for details about this service.' }}</p>
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $service->duration_minutes }} minutes</span>
                            @if ((float) $service->fee > 0)
                                <span class="font-semibold text-mustBlue">MWK {{ number_format((float) $service->fee, 2) }}</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <article class="rounded-lg border border-gray-200 p-5 shadow-sm">
                        <h3 class="text-lg font-bold text-mustBlue">General Consultation</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Contact the clinic to ask about available services and appointment times.</p>
                    </article>
                @endforelse
            </div>
        </section>

        <section id="about-us" class="bg-gray-50">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-16 md:grid-cols-3">
                <div>
                    <h2 class="section-heading">About Us</h2>
                    <p class="mt-4 text-gray-600">A private clinic focused on accessible, respectful outpatient care and clear communication with every visitor.</p>
                </div>
                <div class="md:col-span-2 grid gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-3xl font-extrabold text-mustGreen">01</p>
                        <h3 class="mt-2 font-bold text-mustBlue">Private care</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Respectful consultations in a professional clinic setting.</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-mustGreen">02</p>
                        <h3 class="mt-2 font-bold text-mustBlue">Clear services</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Public content can be updated by staff as services change.</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-mustGreen">03</p>
                        <h3 class="mt-2 font-bold text-mustBlue">Appointment support</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Requests go to the clinic team for follow-up and confirmation.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="doctors" class="mx-auto max-w-7xl px-4 py-16">
            <div class="max-w-3xl">
                <h2 class="section-heading">Doctors</h2>
                <p class="mt-4 text-gray-600">Meet the clinic team and available practitioners. Add doctor profiles from the admin content area as the clinic grows.</p>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <article class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Clinic Doctor</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">General consultation and outpatient care.</p>
                </article>
                <article class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Visiting Specialist</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Specialist availability can be announced to visitors here.</p>
                </article>
                <article class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Nursing Team</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Support for appointments, vitals, and patient guidance.</p>
                </article>
            </div>
        </section>

        <section id="book-appointment" class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-[.85fr_1.15fr]">
            <div>
                <h2 class="section-heading">Request An Appointment</h2>
                <p class="mt-4 leading-7 text-gray-600">
                    This form is for appointment coordination only. It collects contact details so the appointments officer can respond; it is not a patient records system.
                </p>
                <div class="mt-6 space-y-2 text-sm text-gray-700">
                    <p><strong class="text-mustBlue">Phone:</strong> Add clinic phone number</p>
                    <p><strong class="text-mustBlue">Email:</strong> Add clinic email address</p>
                    <p><strong class="text-mustBlue">Location:</strong> Add clinic physical address</p>
                </div>
            </div>

            <form action="{{ route('appointments.request') }}" method="POST" class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
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

                <button type="submit" class="mt-5 rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">Send request</button>
            </form>
        </section>

        <section id="announcements" class="bg-gray-50">
            <div class="mx-auto max-w-7xl px-4 py-16">
                <div class="max-w-3xl">
                    <h2 class="section-heading">Announcements</h2>
                    <p class="mt-4 text-gray-600">Share clinic updates, visiting doctor schedules, holiday hours, and public health notices.</p>
                </div>
                <div class="mt-8 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">No announcements yet</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">New announcements will appear here when published by the clinic team.</p>
                </div>
            </div>
        </section>

        <section id="gallery" class="mx-auto max-w-7xl px-4 py-16">
            <div class="max-w-3xl">
                <h2 class="section-heading">Gallery</h2>
                <p class="mt-4 text-gray-600">A place to show clinic rooms, reception areas, equipment, and team moments for visitor confidence.</p>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="h-48 rounded-lg bg-gray-100"></div>
                <div class="h-48 rounded-lg bg-gray-100"></div>
                <div class="h-48 rounded-lg bg-gray-100"></div>
            </div>
        </section>

        <section id="faqs" class="bg-gray-50">
            <div class="mx-auto max-w-7xl px-4 py-16">
                <div class="max-w-3xl">
                    <h2 class="section-heading">FAQs</h2>
                    <p class="mt-4 text-gray-600">Answers to common visitor questions before they book or visit.</p>
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

        <section id="contact-us" class="mx-auto max-w-7xl px-4 py-16">
            <div class="max-w-3xl">
                <h2 class="section-heading">Contact Us</h2>
                <p class="mt-4 text-gray-600">Reach the clinic directly for directions, service availability, and appointment confirmation.</p>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Phone</h3>
                    <p class="mt-2 text-sm text-gray-600">Add clinic phone number</p>
                </div>
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Email</h3>
                    <p class="mt-2 text-sm text-gray-600">Add clinic email address</p>
                </div>
                <div class="rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h3 class="font-bold text-mustBlue">Location</h3>
                    <p class="mt-2 text-sm text-gray-600">Add clinic physical address</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-mustBlue px-4 py-8 text-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 text-sm md:flex-row">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Gifted Hands Private Clinic') }}. All rights reserved.</p>
            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Staff login</a>
        </div>
    </footer>
</body>

</html>
