<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Announcements | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover text-white md:overflow-hidden" style="background-image: url('{{ asset('imgs/image.png') }}'); background-position: center 38%;">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Clinic updates</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Announcements</h1>
            <p class="mt-4 max-w-md text-gray-200">Stay informed about clinic schedules, service availability, and important visitor notices.</p>
        </div>
    </header>

    <main class="mx-auto grid max-w-7xl gap-8 px-4 py-16 lg:grid-cols-[1.2fr_0.8fr]">
        <section>
            <h2 class="section-heading">All Announcements</h2>
            <div class="mt-8 space-y-5">
                @forelse ($announcements as $announcement)
                    @if ($announcement->image_path)
                        <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                            <div class="grid md:grid-cols-[minmax(220px,.8fr)_minmax(0,1.2fr)]">
                                <div class="{{ $announcement->image_position === 'right' ? 'md:order-2' : '' }}">
                                    <img
                                        src="{{ $announcement->image_url }}"
                                        alt="{{ $announcement->image_alt ?: $announcement->title }}"
                                        class="h-64 w-full object-cover md:h-full md:min-h-72"
                                    >
                                </div>
                                <div class="flex flex-col justify-center p-5 sm:p-6">
                                    <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                                    <h3 class="mt-3 text-xl font-bold text-mustBlue">{{ $announcement->title }}</h3>
                                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $announcement->message }}</p>
                                </div>
                            </div>
                        </article>
                    @else
                        <article class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                            <h3 class="mt-3 text-xl font-bold text-mustBlue">{{ $announcement->title }}</h3>
                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $announcement->message }}</p>
                        </article>
                    @endif
                @empty
                    <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-gray-500 shadow-sm">
                        No announcements are available right now.
                    </div>
                @endforelse
            </div>

            @if ($announcements->hasPages())
                <div class="mt-8">{{ $announcements->links() }}</div>
            @endif
        </section>

        <aside class="h-fit rounded-lg bg-mustBlue p-6 text-white">
            <h2 class="text-2xl font-bold">Subscribe For Updates</h2>
            <p class="mt-3 text-sm leading-7 text-gray-200">Receive Gifted Hands announcements, service updates, and clinic notices by email.</p>

            @if (session('subscription_success'))
                <div class="mt-5 rounded-md bg-green-50 p-3 text-sm text-green-800">{{ session('subscription_success') }}</div>
            @endif

            <form action="{{ route('announcements.subscribe') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-100">Email address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="mt-2 block w-full rounded-md border-white/20 bg-white px-3 py-2 text-gray-800 shadow-sm focus:border-mustGreen focus:ring-mustGreen">
                    <span class="mt-1 block text-sm text-red-200">{{ $errors->first('email') }}</span>
                </div>
                <button type="submit" class="rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">Subscribe</button>
            </form>
        </aside>
    </main>
    @include('public.partials.footer')
</body>

</html>
