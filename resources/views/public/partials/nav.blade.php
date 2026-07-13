<nav class="relative z-50 px-4 pt-5">
    <div class="public-nav-shell">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center" aria-label="{{ config('app.name', 'Gifted Hands Private Clinic') }}">
            <img src="{{ asset('imgs/logo/gifted-hands-logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-10 object-contain md:h-12 md:w-12">
        </a>

        <div class="public-nav-links">
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
    </div>
</nav>
