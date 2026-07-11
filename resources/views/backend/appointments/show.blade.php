@extends('layouts.app')

@section('title')
    Appointment
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Appointment Details</h1>
        <a href="{{ route('admin.appointments.index') }}" class="text-mustGreen">Back</a>
    </div>

    <div class="page-content-container">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="font-semibold text-gray-700">Date and Time</p>
                <p>{{ $appointment->appointment_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Patient</p>
                <p>{{ $appointment->patient->full_name }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Service</p>
                <p>{{ $appointment->service->name }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Practitioner</p>
                <p>{{ $appointment->practitioner?->name ?? 'Unassigned' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Status</p>
                <p>{{ $appointment->status }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Reason</p>
                <p>{{ $appointment->reason ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2 lg:col-span-3">
                <p class="font-semibold text-gray-700">Notes</p>
                <p class="mt-1 text-gray-600">{{ $appointment->notes ?? 'No notes recorded.' }}</p>
            </div>
        </div>
    </div>
@endsection
