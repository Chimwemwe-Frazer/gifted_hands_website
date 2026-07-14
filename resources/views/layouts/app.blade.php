<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="bg-gray-100 h-screen font-sans antialiased leading-none" x-data="{ sidebarOpen: true, mobileNavOpen: false, isMobile: window.innerWidth < 768 }"
    @resize.window="
        isMobile = window.innerWidth < 768;
        if (!isMobile) { mobileNavOpen = false; }
      ">

    <div class="flex h-full">

        <!-- Mobile Sidebar Background Overlay -->
        <div x-show="mobileNavOpen" x-transition.opacity @click="mobileNavOpen = false"
            @keydown.escape="mobileNavOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"></div>

        <!-- Sidebar -->
        <div x-cloak
            class="bg-mustBlue text-gray-100 w-64 flex-none fixed inset-y-0 left-0 transition-transform duration-300 ease-in-out z-30 overflow-y-auto"
            :class="{
                '-translate-x-full': (isMobile && !mobileNavOpen) || (!isMobile && !sidebarOpen),
                'translate-x-0': (isMobile && mobileNavOpen) || (!isMobile && sidebarOpen)
            }">

            <a href="/" class="py-2 px-4  font-bold text-lg  flex items-center">
                <img src="{{ asset('imgs/logo/gifted-hands-logo.png') }}" alt="Logo" class="w-[37.5px]">
                <span class="ml-2 text-gray-100">{{ config('app.name') }}</span>
            </a>
            @include('layouts.navigation')
        </div>

        <!-- Main Content -->
        <div x-cloak class="flex flex-col flex-1 transition-all duration-300"
            :class="{ 'ml-64': sidebarOpen && !isMobile, 'ml-0': !sidebarOpen || isMobile }">
            <!-- Top navigation bar -->
            <header class="bg-gray-100 shadow-lg py-1 px-6 flex justify-between items-center">
                <div class="text-lg font-semibold flex items-center space-x-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-gray-700 cursor-pointer md:hidden"
                        @click="mobileNavOpen = !mobileNavOpen">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                    </svg>

                    <!-- Desktop Sidebar Toggle -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 text-gray-700 cursor-pointer hidden md:block hover:text-mustGreen"
                        @click="sidebarOpen = !sidebarOpen">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                    </svg>
                    <div x-data="greetingComponent()" class="text-lg font-semibold text-gray-600">
                        <span x-text="greeting"></span>
                    </div>
                </div>
                <div x-data="{ open: false }" class="flex items-center">
                    <div class="relative text-gray-700 hidden md:block">
                        {{ auth()->user()->name }}
                    </div>

                    <div x-data="{ open: false }" class="relative inline-block ml-4 rounded-full">
                        <div>
                            <button @click="open = !open" type="button"
                                class="rounded-full text-gray-700 hover:text-gray-900 border border-gray-200">
                                <div x-data="avatarComponent('{{ auth()->user()->name }}')"
                                    class="w-11 h-11 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">
                                    <span x-text="initials"></span>
                                </div>
                            </button>
                        </div>

                        <!-- Dropdown panel, show/hide based on dropdown state. -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1" role="menu" aria-orientation="vertical"
                                aria-labelledby="options-menu">
                                <!-- Other menu items -->
                                <a href="{{ route('admin.profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Update Password</a>
                                <!-- Logout Form -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content area -->
            <main class="flex-1  p-6 space-y-2 md:space-y-4 bg-gray-200 ">
                <div class="max-w-7xl mx-auto overflow-x-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success',
                toast: true,
                position: 'top-end',
                timer: 5000,
                showConfirmButton: false,
            });
        </script>

        @php Session::forget('success'); @endphp
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'error',
                text: '{{ session('error') }}',
                icon: 'error',
                toast: true,
                position: 'top-end',
                timer: 5000,
                showConfirmButton: false,
            });
        </script>
        @php session()->forget('error') @endphp
    @endif

    @if (session('errors'))
        <script>
            Swal.fire({
                title: 'error',
                text: 'Please check your inputs',
                icon: 'error',
                toast: true,
                position: 'top-end',
                timer: 5000,
                showConfirmButton: false,
            });
        </script>
        @php session()->forget('errors') @endphp
    @endif

    @yield('scripts')

    <script>
        function avatarComponent(name) {
            return {
                initials: name.split(' ').map(word => word[0].toUpperCase()).join('')
            };
        }

        function greetingComponent() {
            return {
                greeting: '',
                setGreeting() {
                    const hour = new Date().getHours();
                    if (hour < 12) {
                        this.greeting = "Good Morning";
                    } else if (hour < 18) {
                        this.greeting = "Good Afternoon";
                    } else {
                        this.greeting = "Good Evening";
                    }
                },
                init() {
                    this.setGreeting();
                }
            };
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete_item").forEach(function(button) {
                button.addEventListener("click", function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#F1842F",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, do it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest("form").submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
