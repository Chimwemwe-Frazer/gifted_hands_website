@extends('layouts.app')

@section('title')
    {{ isset($appointment) ? 'Edit Appointment Request' : 'Add Appointment Request' }}
@endsection

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="page-heading mb-1">{{ isset($appointment) ? 'Edit Appointment Request' : 'Add Appointment Request' }}</h1>
            <p class="text-sm leading-6 text-gray-600">
                {{ isset($appointment) ? 'Update the information supplied with this request.' : 'Record a request received by phone, email, or in person.' }}
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            @isset($appointment)
                <a href="{{ route('admin.appointments.show', $appointment) }}" class="service-action-button service-action-button--secondary">View and decide</a>
            @endisset
            <a href="{{ route('admin.appointments.index') }}" class="service-action-button service-action-button--secondary">Back</a>
        </div>
    </div>

    @isset($appointment)
        <div class="mt-4 flex flex-wrap items-center gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <span class="text-sm font-semibold text-gray-700">Current status</span>
            <span @class([
                'appointment-status',
                'appointment-status--pending' => $appointment->status === 'Pending',
                'appointment-status--approved' => $appointment->status === 'Approved',
                'appointment-status--rejected' => $appointment->status === 'Rejected',
            ])>
                {{ $appointment->status }}
            </span>
            <p class="w-full text-sm leading-6 text-gray-600 sm:w-auto">
                Status, confirmed scheduling, and rejection details are managed from the appointment review page.
            </p>
        </div>
    @endisset

    <div class="page-content-container mt-4">
        <form action="{{ isset($appointment) ? route('admin.appointments.update', $appointment) : route('admin.appointments.store') }}"
            method="POST">
            @csrf
            @isset($appointment)
                @method('PUT')
            @endisset

            <div class="mb-5">
                <h2 class="text-lg font-bold text-mustBlue">Requester details</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    Fields marked <span class="font-semibold text-red-600">*</span> are required. The email address is used for all appointment notifications.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="client-name" class="label">
                        Full name <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input
                        id="client-name"
                        type="text"
                        name="client_name"
                        class="input @error('client_name') input-invalid @enderror"
                        required
                        aria-required="true"
                        autocomplete="name"
                        value="{{ old('client_name', $appointment->client_name ?? '') }}"
                        @error('client_name') aria-invalid="true" aria-describedby="client-name-error" @enderror
                    >
                    @error('client_name')
                        <p id="client-name-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client-phone" class="label">
                        Phone number <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input
                        id="client-phone"
                        type="tel"
                        name="client_phone"
                        class="input @error('client_phone') input-invalid @enderror"
                        required
                        aria-required="true"
                        autocomplete="tel"
                        inputmode="tel"
                        value="{{ old('client_phone', $appointment->client_phone ?? '') }}"
                        @error('client_phone') aria-invalid="true" aria-describedby="client-phone-error" @enderror
                    >
                    @error('client_phone')
                        <p id="client-phone-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client-email" class="label">
                        Email address <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input
                        id="client-email"
                        type="email"
                        name="client_email"
                        class="input @error('client_email') input-invalid @enderror"
                        required
                        aria-required="true"
                        autocomplete="email"
                        value="{{ old('client_email', $appointment->client_email ?? '') }}"
                        @error('client_email') aria-invalid="true" aria-describedby="client-email-error" @enderror
                    >
                    @error('client_email')
                        <p id="client-email-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="service-id" class="label">
                        Service <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <select
                        id="service-id"
                        name="service_id"
                        class="input @error('service_id') input-invalid @enderror"
                        required
                        aria-required="true"
                        @error('service_id') aria-invalid="true" aria-describedby="service-id-error" @enderror
                    >
                        <option value="">Select Service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected((int) old('service_id', $appointment->service_id ?? 0) === $service->id)>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p id="service-id-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="preferred-at" class="label">Preferred date and time <span class="font-normal text-gray-500">(optional)</span></label>
                    <input
                        id="preferred-at"
                        type="datetime-local"
                        name="preferred_at"
                        class="input @error('preferred_at') input-invalid @enderror"
                        value="{{ old('preferred_at', isset($appointment) && $appointment->preferred_at ? $appointment->preferred_at->format('Y-m-d\TH:i') : '') }}"
                        aria-describedby="preferred-at-help @error('preferred_at') preferred-at-error @enderror"
                        @error('preferred_at') aria-invalid="true" @enderror
                    >
                    <p id="preferred-at-help" class="field-help">This is the requester’s preference, not the clinic-confirmed appointment time.</p>
                    @error('preferred_at')
                        <p id="preferred-at-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="request-message" class="label">Requester message <span class="font-normal text-gray-500">(optional)</span></label>
                    <textarea
                        id="request-message"
                        name="request_message"
                        rows="4"
                        class="input @error('request_message') input-invalid @enderror"
                        placeholder="Information supplied by the requester."
                        @error('request_message') aria-invalid="true" aria-describedby="request-message-error" @enderror
                    >{{ old('request_message', $appointment->request_message ?? '') }}</textarea>
                    @error('request_message')
                        <p id="request-message-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="notes" class="label">Internal notes <span class="font-normal text-gray-500">(optional)</span></label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        class="input @error('notes') input-invalid @enderror"
                        placeholder="Staff-only coordination notes. These are not included in requester emails."
                        aria-describedby="notes-help @error('notes') notes-error @enderror"
                        @error('notes') aria-invalid="true" @enderror
                    >{{ old('notes', $appointment->notes ?? '') }}</textarea>
                    <p id="notes-help" class="field-help">Visible only to clinic staff.</p>
                    @error('notes')
                        <p id="notes-error" class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5 flex justify-stretch sm:justify-end">
                <button type="submit" class="service-action-button service-action-button--primary w-full sm:w-auto">
                    {{ isset($appointment) ? 'Update request details' : 'Save pending request' }}
                </button>
            </div>
        </form>
    </div>
@endsection
