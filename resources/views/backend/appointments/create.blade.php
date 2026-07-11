@extends('layouts.app')

@section('title')
    {{ isset($appointment) ? 'Edit Appointment' : 'Schedule Appointment' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($appointment) ? 'Edit Appointment' : 'Schedule Appointment' }}</h1>
        <a href="{{ route('admin.appointments.index') }}" class="text-mustGreen">Back</a>
    </div>

    <div class="page-content-container">
        <form action="{{ isset($appointment) ? route('admin.appointments.update', $appointment) : route('admin.appointments.store') }}"
            method="POST">
            @csrf
            @isset($appointment)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="label">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" class="input" required>
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" @selected((int) old('patient_id', $appointment->patient_id ?? 0) === $patient->id)>
                                {{ $patient->patient_number }} - {{ $patient->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('patient_id') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Service <span class="text-red-500">*</span></label>
                    <select name="service_id" class="input" required>
                        <option value="">Select Service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected((int) old('service_id', $appointment->service_id ?? 0) === $service->id)>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('service_id') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Practitioner</label>
                    <select name="practitioner_id" class="input">
                        <option value="">Unassigned</option>
                        @foreach ($practitioners as $practitioner)
                            <option value="{{ $practitioner->id }}" @selected((int) old('practitioner_id', $appointment->practitioner_id ?? 0) === $practitioner->id)>
                                {{ $practitioner->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('practitioner_id') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Date and Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="appointment_at" class="input" required
                        value="{{ old('appointment_at', isset($appointment) ? $appointment->appointment_at->format('Y-m-d\TH:i') : '') }}">
                    <span class="text-red-500">{{ $errors->first('appointment_at') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Status</label>
                    <select name="status" class="input">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $appointment->status ?? 'Scheduled') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('status') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Reason</label>
                    <input name="reason" class="input" value="{{ old('reason', $appointment->reason ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('reason') }}</span>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="label">Notes</label>
                    <textarea name="notes" rows="4" class="input">{{ old('notes', $appointment->notes ?? '') }}</textarea>
                    <span class="text-red-500">{{ $errors->first('notes') }}</span>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn-primary">{{ isset($appointment) ? 'Update' : 'Schedule' }}</button>
            </div>
        </form>
    </div>
@endsection
