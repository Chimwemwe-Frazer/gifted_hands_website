@extends('layouts.app')

@section('title')
    {{ isset($doctor) ? 'Edit Doctor' : 'Add Doctor' }}
@endsection

@section('content')
    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="page-heading">{{ isset($doctor) ? 'Edit Doctor' : 'Add Doctor' }}</h1>
        <a href="{{ route('admin.doctors.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <form
            action="{{ isset($doctor) ? route('admin.doctors.update', $doctor) : route('admin.doctors.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @isset($doctor)
                @method('PUT')
            @endisset

            <div class="mb-6 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                Active doctors are displayed on the public Doctors page. The first three by display order also appear on the homepage.
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="label">Doctor name <span class="text-red-500">*</span></label>
                    <input name="name" class="input" required maxlength="255" value="{{ old('name', $doctor->name ?? '') }}" placeholder="For example: Dr. Jane Banda">
                    <span class="text-sm text-red-500">{{ $errors->first('name') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Role <span class="text-red-500">*</span></label>
                    <input name="specialization" class="input" required maxlength="255" value="{{ old('specialization', $doctor->specialization ?? '') }}" placeholder="For example: Clinical Associate Obstetrics and Gynaecology">
                    <span class="text-sm text-red-500">{{ $errors->first('specialization') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Languages <span class="text-red-500">*</span></label>
                    <textarea name="languages" rows="5" class="input" required placeholder="English&#10;Chichewa">{{ old('languages', isset($doctor) ? implode(PHP_EOL, $doctor->languages ?? []) : '') }}</textarea>
                    <p class="text-xs text-gray-500">Enter one language per line.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('languages') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Optional profile image</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="input">
                    <p class="text-xs text-gray-500">JPG, PNG, or WebP up to 5 MB. Without an image, the profile displays "No Image Uploaded".</p>
                    <span class="text-sm text-red-500">{{ $errors->first('image') }}</span>
                </div>

                @if (isset($doctor))
                    <div class="space-y-3 md:col-span-2">
                        <p class="label">Current image</p>
                        @if ($doctor->image_url)
                            <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="h-56 w-full max-w-md rounded-lg border border-gray-200 object-cover object-[50%_22%]">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-mustGreen focus:ring-mustGreen">
                                Remove this image
                            </label>
                        @else
                            <div class="flex h-56 w-full max-w-md items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500">
                                No Image Uploaded
                            </div>
                        @endif
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="label">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="input" required>
                        @foreach (['Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $doctor->status ?? 'Active') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Inactive doctors remain in admin but are hidden publicly.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('status') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Display order <span class="text-red-500">*</span></label>
                    <input type="number" min="1" max="9999" name="display_order" class="input" required value="{{ old('display_order', $doctor->display_order ?? $nextDisplayOrder ?? 1) }}">
                    <p class="text-xs text-gray-500">Lower numbers appear first.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('display_order') }}</span>
                </div>
            </div>

            <div class="mt-6 flex justify-stretch sm:justify-end">
                <button type="submit" class="service-action-button service-action-button--primary w-full sm:w-auto">{{ isset($doctor) ? 'Update Doctor' : 'Save Doctor' }}</button>
            </div>
        </form>
    </div>
@endsection
