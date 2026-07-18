@extends('layouts.app')

@section('title')
    Appointment Request
@endsection

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="page-heading mb-0">Appointment Request</h1>
                <span @class([
                    'appointment-status',
                    'appointment-status--pending' => $appointment->status === 'Pending',
                    'appointment-status--approved' => $appointment->status === 'Approved',
                    'appointment-status--rejected' => $appointment->status === 'Rejected',
                ])>
                    {{ $appointment->status }}
                </span>
            </div>
            <p class="mt-2 text-sm leading-6 text-gray-600">
                Received {{ $appointment->created_at->format('M d, Y \a\t H:i') }}
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            @can('update appointment')
                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="service-action-button service-action-button--secondary">Edit request details</a>
            @endcan
            <a href="{{ route('admin.appointments.index') }}" class="service-action-button service-action-button--secondary">Back to appointments</a>
        </div>
    </div>

    @if (config('mail.default') === 'log')
        <div class="mt-4 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
            <span class="font-bold">Email delivery is in log mode.</span>
            Appointment notifications are being written to the application logs. Configure SMTP before relying on real email delivery.
        </div>
    @endif

    @if ($appointment->status === 'Approved' && $appointment->appointment_at)
        <div class="mt-4 rounded-lg border border-green-200 bg-green-50 p-5">
            <p class="text-xs font-bold uppercase tracking-[.16em] text-green-700">Confirmed appointment</p>
            <p class="mt-2 text-xl font-bold leading-7 text-green-900">{{ $appointment->appointment_at->format('l, F j, Y \a\t H:i') }}</p>
            <p class="mt-1 text-sm leading-6 text-green-800">
                Practitioner: {{ $appointment->practitioner?->name ?? 'Not assigned' }}
            </p>
        </div>
    @elseif ($appointment->status === 'Rejected')
        <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-5">
            <p class="text-xs font-bold uppercase tracking-[.16em] text-red-700">Reason shared with requester</p>
            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-900">{{ $appointment->rejection_reason }}</p>
        </div>
    @else
        <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-900">
            This request is awaiting a decision. Approving it requires a confirmed date and time; rejecting it requires a reason.
        </div>
    @endif

    <div class="page-content-container mt-4">
        <h2 class="text-lg font-bold text-mustBlue">Requester and service details</h2>
        <dl class="mt-5 grid grid-cols-1 gap-x-6 gap-y-5 text-sm md:grid-cols-2 lg:grid-cols-3">
            <div>
                <dt class="font-semibold text-gray-700">Name</dt>
                <dd class="mt-1 leading-6 text-gray-600">{{ $appointment->client_name }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Phone</dt>
                <dd class="mt-1 leading-6">
                    <a href="tel:{{ $appointment->client_phone }}" class="text-mustBlue hover:text-mustGreen">{{ $appointment->client_phone }}</a>
                </dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Email</dt>
                <dd class="mt-1 break-all leading-6 text-gray-600">
                    @if ($appointment->client_email)
                        <a href="mailto:{{ $appointment->client_email }}" class="text-mustBlue hover:text-mustGreen">{{ $appointment->client_email }}</a>
                    @else
                        Not recorded
                    @endif
                </dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Service</dt>
                <dd class="mt-1 leading-6 text-gray-600">{{ $appointment->service->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Preferred date and time</dt>
                <dd class="mt-1 leading-6 text-gray-600">
                    {{ $appointment->preferred_at?->format('M d, Y \a\t H:i') ?? 'No preference provided' }}
                </dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Confirmed date and time</dt>
                <dd class="mt-1 leading-6 text-gray-600">
                    {{ $appointment->appointment_at?->format('M d, Y \a\t H:i') ?? 'Not scheduled' }}
                </dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-700">Practitioner</dt>
                <dd class="mt-1 leading-6 text-gray-600">{{ $appointment->practitioner?->name ?? 'Not assigned' }}</dd>
            </div>
            @if ($appointment->reviewedBy)
                <div>
                    <dt class="font-semibold text-gray-700">Last reviewed by</dt>
                    <dd class="mt-1 leading-6 text-gray-600">{{ $appointment->reviewedBy->name }}</dd>
                </div>
            @endif
            @if ($appointment->reviewed_at)
                <div>
                    <dt class="font-semibold text-gray-700">Last decision update</dt>
                    <dd class="mt-1 leading-6 text-gray-600">{{ $appointment->reviewed_at->format('M d, Y \a\t H:i') }}</dd>
                </div>
            @endif
            <div class="md:col-span-2 lg:col-span-3">
                <dt class="font-semibold text-gray-700">Requester message</dt>
                <dd class="mt-1 whitespace-pre-line leading-6 text-gray-600">{{ $appointment->request_message ?: 'No additional information provided.' }}</dd>
            </div>
            <div class="md:col-span-2 lg:col-span-3">
                <dt class="font-semibold text-gray-700">Internal notes</dt>
                <dd class="mt-1 whitespace-pre-line leading-6 text-gray-600">{{ $appointment->notes ?: 'No internal notes recorded.' }}</dd>
            </div>
        </dl>
    </div>

    @if ($appointment->status === 'Pending')
        @can('update appointment')
            @if (! $appointment->client_email)
                <div class="mt-4 rounded-lg border border-red-300 bg-red-50 p-5 text-sm leading-6 text-red-900" role="alert">
                    <p class="font-bold">An email address is required before this request can be decided.</p>
                    <p class="mt-1">
                        {{ $errors->first('client_email') ?: 'This is a legacy request without a requester email address.' }}
                        Use <span class="font-semibold">Edit request details</span> above to add one, then return here to approve or reject the request.
                    </p>
                </div>
            @else
                <section class="mt-4" aria-labelledby="appointment-decision-heading">
                    <div class="mb-3">
                        <h2 id="appointment-decision-heading" class="text-lg font-bold text-mustBlue">Appointment decision</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Submitting either form records a final decision and sends the corresponding email to {{ $appointment->client_email }}.</p>
                    </div>

                    @error('status')
                        <div class="mb-3 rounded-md border border-red-200 bg-red-50 p-3 text-sm leading-6 text-red-800" role="alert">{{ $message }}</div>
                    @enderror

                    <div class="grid gap-4 lg:grid-cols-2">
                    <div class="rounded-lg border border-green-200 bg-white p-5 shadow">
                        <h3 class="text-lg font-bold text-green-800">Approve this request</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Choose the clinic-confirmed date and time. The requester will receive these details by email.
                        </p>

                        <form action="{{ route('admin.appointments.decision', $appointment) }}" method="POST" class="mt-5">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Approved">

                            <div>
                                <label for="approval-appointment-at" class="label">
                                    Confirmed date and time <span class="text-red-600" aria-hidden="true">*</span>
                                </label>
                                <input
                                    id="approval-appointment-at"
                                    type="datetime-local"
                                    name="appointment_at"
                                    class="input @error('appointment_at') input-invalid @enderror"
                                    value="{{ old('appointment_at') }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}"
                                    required
                                    aria-required="true"
                                    @error('appointment_at') aria-invalid="true" aria-describedby="approval-appointment-at-error" @enderror
                                >
                                @error('appointment_at')
                                    <p id="approval-appointment-at-error" class="field-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="approval-practitioner" class="label">Practitioner <span class="font-normal text-gray-500">(optional)</span></label>
                                <select
                                    id="approval-practitioner"
                                    name="practitioner_id"
                                    class="input @error('practitioner_id') input-invalid @enderror"
                                    @error('practitioner_id') aria-invalid="true" aria-describedby="approval-practitioner-error" @enderror
                                >
                                    <option value="">Not assigned</option>
                                    @foreach ($practitioners as $practitioner)
                                        <option value="{{ $practitioner->id }}" @selected((int) old('practitioner_id') === $practitioner->id)>
                                            {{ $practitioner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('practitioner_id')
                                    <p id="approval-practitioner-error" class="field-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="service-action-button service-action-button--success mt-5 w-full sm:w-auto">
                                Approve and notify
                            </button>
                        </form>
                    </div>

                    <div class="rounded-lg border border-red-200 bg-white p-5 shadow">
                        <h3 class="text-lg font-bold text-red-800">Reject this request</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600">
                            Give a clear reason. The clinic email will present it to the requester in a polite response.
                        </p>

                        <form action="{{ route('admin.appointments.decision', $appointment) }}" method="POST" class="mt-5">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Rejected">

                            <div>
                                <label for="rejection-reason" class="label">
                                    Reason for declining <span class="text-red-600" aria-hidden="true">*</span>
                                </label>
                                <textarea
                                    id="rejection-reason"
                                    name="rejection_reason"
                                    rows="6"
                                    class="input @error('rejection_reason') input-invalid @enderror"
                                    placeholder="For example: The requested service is not available on the preferred date."
                                    required
                                    aria-required="true"
                                    @error('rejection_reason') aria-invalid="true" aria-describedby="rejection-reason-help rejection-reason-error" @else aria-describedby="rejection-reason-help" @enderror
                                >{{ old('rejection_reason') }}</textarea>
                                <p id="rejection-reason-help" class="field-help">Do not include private clinical information in this message.</p>
                                @error('rejection_reason')
                                    <p id="rejection-reason-error" class="field-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="service-action-button service-action-button--danger mt-5 w-full sm:w-auto">
                                Reject and notify
                            </button>
                        </form>
                    </div>
                    </div>
                </section>
            @endif
        @endcan
    @endif
@endsection
