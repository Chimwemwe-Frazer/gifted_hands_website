@extends('layouts.app')

@section('title')
    Appointments
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Appointments</h1>
        @can('add appointment')
            <a href="{{ route('admin.appointments.create') }}" class="btn-primary">Schedule Appointment</a>
        @endcan
    </div>

    <div class="page-content-container overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Patient</th>
                    <th class="text-left px-4 py-3">Service</th>
                    <th class="text-left px-4 py-3">Practitioner</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $appointment->appointment_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $appointment->patient->full_name }}</td>
                        <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                        <td class="px-4 py-3">{{ $appointment->practitioner?->name ?? 'Unassigned' }}</td>
                        <td class="px-4 py-3">{{ $appointment->status }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                @can('update appointment')
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                @endcan
                                @can('delete appointment')
                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 delete_item">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No appointments scheduled yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
