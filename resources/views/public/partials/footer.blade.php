<footer class="bg-mustBlue text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 md:grid-cols-2 lg:grid-cols-[1.25fr_0.8fr_0.9fr_1.05fr]">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('imgs/logo/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-14 w-14 object-contain">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gifted Hands Private Clinic') }}</span>
            </a>
            <p class="mt-4 max-w-sm text-sm leading-7 text-gray-200">
                Professional, patient-centered private healthcare for individuals and families in Lilongwe.
            </p>
            <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-md bg-mustGreen px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">
                Request Appointment
            </a>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-[.16em] text-mustGreen">Quick Links</h2>
            <nav class="mt-4 grid gap-3 text-sm text-gray-200">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('about') }}" class="hover:text-white">About Us</a>
                <a href="{{ route('doctors') }}" class="hover:text-white">Doctors</a>
                <a href="{{ route('schedule') }}" class="hover:text-white">Clinic Schedule</a>
                <a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a>
            </nav>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-[.16em] text-mustGreen">Services</h2>
            <nav class="mt-4 grid gap-3 text-sm text-gray-200">
                <a href="{{ route('services') }}" class="hover:text-white">General Consultation</a>
                <a href="{{ route('services') }}" class="hover:text-white">Obstetrics &amp; Gynaecology</a>
                <a href="{{ route('services') }}" class="hover:text-white">Under-5 Clinic</a>
                <a href="{{ route('services') }}" class="hover:text-white">Physiotherapy</a>
                <a href="{{ route('services') }}" class="hover:text-white">Laboratory Services</a>
            </nav>
        </div>

        <div>
            <h2 class="text-sm font-bold uppercase tracking-[.16em] text-mustGreen">Contact</h2>
            <div class="mt-4 space-y-3 text-sm leading-6 text-gray-200">
                <p>
                    <span class="block font-semibold text-white">Phone</span>
                    <a href="tel:+265995767137" class="hover:text-white">+265 995 76 71 37</a>
                </p>
                <p>
                    <span class="block font-semibold text-white">Email</span>
                    <a href="mailto:giftedhandspvtclinic@gmail.com" class="break-words hover:text-white">giftedhandspvtclinic@gmail.com</a>
                </p>
                <p>
                    <span class="block font-semibold text-white">Location</span>
                    Barron Avenue, Lilongwe, Malawi
                </p>
            </div>
        </div>
    </div>

    <div class="border-t border-white/15 px-4 py-5">
        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-3 text-sm text-gray-300 md:flex-row md:items-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Gifted Hands Private Clinic') }}. All rights reserved.</p>
            <div class="flex flex-wrap gap-x-5 gap-y-2">
                <a href="{{ route('announcements') }}" class="hover:text-white">Announcements</a>
                <a href="{{ route('faqs') }}" class="hover:text-white">FAQs</a>
                <a href="{{ route('login') }}" class="hover:text-white">Staff login</a>
            </div>
        </div>
    </div>
</footer>
