@php
    $tabletNavPage = request()->routeIs('schedule', 'announcements', 'faqs') ? 1 : 0;
@endphp

<nav class="relative z-50 px-4 pt-5" x-data="{ page: {{ $tabletNavPage }}, mobileOpen: false }" @keydown.escape.window="mobileOpen = false">
    <div class="public-nav-shell" @if (request()->routeIs('home')) @click.outside="mobileOpen = false" @endif>
        <a href="{{ route('home') }}" class="flex shrink-0 items-center" aria-label="{{ config('app.name', 'Gifted Hands Private Clinic') }}">
            <img src="{{ asset('imgs/logo/gifted-hands-logo-nav.png') }}" alt="{{ config('app.name') }}" class="h-[60px] w-[60px] object-contain md:h-[68px] md:w-[68px]">
        </a>

        <div class="public-nav-links public-nav-links--desktop" aria-label="Primary navigation">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
            <a href="{{ route('doctors') }}" class="{{ request()->routeIs('doctors') ? 'active' : '' }}">Doctors</a>
            <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }}">Clinic Schedule</a>
            <a href="{{ route('announcements') }}" class="{{ request()->routeIs('announcements') ? 'active' : '' }}">Announcements</a>
            <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('faqs') }}" class="{{ request()->routeIs('faqs') ? 'active' : '' }}">FAQs</a>
            <a href="{{ route('contact') }}" class="public-nav-action {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        </div>

        <div class="public-nav-pager" aria-label="Tablet primary navigation">
            <div class="public-nav-page-frame">
                <div class="public-nav-page" x-show="page === 0" x-transition.opacity.duration.150ms @if ($tabletNavPage !== 0) x-cloak @endif>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                    <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
                    <a href="{{ route('doctors') }}" class="{{ request()->routeIs('doctors') ? 'active' : '' }}">Doctors</a>
                    <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
                </div>

                <div class="public-nav-page" x-show="page === 1" x-transition.opacity.duration.150ms @if ($tabletNavPage !== 1) x-cloak @endif>
                    <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }}">Clinic Schedule</a>
                    <a href="{{ route('announcements') }}" class="{{ request()->routeIs('announcements') ? 'active' : '' }}">Announcements</a>
                    <a href="{{ route('faqs') }}" class="{{ request()->routeIs('faqs') ? 'active' : '' }}">FAQs</a>
                </div>
            </div>

            <button type="button" class="public-nav-arrow" :aria-label="page === 0 ? 'Show next navigation links' : 'Show previous navigation links'" @click="page = page === 0 ? 1 : 0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="page === 1 ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.22 4.22a.75.75 0 0 1 1.06 0l5.25 5.25a.75.75 0 0 1 0 1.06l-5.25 5.25a.75.75 0 1 1-1.06-1.06L11.94 10 7.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <a href="{{ route('contact') }}" class="public-nav-action public-nav-action--pager {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        </div>

        @if (request()->routeIs('home'))
            <button
                type="button"
                class="public-nav-mobile-toggle"
                aria-label="Toggle primary navigation"
                aria-controls="home-mobile-navigation"
                :aria-expanded="mobileOpen.toString()"
                @click="mobileOpen = ! mobileOpen"
            >
                <svg x-show="! mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>

            <div
                id="home-mobile-navigation"
                class="public-nav-mobile-panel"
                role="navigation"
                aria-label="Mobile primary navigation"
                x-show="mobileOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="-translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="-translate-y-2 opacity-0"
            >
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" @click="mobileOpen = false">Home</a>
                <a href="{{ route('about') }}" @click="mobileOpen = false">About Us</a>
                <a href="{{ route('services') }}" @click="mobileOpen = false">Services</a>
                <a href="{{ route('doctors') }}" @click="mobileOpen = false">Doctors</a>
                <a href="{{ route('schedule') }}" @click="mobileOpen = false">Clinic Schedule</a>
                <a href="{{ route('announcements') }}" @click="mobileOpen = false">Announcements</a>
                <a href="{{ route('gallery') }}" @click="mobileOpen = false">Gallery</a>
                <a href="{{ route('faqs') }}" @click="mobileOpen = false">FAQs</a>
                <a href="{{ route('contact') }}" class="public-nav-mobile-action" @click="mobileOpen = false">Contact Us</a>
            </div>
        @endif
    </div>
</nav>
