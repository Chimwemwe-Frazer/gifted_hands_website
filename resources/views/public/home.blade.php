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
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 text-white">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('imgs/logo/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-12 w-12 object-contain">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gifted Hands Private Clinic') }}</span>
            </a>
            <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
                <a href="#services" class="hover:text-mustGreen">Services</a>
                <a href="#about" class="hover:text-mustGreen">About</a>
                <a href="#appointment" class="hover:text-mustGreen">Appointments</a>
                <a href="{{ route('login') }}" class="rounded-md border border-white/50 px-3 py-2 hover:bg-white hover:text-mustBlue">Staff login</a>
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
                    <a href="#appointment" class="rounded-md bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-green-700">Request appointment</a>
                    <a href="#services" class="rounded-md border border-white/60 px-5 py-3 font-semibold text-white hover:bg-white hover:text-mustBlue">View services</a>
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

        <section id="about" class="bg-gray-50">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-16 md:grid-cols-3">
                <div>
                    <h2 class="section-heading">Why Visit Us</h2>
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

        <section id="appointment" class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-[.85fr_1.15fr]">
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
    </main>

    <footer class="bg-mustBlue px-4 py-8 text-white">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 text-sm md:flex-row">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Gifted Hands Private Clinic') }}. All rights reserved.</p>
            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Staff login</a>
        </div>
    </footer>
</body>

</html>
