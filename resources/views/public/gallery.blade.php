<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gallery | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden" style="background-image: url('{{ asset('imgs/medical team one.jpeg') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Clinic moments gallery</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Gallery</h1>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-16">
        @php
            $galleryItems = [
                ['caption' => 'Reception Area', 'image' => 'imgs/_MG_2080.jpg'],
                ['caption' => 'Consultation Room', 'image' => 'imgs/consultation room.jpeg'],
                ['caption' => 'Laboratory', 'image' => 'imgs/services/_MG_2134.jpg'],
                ['caption' => 'Pharmacy', 'image' => 'imgs/_MG_2125_2.jpg'],
                ['caption' => 'Care Team', 'image' => 'imgs/Medical team home page.jpeg'],
                ['caption' => 'Care Team', 'image' => 'imgs/medical team one.jpeg'],
                ['caption' => 'Care Team', 'image' => 'imgs/medical team two.jpeg'],
                ['caption' => 'Care Team', 'image' => 'imgs/medical team three.jpeg'],
                ['caption' => 'Care Team', 'image' => 'imgs/medical team four.jpeg'],
            ];
        @endphp

        <div class="grid gap-5 md:grid-cols-3">
            @foreach ($galleryItems as $item)
                <figure data-gallery-item class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['caption'] }}" class="h-64 w-full object-cover">
                    <figcaption class="p-4 text-sm font-semibold text-mustBlue">{{ $item['caption'] }}</figcaption>
                </figure>
            @endforeach
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
