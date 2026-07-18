@extends('layouts.app')

@section('title')
    {{ isset($service) ? 'Edit Service' : 'Add Service' }}
@endsection

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="page-heading">{{ isset($service) ? 'Edit Service' : 'Add Service' }}</h1>
        <a href="{{ route('admin.services.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <form
            action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @isset($service)
                @method('PUT')
            @endisset

            <div class="mb-6 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                These details are displayed on the public Services page. Active services also appear in the homepage services section and appointment form.
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="label">Service name <span class="text-red-500">*</span></label>
                    <input name="name" class="input" required maxlength="255" value="{{ old('name', $service->name ?? '') }}">
                    <span class="text-sm text-red-500">{{ $errors->first('name') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="input" required>
                        @foreach (['Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $service->status ?? 'Active') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Inactive services remain in admin but are hidden from the public website.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('status') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Service summary <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" class="input" required maxlength="2000" placeholder="A short overview shown beneath the service name.">{{ old('description', $service->description ?? '') }}</textarea>
                    <span class="text-sm text-red-500">{{ $errors->first('description') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Optional service image</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="input">
                    <p class="text-xs text-gray-500">JPG, PNG, or WebP up to 5 MB. If left empty, visitors will see “No Image Uploaded” in the same image area.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('image') }}</span>
                </div>

                @if (isset($service))
                    <div class="space-y-3 md:col-span-2">
                        <p class="label">Current image</p>
                        @if ($service->image_url)
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-48 w-full max-w-md rounded-lg border border-gray-200 object-cover">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-mustGreen focus:ring-mustGreen">
                                Remove this image
                            </label>
                        @else
                            <div class="flex h-48 w-full max-w-md items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500">
                                No Image Uploaded
                            </div>
                        @endif
                    </div>
                @endif

                <div class="space-y-2">
                    <label class="label">What is included <span class="text-red-500">*</span></label>
                    <textarea name="included_items" rows="7" class="input" required placeholder="Clinical history and examination&#10;Diagnosis and treatment plan&#10;Referral guidance">{{ old('included_items', isset($service) ? implode(PHP_EOL, $service->included_items ?? []) : '') }}</textarea>
                    <p class="text-xs text-gray-500">Enter one bullet point per line.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('included_items') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">What to bring <span class="text-red-500">*</span></label>
                    <textarea name="items_to_bring" rows="7" class="input" required placeholder="National ID or clinic card&#10;Current medicines&#10;Previous test results">{{ old('items_to_bring', isset($service) ? implode(PHP_EOL, $service->items_to_bring ?? []) : '') }}</textarea>
                    <p class="text-xs text-gray-500">Enter one bullet point per line.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('items_to_bring') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Needs treated <span class="text-red-500">*</span></label>
                    <textarea name="needs_treated" rows="5" class="input" required maxlength="5000" placeholder="Describe the symptoms, conditions, or needs this service supports.">{{ old('needs_treated', $service->needs_treated ?? '') }}</textarea>
                    <span class="text-sm text-red-500">{{ $errors->first('needs_treated') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Appointment information <span class="text-red-500">*</span></label>
                    <textarea name="appointment_details" rows="5" class="input" required maxlength="5000" placeholder="Explain whether appointments are required and how visitors can access the service.">{{ old('appointment_details', $service->appointment_details ?? '') }}</textarea>
                    <span class="text-sm text-red-500">{{ $errors->first('appointment_details') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Duration in minutes <span class="text-red-500">*</span></label>
                    <input type="number" min="1" max="1440" name="duration_minutes" class="input" required value="{{ old('duration_minutes', $service->duration_minutes ?? 30) }}">
                    <span class="text-sm text-red-500">{{ $errors->first('duration_minutes') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Fee <span class="text-red-500">*</span></label>
                    <input type="number" min="0" step="0.01" name="fee" class="input" required value="{{ old('fee', $service->fee ?? 0) }}">
                    <span class="text-sm text-red-500">{{ $errors->first('fee') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Display order <span class="text-red-500">*</span></label>
                    <input type="number" min="1" max="9999" name="display_order" class="input" required value="{{ old('display_order', $service->display_order ?? $nextDisplayOrder ?? 1) }}">
                    <p class="text-xs text-gray-500">Lower numbers appear first on the public website.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('display_order') }}</span>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="service-action-button service-action-button--primary">{{ isset($service) ? 'Update Service' : 'Save Service' }}</button>
            </div>
        </form>
    </div>
@endsection
