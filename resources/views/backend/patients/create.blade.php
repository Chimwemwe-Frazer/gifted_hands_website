@extends('layouts.app')

@section('title')
    {{ isset($patient) ? 'Edit Patient' : 'Add Patient' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($patient) ? 'Edit Patient' : 'Add Patient' }}</h1>
        <a href="{{ route('admin.patients.index') }}" class="text-mustGreen flex gap-2 items-center">Back</a>
    </div>

    <div class="page-content-container">
        <form action="{{ isset($patient) ? route('admin.patients.update', $patient) : route('admin.patients.store') }}"
            method="POST">
            @csrf
            @isset($patient)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="label">First Name <span class="text-red-500">*</span></label>
                    <input name="first_name" class="input" required value="{{ old('first_name', $patient->first_name ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('first_name') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Last Name <span class="text-red-500">*</span></label>
                    <input name="last_name" class="input" required value="{{ old('last_name', $patient->last_name ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('last_name') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Phone <span class="text-red-500">*</span></label>
                    <input name="phone" class="input" required value="{{ old('phone', $patient->phone ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('phone') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Email</label>
                    <input type="email" name="email" class="input" value="{{ old('email', $patient->email ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('email') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Gender</label>
                    <select name="gender" class="input">
                        <option value="">Select Gender</option>
                        @foreach (['Female', 'Male', 'Other'] as $gender)
                            <option value="{{ $gender }}" @selected(old('gender', $patient->gender ?? '') === $gender)>{{ $gender }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('gender') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="input"
                        value="{{ old('date_of_birth', isset($patient) && $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}">
                    <span class="text-red-500">{{ $errors->first('date_of_birth') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Emergency Contact</label>
                    <input name="emergency_contact_name" class="input"
                        value="{{ old('emergency_contact_name', $patient->emergency_contact_name ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('emergency_contact_name') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Emergency Phone</label>
                    <input name="emergency_contact_phone" class="input"
                        value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('emergency_contact_phone') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Status</label>
                    <select name="status" class="input">
                        @foreach (['Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $patient->status ?? 'Active') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('status') }}</span>
                </div>
                <div class="space-y-2 md:col-span-2 lg:col-span-3">
                    <label class="label">Address</label>
                    <textarea name="address" rows="2" class="input">{{ old('address', $patient->address ?? '') }}</textarea>
                    <span class="text-red-500">{{ $errors->first('address') }}</span>
                </div>
                <div class="space-y-2 md:col-span-2 lg:col-span-3">
                    <label class="label">Medical Notes</label>
                    <textarea name="medical_notes" rows="3" class="input">{{ old('medical_notes', $patient->medical_notes ?? '') }}</textarea>
                    <span class="text-red-500">{{ $errors->first('medical_notes') }}</span>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn-primary">{{ isset($patient) ? 'Update' : 'Add' }}</button>
            </div>
        </form>
    </div>
@endsection
