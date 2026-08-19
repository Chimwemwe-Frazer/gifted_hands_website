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

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between md:mb-0">
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

    <nav class="mt-5 flex flex-wrap gap-2 pb-1" aria-label="Filter appointments by status">
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
        @if ($appointments->isEmpty())
            <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-10 text-center text-gray-500">
                {{ $currentStatus ? "No {$currentStatus} appointment requests." : 'No appointment requests yet.' }}
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:hidden">
                @foreach ($appointments as $appointment)
                    <article
                        data-mobile-appointment-card
                        @class([
                            'rounded-lg border p-4 shadow-sm',
                            'border-amber-200 bg-amber-50/60' => $appointment->status === 'Pending',
                            'border-gray-200 bg-white' => $appointment->status !== 'Pending',
                        ])
                    >
                        <div class="flex items-start justify-between gap-3 border-b border-gray-200 pb-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Received</p>
                                <p class="mt-1 font-semibold text-gray-800">{{ $appointment->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $appointment->created_at->format('H:i') }}</p>
                            </div>
                            <span @class([
                                'appointment-status',
                                'appointment-status--pending' => $appointment->status === 'Pending',
                                'appointment-status--approved' => $appointment->status === 'Approved',
                                'appointment-status--rejected' => $appointment->status === 'Rejected',
                            ])>
                                {{ $appointment->status }}
                            </span>
                        </div>

                        <div class="py-4">
                            <h2 class="break-words text-lg font-bold text-mustBlue">{{ $appointment->client_name }}</h2>
                            @if ($appointment->client_email)
                                <a href="mailto:{{ $appointment->client_email }}" class="mt-1 block break-all text-sm leading-6 text-mustBlue hover:text-mustGreen">
                                    {{ $appointment->client_email }}
                                </a>
                            @else
                                <p class="mt-1 text-sm leading-6 text-red-600">Email not recorded</p>
                            @endif
                        </div>

                        <dl class="grid grid-cols-2 gap-4 border-t border-gray-200 pt-4 text-sm">
                            <div class="col-span-2">
                                <dt class="font-semibold text-gray-500">Service</dt>
                                <dd class="mt-1 break-words text-gray-800">{{ $appointment->service->name }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500">Preferred</dt>
                                <dd class="mt-1 text-gray-800">
                                    @if ($appointment->preferred_at)
                                        {{ $appointment->preferred_at->format('M d, Y') }}
                                        <span class="block text-xs text-gray-500">{{ $appointment->preferred_at->format('H:i') }}</span>
                                    @else
                                        <span class="text-gray-500">No preference</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500">Scheduled for</dt>
                                <dd class="mt-1 text-gray-800">
                                    @if ($appointment->appointment_at)
                                        {{ $appointment->appointment_at->format('M d, Y') }}
                                        <span class="block text-xs text-gray-500">{{ $appointment->appointment_at->format('H:i') }}</span>
                                    @else
                                        <span class="text-gray-500">Not scheduled</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-4 flex gap-2">
                            <a
                                href="{{ route('admin.appointments.show', $appointment) }}"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-mustBlue/20 bg-white text-mustBlue transition hover:bg-mustBlue hover:text-white"
                                aria-label="{{ $appointment->status === 'Pending' ? 'Review appointment' : 'View appointment' }}"
                                title="{{ $appointment->status === 'Pending' ? 'Review' : 'View' }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                            @role(\App\Models\User::ROLE_ADMINISTRATOR)
                                @if ($appointment->status !== 'Pending')
                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="delete_item inline-flex h-10 w-10 items-center justify-center rounded-md border border-red-200 bg-white text-red-700 transition hover:bg-red-600 hover:text-white"
                                            aria-label="Delete appointment"
                                            title="Delete"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.68.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.342-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49.06 49.06 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endrole
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="hidden xl:block">
                <table class="w-full table-fixed text-sm">
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
                    @foreach ($appointments as $appointment)
                        <tr @class([
                            'border-b align-top transition hover:bg-gray-50',
                            'bg-amber-50/50' => $appointment->status === 'Pending',
                        ])>
                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="block font-semibold text-gray-800">{{ $appointment->created_at->format('M d, Y') }}</span>
                                <span class="mt-1 block text-xs text-gray-500">{{ $appointment->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="block font-semibold text-gray-800">{{ $appointment->client_name }}</span>
                                @if ($appointment->client_email)
                                    <a href="mailto:{{ $appointment->client_email }}" class="mt-1 block break-all text-xs leading-5 text-mustBlue hover:text-mustGreen">
                                        {{ $appointment->client_email }}
                                    </a>
                                @else
                                    <span class="mt-1 block text-xs leading-5 text-red-600">Email not recorded</span>
                                @endif
                            </td>
                            <td class="break-words px-4 py-3 leading-6">{{ $appointment->service->name }}</td>
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
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.appointments.show', $appointment) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-mustBlue/20 bg-white text-mustBlue transition hover:bg-mustBlue hover:text-white"
                                        aria-label="{{ $appointment->status === 'Pending' ? 'Review appointment' : 'View appointment' }}"
                                        title="{{ $appointment->status === 'Pending' ? 'Review' : 'View' }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    @role(\App\Models\User::ROLE_ADMINISTRATOR)
                                        @if ($appointment->status !== 'Pending')
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="delete_item inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 bg-white text-red-700 transition hover:bg-red-600 hover:text-white"
                                                    aria-label="Delete appointment"
                                                    title="Delete"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.68.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.342-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49.06 49.06 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        @endif

        @if ($appointments->hasPages())
            <div class="mt-5 border-t border-gray-100 pt-5">
                {{ $appointments->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
