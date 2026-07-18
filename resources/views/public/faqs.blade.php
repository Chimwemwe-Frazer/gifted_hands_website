<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FAQs | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden" style="background-image: url('{{ asset('imgs/faq.png') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Helpful answers</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">FAQs</h1>
            <p class="mt-4 max-w-md text-gray-200">Quick answers to help patients decide when to visit, what to bring, and how to prepare.</p>
        </div>
    </header>

    <main class="bg-[#EFEFEF]">
        <div class="mx-auto max-w-4xl px-4 py-16">
            <div class="space-y-4">
                @forelse ($faqs as $faq)
                    <article x-data="{ open: false }" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                        <button type="button" class="flex w-full items-start justify-between gap-4 text-left" @click="open = ! open" :aria-expanded="open.toString()">
                            <span class="font-bold text-mustBlue">{{ $faq->question }}</span>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-mustBlue text-xl font-bold leading-none text-mustBlue" x-text="open ? '-' : '+'">+</span>
                        </button>
                        <p class="mt-2 whitespace-pre-line text-sm leading-7 text-gray-600" x-show="! open">{{ $faq->brief_answer }}</p>
                        <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600" x-show="open">{{ $faq->full_answer }}</p>
                    </article>
                @empty
                    <div class="rounded-lg border border-gray-200 bg-white p-8 text-center text-gray-600 shadow-sm">
                        No FAQs are available right now. Please contact the clinic for assistance.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
