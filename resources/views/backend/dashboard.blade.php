@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-4">
        <div class="bg-white shadow rounded-lg">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">{{ $patientsCount }}</div>
                    <span class="text-gray-600 text-lg">Patients</span>
                </div>
                <div class="bg-mustGreen opacity-80 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772A5.971 5.971 0 0 0 6 18.719M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">{{ $appointmentsTodayCount }}</div>
                    <span class="text-gray-600 text-lg">Today's Visits</span>
                </div>
                <div class="bg-mustGreen opacity-80 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25a1.5 1.5 0 0 1 1.5-1.5Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">{{ $servicesCount }}</div>
                    <span class="text-gray-600 text-lg">Active Services</span>
                </div>
                <div class="bg-mustGreen opacity-80 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="flex items-center justify-between p-4 md:p-6">
                <div class="space-y-1">
                    <div class="text-4xl md:text-5xl font-bold text-mustBlue">{{ $staffCount }}</div>
                    <span class="text-gray-600 text-lg">Staff Users</span>
                </div>
                <div class="bg-mustGreen opacity-80 rounded-full p-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-container mt-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="page-heading mb-0">Upcoming Appointments</h2>
            @can('add appointment')
                <a href="{{ route('admin.appointments.create') }}" class="btn-primary">Schedule</a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="text-left px-4 py-3">Time</th>
                        <th class="text-left px-4 py-3">Patient</th>
                        <th class="text-left px-4 py-3">Service</th>
                        <th class="text-left px-4 py-3">Practitioner</th>
                        <th class="text-left px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcomingAppointments as $appointment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $appointment->appointment_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $appointment->patient->full_name }}</td>
                            <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                            <td class="px-4 py-3">{{ $appointment->practitioner?->name ?? 'Unassigned' }}</td>
                            <td class="px-4 py-3">{{ $appointment->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No upcoming appointments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
