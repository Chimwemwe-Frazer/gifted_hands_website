<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Staff</title>

    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

</head>

<body class="bg-cover bg-center" style="background-image: url('{{ asset('imgs/Medical team home page.jpeg') }}');">
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 mx-6 ">

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
            <div class=" justify-center items-center flex flex-col py-4 space-y-4 opacity-90">
                <img src="{{ asset('imgs/logo/gifted-hands-logo-nav.png') }}" alt="{{ config('app.name') }} logo" class="w-16 h-16 mx-auto">
                <h1 class="text-2xl md:text-3xl text-gray-500 opacity-90">{{ config('app.name') }}</h1>
            </div>

            @yield('content')

        </div>
    </div>
</body>

</html>
