@extends('layouts.app')

@section('title')
    Appointments
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Appointments</h1>
        @can('add appointment')
            <a href="{{ route('admin.appointments.create') }}" class="btn-primary">Add Request</a>
        @endcan
    </div>

    <div class="page-content-container overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="text-left px-4 py-3">Requested Date</th>
                    <th class="text-left px-4 py-3">Name</th>
                    <th class="text-left px-4 py-3">Phone</th>
                    <th class="text-left px-4 py-3">Service</th>
                    <th class="text-left px-4 py-3">Practitioner</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $appointment->appointment_at?->format('M d, Y H:i') ?? 'Flexible' }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $appointment->client_name }}</td>
                        <td class="px-4 py-3">{{ $appointment->client_phone }}</td>
                        <td class="px-4 py-3">{{ $appointment->service->name }}</td>
                        <td class="px-4 py-3">{{ $appointment->practitioner?->name ?? 'Unassigned' }}</td>
                        <td class="px-4 py-3">{{ $appointment->status }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-mustBlue hover:text-mustBlue">View</a>
                                @can('update appointment')
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-mustBlue hover:text-mustBlue">Edit</a>
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
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No appointment requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
