<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clinic Schedule | {{ config('app.name', 'Gifted Hands Private Clinic') }}</title>
    <link rel="icon" href="{{ asset('imgs/logo/gifted-hands-logo-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">
    <header class="relative overflow-visible bg-mustBlue bg-cover bg-center text-white md:overflow-hidden" style="background-image: url('{{ asset('imgs/schedule-calender.jpg') }}');">
        <div class="absolute inset-y-0 left-0 w-full bg-mustBlue/90 md:w-[calc(32%_+_5px)] md:[clip-path:polygon(0_0,86%_0,100%_100%,0_100%)] lg:w-[28%]" aria-hidden="true"></div>
        @include('public.partials.nav')

        <div class="relative z-10 mx-auto flex h-56 max-w-7xl flex-col justify-center px-4 md:h-64 lg:h-56">
            <p class="text-sm font-semibold uppercase tracking-[.2em] text-mustGreen">Effective 1 May 2026</p>
            <h1 class="mt-3 text-4xl font-medium leading-tight md:text-5xl">Clinic Schedule</h1>
            <p class="mt-4 max-w-md text-gray-200">Plan your visit using the updated clinic timetable, service availability, and booking notes.</p>
        </div>
    </header>

    <main class="bg-[#EFEFEF]">
        <div class="mx-auto max-w-7xl px-4 py-16">
            <div class="mb-8 rounded-lg border border-mustBlue/15 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[.18em] text-mustGreen">Notice</p>
                <h2 class="mt-2 text-2xl font-bold text-mustBlue md:text-3xl">Our valued clients, clinics will be as follows</h2>
                <p class="mt-3 max-w-3xl text-sm leading-7 text-gray-600">
                    The timetable below reflects the clinic schedule displayed in the latest Gifted Hands Private Clinic notice.
                    Appointment requests are recommended so the clinic team can confirm provider availability before your visit.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1fr_0.42fr]">
                <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm md:p-6">
                    <h2 class="text-2xl font-bold text-mustBlue">Weekly Clinic Timetable</h2>

                    <div class="mt-6 space-y-4">
                        @foreach ([
                            [
                                'day' => 'Monday, Tuesday, Friday',
                                'clinics' => [
                                    ['name' => 'Obs and Gynae clinic', 'times' => ['07:30 - 13:30', '16:30 - 19:00']],
                                ],
                            ],
                            [
                                'day' => 'Wednesday',
                                'clinics' => [
                                    ['name' => 'General Clinic', 'times' => ['07:30 - 16:30']],
                                ],
                            ],
                            [
                                'day' => 'Thursday',
                                'clinics' => [
                                    ['name' => 'Under 5 Clinic', 'times' => ['07:30 - 13:30']],
                                    ['name' => 'Gynae clinic', 'times' => ['16:30 - 19:00']],
                                ],
                            ],
                            [
                                'day' => 'Friday',
                                'clinics' => [
                                    ['name' => 'Diet and Nutrition Clinic', 'times' => ['13:30 - 16:00']],
                                ],
                            ],
                            [
                                'day' => 'Saturday',
                                'clinics' => [
                                    ['name' => 'Obs and Gynae clinic', 'times' => ['07:30 - 13:30']],
                                ],
                            ],
                            [
                                'day' => 'Sunday',
                                'clinics' => [
                                    ['name' => 'Emergency and Special bookings', 'times' => []],
                                ],
                            ],
                        ] as $schedule)
                            <article class="rounded-lg border border-mustBlue/25 bg-white p-4">
                                <h3 class="text-xl font-bold text-mustBlue">{{ $schedule['day'] }}</h3>

                                <div class="mt-3 space-y-3">
                                    @foreach ($schedule['clinics'] as $clinic)
                                        <div class="grid gap-2 md:grid-cols-[1fr_auto] md:items-start">
                                            <p class="text-lg font-semibold text-mustGreen">{{ $clinic['name'] }}</p>

                                            @if (count($clinic['times']) > 0)
                                                <div class="grid gap-1 text-left md:min-w-48 md:text-right">
                                                    @foreach ($clinic['times'] as $time)
                                                        <span class="font-bold text-mustGreen">{{ $time }} hrs</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-6 rounded-lg bg-mustGreen/10 px-5 py-4 text-center">
                        <p class="text-xl font-medium uppercase tracking-wide text-mustGreen">Physiotherapy on booking</p>
                    </div>

                    <div class="mt-4 rounded-lg bg-mustBlue px-5 py-4 text-center text-white">
                        <p class="text-lg font-bold">Note: Female Gynae consultations every alternate weekends</p>
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="rounded-lg bg-mustBlue p-6 text-white shadow-sm">
                        <h2 class="text-2xl font-bold">Book or Confirm</h2>
                        <div class="mt-5 space-y-4 text-sm leading-7 text-gray-200">
                            <p>Use the appointment form or contact the clinic directly before visiting for time-sensitive services.</p>
                            <p><strong class="text-white">Sunday:</strong> Emergency and special bookings only.</p>
                            <p><strong class="text-white">Physiotherapy:</strong> Available on booking.</p>
                        </div>
                        <a href="{{ route('home') }}#book-appointment" class="mt-6 inline-flex rounded-full bg-mustGreen px-5 py-3 font-semibold text-white hover:bg-mustOrangeDark">
                            Request Appointment
                        </a>
                    </section>

                    <section class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-bold text-mustBlue">Notice Contacts</h2>
                        <div class="mt-4 space-y-3 text-sm leading-6 text-gray-600">
                            <p>
                                <span class="block font-semibold text-mustBlue">Phone</span>
                                <a href="tel:+265886498222" class="hover:text-mustGreen">+265 (0) 886 498 222</a>
                            </p>
                            <p>
                                <span class="block font-semibold text-mustBlue">Phone</span>
                                <a href="tel:+265888467878" class="hover:text-mustGreen">+265 (0) 888 467 878</a>
                            </p>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </main>
    @include('public.partials.footer')
</body>

</html>
