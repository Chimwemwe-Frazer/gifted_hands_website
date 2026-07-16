@php
    $tabletNavPage = request()->routeIs('schedule', 'announcements', 'gallery', 'faqs') ? 1 : 0;
@endphp

<nav class="relative z-50 px-4 pt-5" x-data="{ page: {{ $tabletNavPage }} }">
    <div class="public-nav-shell">
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
                </div>

                <div class="public-nav-page" x-show="page === 1" x-transition.opacity.duration.150ms @if ($tabletNavPage !== 1) x-cloak @endif>
                    <a href="{{ route('schedule') }}" class="{{ request()->routeIs('schedule') ? 'active' : '' }}">Clinic Schedule</a>
                    <a href="{{ route('announcements') }}" class="{{ request()->routeIs('announcements') ? 'active' : '' }}">Announcements</a>
                    <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
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
    </div>
</nav>
