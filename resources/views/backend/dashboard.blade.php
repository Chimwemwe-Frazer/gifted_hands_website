@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-4">
        <!-- Card 1 -->
        <div class="bg-white shadow rounded-lg hover:shadow-lg transition-transform duration-300 hover:scale-105">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">4</div>
                    <span class="text-gray-600 text-lg">All Courses</span>
                </div>
                <div class="bg-mustGreen opacity-70 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow rounded-lg hover:shadow-lg transition-transform duration-300 hover:scale-105">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">8</div>
                    <span class="text-gray-600 text-lg">Enrolled Students</span>
                </div>
                <div class="bg-mustGreen opacity-70 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow rounded-lg hover:shadow-lg transition-transform duration-300 hover:scale-105">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">7</div>
                    <span class="text-gray-600 text-lg">Testimonials</span>
                </div>
                <div class="bg-mustGreen opacity-70 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                </svg>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white shadow rounded-lg hover:shadow-lg transition-transform duration-300 hover:scale-105">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">3</div>
                    <span class="text-gray-600 text-lg">Staff</span>
                </div>
                <div class="bg-mustGreen opacity-70 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                      </svg>
                </div>
            </div>
        </div>
    </div>
@endsection
