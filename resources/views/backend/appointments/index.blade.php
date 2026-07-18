@extends('layouts.app')

@section('title')
    Appointments
@endsection

@section('content')
    @php
        $filterStatuses = ['Pending', 'Approved', 'Rejected'];
        $currentStatus = in_array($activeStatus, $filterStatuses, true) ? $activeStatus : null;
        $statusCount = static fn (string $status): int => (int) data_get(
            $statusCounts,
            $status,
            data_get($statusCounts, strtolower($status), 0)
        );
        $allCount = (int) data_get(
            $statusCounts,
            'All',
            data_get($statusCounts, 'all', collect($filterStatuses)->sum($statusCount))
        );
    @endphp

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="page-heading mb-1">Appointments</h1>
            <p class="text-sm leading-6 text-gray-600">Review new requests and track every appointment decision.</p>
        </div>
        @can('add appointment')
            <a href="{{ route('admin.appointments.create') }}" class="service-action-button service-action-button--primary self-start sm:self-auto">Add Request</a>
        @endcan
    </div>

    @if (config('mail.default') === 'log')
        <div class="mt-4 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
            <span class="font-bold">Email delivery is in log mode.</span>
            Appointment notifications are being written to the application logs. Configure SMTP before relying on real email delivery.
        </div>
    @endif

    <nav class="mt-5 flex gap-2 overflow-x-auto pb-1" aria-label="Filter appointments by status">
        <a
            href="{{ route('admin.appointments.index') }}"
            @class(['appointment-filter-tab', 'appointment-filter-tab--active' => $currentStatus === null])
            @if ($currentStatus === null) aria-current="page" @endif
        >
            All <span class="appointment-filter-count">{{ $allCount }}</span>
        </a>
        @foreach ($filterStatuses as $filterStatus)
            <a
                href="{{ route('admin.appointments.index', ['status' => $filterStatus]) }}"
                @class(['appointment-filter-tab', 'appointment-filter-tab--active' => $currentStatus === $filterStatus])
                @if ($currentStatus === $filterStatus) aria-current="page" @endif
            >
                {{ $filterStatus }}
                <span class="appointment-filter-count">{{ $statusCount($filterStatus) }}</span>
            </a>
        @endforeach
    </nav>

    <div class="page-content-container mt-3">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left">Received</th>
                        <th class="px-4 py-3 text-left">Requester</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left">Preferred</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left">Scheduled for</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr @class([
                            'border-b align-top transition hover:bg-gray-50',
                            'bg-amber-50/50' => $appointment->status === 'Pending',
                        ])>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="block font-semibold text-gray-800">{{ $appointment->created_at->format('M d, Y') }}</span>
                                <span class="mt-1 block text-xs text-gray-500">{{ $appointment->created_at->format('H:i') }}</span>
                            </td>
                            <td class="min-w-52 px-4 py-3">
                                <span class="block font-semibold text-gray-800">{{ $appointment->client_name }}</span>
                                @if ($appointment->client_email)
                                    <a href="mailto:{{ $appointment->client_email }}" class="mt-1 block break-all text-xs leading-5 text-mustBlue hover:text-mustGreen">
                                        {{ $appointment->client_email }}
                                    </a>
                                @else
                                    <span class="mt-1 block text-xs leading-5 text-red-600">Email not recorded</span>
                                @endif
                                <a href="tel:{{ $appointment->client_phone }}" class="block text-xs leading-5 text-gray-500 hover:text-mustGreen">
                                    {{ $appointment->client_phone }}
                                </a>
                            </td>
                            <td class="min-w-40 px-4 py-3 leading-6">{{ $appointment->service->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($appointment->preferred_at)
                                    <span class="block">{{ $appointment->preferred_at->format('M d, Y') }}</span>
                                    <span class="mt-1 block text-xs text-gray-500">{{ $appointment->preferred_at->format('H:i') }}</span>
                                @else
                                    <span class="text-gray-500">No preference</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($appointment->appointment_at)
                                    <span class="block font-semibold text-gray-800">{{ $appointment->appointment_at->format('M d, Y') }}</span>
                                    <span class="mt-1 block text-xs text-gray-500">{{ $appointment->appointment_at->format('H:i') }}</span>
                                @else
                                    <span class="text-gray-500">Not scheduled</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'appointment-status',
                                    'appointment-status--pending' => $appointment->status === 'Pending',
                                    'appointment-status--approved' => $appointment->status === 'Approved',
                                    'appointment-status--rejected' => $appointment->status === 'Rejected',
                                ])>
                                    {{ $appointment->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="service-action-button service-action-button--secondary whitespace-nowrap">
                                    @can('update appointment')
                                        {{ $appointment->status === 'Pending' ? 'Review' : 'View' }}
                                    @else
                                        View
                                    @endcan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                {{ $currentStatus ? "No {$currentStatus} appointment requests." : 'No appointment requests yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($appointments->hasPages())
            <div class="mt-5 border-t border-gray-100 pt-5">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
