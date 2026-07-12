<nav x-data="{ open: false, dropdownOpen: null, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })" class="fixed top-0 w-full z-[1000]">
    <div :class="{ 'bg-black/60 shadow-md backdrop-blur-md': scrolled, 'bg-transparent': !scrolled }"
        class="absolute inset-0 w-full h-full transition-all duration-300">
    </div>

    <div class="relative container mx-auto px-4 flex justify-between items-center h-20 z-10">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('imgs/logo/adda.png') }}" alt="Logo" class="h-12 md:h-16">
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex md:space-x-4 lg:space-x-8">
            <a href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'text-mustGreen' : 'text-gray-200 hover:text-mustGreen' }}">Home</a>
            <a href="{{ url('/courses') }}"
                class="text-gray-200 hover:text-mustGreen {{ Str::startsWith(Route::currentRouteName(), 'front.courses') ? 'text-mustGreen' : '' }}">Courses</a>

            <!-- Mega Menu: Departments -->
            <div class="relative" @mouseenter="dropdownOpen = 'departments'" @mouseleave="dropdownOpen = null">
                <button class=" hover:text-mustGreen flex items-center {{ Str::startsWith(Route::currentRouteName(), 'front.department.show') ? 'text-mustGreen' : 'text-gray-200' }}">
                    Units
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <!-- Mega Menu Content -->
                <div x-cloak x-show="dropdownOpen === 'departments'" x-transition
                    class="absolute md:w-[400px] mt-2 lg:w-[600px] bg-white shadow-lg rounded-lg p-6 grid grid-cols-2 gap-6">
                    @if ($departments)
                        @foreach ($departments as $department)
                            <!-- Department 1 -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $department->name }}</h3>
                                <p class="text-gray-600 text-sm">
                                    {!! Str::limit($department->description, 50, '...') !!}
                                </p>
                                <a href="{{ route('front.department.show', $department->slug) }}"
                                    class="text-mustGreen hover:text-mustOrangeDark text-sm font-semibold">Learn More
                                    →</a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600 text-sm">No departments found.</p>
                    @endif

                </div>
            </div>
            <a href="{{ url('/staff') }}"
                class="{{ Str::startsWith(Route::currentRouteName(), 'front.staff') ? 'text-mustGreen' : 'text-gray-200 hover:text-mustGreen' }}">Staff</a>

            <a href="{{ url('/news') }}"
                class="text-gray-200 hover:text-mustGreen {{ Str::startsWith(Route::currentRouteName(), 'front.news') ? 'text-mustGreen' : '' }}">News
                & Events</a>
            <a href="{{ url('/about') }}"
                class="{{ Str::startsWith(Route::currentRouteName(), 'front.about') ? 'text-mustGreen' : 'text-gray-200 hover:text-mustGreen' }}">About</a>

        </div>

        <div class="flex items-center space-x-4">
            <!-- Search Icon -->
            <button x-on:click.prevent="$dispatch('open-modal', 'searchModal')"
                class="text-gray-200 hover:text-mustGreen focus:no-outline hidden md:block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>

            <!-- Apply Now Button -->
            <a href="{{ url('/apply') }}" class="hidden md:inline-block btn-primary">
                Apply Now
            </a>
        </div>

        <div class="flex items-center space-x-4 md:hidden">
            <button x-on:click.prevent="$dispatch('open-modal', 'searchModal')"
                class="text-gray-200 hover:text-mustGreen focus:no-outline md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
            <!-- Mobile Menu Button -->
            <button @click="open = !open" class=" text-gray-200 hover:text-mustGreen">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Search Modal -->
    <x-modal name="searchModal" :maxWidth="'lg'" focusable>
        <x-search></x-search>
    </x-modal>


    <!-- Mobile Menu -->
    <div x-cloak x-show="open" x-transition @click.away="open = false"
        class="md:hidden bg-white border-t w-full fixed top-16 left-0 shadow-lg z-50">
        <div class="px-6 py-4 space-y-2">
            <a href="{{ url('/') }}" class="block text-gray-700 hover:bg-gray-100 px-4 py-2 rounded {{ request()->is('/') ? 'text-mustGreen' : '' }}">Home</a>
            <a href="{{ url('/courses') }}"
                class="block text-gray-700 hover:bg-gray-100 px-4 py-2 rounded {{ Str::startsWith(Route::currentRouteName(), 'front.courses') ? 'text-mustGreen' : '' }}">Courses</a>

            <!-- Departments Dropdown -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex justify-between items-center w-full text-gray-700 hover:bg-gray-100 px-4 py-2 {{ Str::startsWith(Route::currentRouteName(), 'front.department') ? 'text-mustGreen' : 'text-gray-200' }}">
                    Units
                    <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-transition class="pl-6 space-y-1 mt-2">
                    @foreach ($departments as $department)
                        <a href="{{ route('front.department.show', $department->slug) }}"
                            class="block text-gray-600 hover:bg-gray-100 px-4 py-2 rounded">{{ $department->name }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ url('/staff') }}" class="block text-gray-700 hover:bg-gray-100 px-4 py-2 {{ Str::startsWith(Route::currentRouteName(), 'front.staff') ? 'text-mustGreen' : 'text-gray-200' }}">Staff</a>
            <a href="{{ url('/news') }}" class="block text-gray-700 hover:bg-gray-100 px-4 py-2 {{ Str::startsWith(Route::currentRouteName(), 'front.news') ? 'text-mustGreen' : 'text-gray-200' }}">News & Events</a>
            <a href="{{ url('/about') }}" class="block text-gray-700 hover:bg-gray-100 px-4 py-2 {{ Str::startsWith(Route::currentRouteName(), 'front.about') ? 'text-mustGreen' : 'text-gray-200' }}">About</a>

            <!-- Apply Now Button -->
            <a href="{{ url('/apply') }}"
                class="block bg-mustGreen text-white text-center font-semibold px-4 py-3 rounded">Apply Now</a>
        </div>
    </div>

</nav>
