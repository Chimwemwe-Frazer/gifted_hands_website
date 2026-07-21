<footer id="site-footer" class="bg-mustBlue text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 md:grid-cols-2 lg:grid-cols-[1.25fr_0.8fr_0.9fr_1.05fr]">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-4">
                <img src="{{ asset('imgs/logo/gifted-hands-logo-footer.png') }}" alt="{{ config('app.name') }}" class="h-20 w-20 object-contain drop-shadow-md md:h-24 md:w-24">
                <span class="text-lg font-semibold">{{ config('app.name', 'Gifted Hands Private Clinic') }}</span>
            </a>
            <p class="mt-4 max-w-sm text-sm leading-7 text-gray-200">
                Professional, patient-centered private healthcare for individuals and families in Lilongwe.
            </p>
            <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-full bg-mustGreen px-5 py-3 text-sm font-semibold text-white hover:bg-mustOrangeDark">
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
                <p>
                    <span class="block font-semibold text-white">Postal Address</span>
                    P.O. Box 1535, Lilongwe, Malawi
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

<a
    href="https://wa.me/265888467878"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Chat with Gifted Hands Private Clinic on WhatsApp"
    title="Chat with us on WhatsApp"
    class="fixed bottom-20 right-6 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-black/20 transition hover:-translate-y-1 hover:bg-[#20BD5A] focus:outline-none focus:ring-4 focus:ring-[#25D366]/35"
>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.273.297-1.04 1.016-1.04 2.479s1.065 2.875 1.213 3.074c.149.198 2.095 3.2 5.077 4.487.709.306 1.262.489 1.693.626.712.226 1.36.194 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.981.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.99c-.002 5.45-4.437 9.884-9.888 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
    </svg>
</a>

<button
    type="button"
    aria-label="Back to top"
    x-cloak
    x-data="{
        visible: false,
        active: false,
        inFooter: false,
        hovering: false,
        hero: null,
        footer: null,
        idleTimer: null,
        update() {
            this.hero = this.hero || document.querySelector('body > header');
            this.footer = this.footer || document.querySelector('footer');
            const heroBottom = this.hero ? this.hero.getBoundingClientRect().bottom + window.scrollY : 260;
            const beyondHero = window.scrollY > Math.max(heroBottom - 24, 180);
            const footerRect = this.footer ? this.footer.getBoundingClientRect() : null;
            this.inFooter = footerRect ? footerRect.top < window.innerHeight - 24 && footerRect.bottom > 24 : false;
            this.visible = (this.active || this.hovering) && beyondHero;
        },
        wake() {
            this.active = true;
            this.update();
            clearTimeout(this.idleTimer);
            this.idleTimer = setTimeout(() => {
                if (this.hovering) {
                    return;
                }
                this.active = false;
                this.update();
            }, 5000);
        },
        hold() {
            this.hovering = true;
            clearTimeout(this.idleTimer);
            this.update();
        },
        release() {
            this.hovering = false;
            this.wake();
        },
        init() {
            this.update();
            window.addEventListener('scroll', () => this.wake(), { passive: true });
            window.addEventListener('wheel', () => this.wake(), { passive: true });
            window.addEventListener('touchmove', () => this.wake(), { passive: true });
            window.addEventListener('resize', () => this.update());
        }
    }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="translate-y-3 scale-90 opacity-0"
    x-transition:enter-end="translate-y-0 scale-100 opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-y-0 scale-100 opacity-100"
    x-transition:leave-end="translate-y-3 scale-90 opacity-0"
    @mouseenter="hold()"
    @mouseleave="release()"
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    :class="inFooter ? 'bg-white/80 text-mustGreen shadow-white/20' : 'bg-mustBlue text-mustGreen shadow-mustBlue/30'"
    class="fixed bottom-6 right-6 z-50 flex h-11 w-11 items-center justify-center rounded-full shadow-xl transition hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-mustGreen/35"
>
    <span class="-mt-1 text-3xl font-semibold leading-none">&uarr;</span>
</button>
