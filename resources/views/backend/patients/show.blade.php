@extends('layouts.app')

@section('title')
    {{ $patient->full_name }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ $patient->full_name }}</h1>
        <a href="{{ route('admin.patients.index') }}" class="text-mustGreen">Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="page-content-container lg:col-span-1">
            <dl class="space-y-3 text-sm">
                <div><dt class="font-semibold text-gray-700">Patient No.</dt><dd>{{ $patient->patient_number }}</dd></div>
                <div><dt class="font-semibold text-gray-700">Phone</dt><dd>{{ $patient->phone }}</dd></div>
                <div><dt class="font-semibold text-gray-700">Email</dt><dd>{{ $patient->email ?? 'N/A' }}</dd></div>
                <div><dt class="font-semibold text-gray-700">Gender</dt><dd>{{ $patient->gender ?? 'N/A' }}</dd></div>
                <div><dt class="font-semibold text-gray-700">Date of Birth</dt><dd>{{ $patient->date_of_birth?->format('M d, Y') ?? 'N/A' }}</dd></div>
                <div><dt class="font-semibold text-gray-700">Status</dt><dd>{{ $patient->status }}</dd></div>
            </dl>
        </div>
        <div class="page-content-container lg:col-span-2">
            <h2 class="page-heading">Appointment History</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="text-left px-4 py-3">Date</th>
                            <th class="text-left px-4 py-3">Service</th>
                            <th class="text-left px-4 py-3">Practitioner</th>
                            <th class="text-left px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patient->appointments as $appointment)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $appointment->appointment_at->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                                <td class="px-4 py-3">{{ $appointment->practitioner?->name ?? 'Unassigned' }}</td>
                                <td class="px-4 py-3">{{ $appointment->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
