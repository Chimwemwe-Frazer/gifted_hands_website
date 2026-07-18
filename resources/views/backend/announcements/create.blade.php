@extends('layouts.app')

@section('title')
    {{ isset($announcement) ? 'Edit Announcement' : 'Add Announcement' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($announcement) ? 'Edit Announcement' : 'Add Announcement' }}</h1>
        <a href="{{ route('admin.announcements.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <form
            action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @isset($announcement)
                @method('PUT')
            @endisset

            @unless (isset($announcement))
                <div class="mb-5 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm text-blue-800">
                    This announcement will be published immediately using the current date and time when you save it.
                </div>
            @endunless

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="label">Category <span class="text-red-500">*</span></label>
                    <input name="category" class="input" required maxlength="80" value="{{ old('category', $announcement->category ?? '') }}" placeholder="For example: Clinic hours">
                    <span class="text-sm text-red-500">{{ $errors->first('category') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Title <span class="text-red-500">*</span></label>
                    <input name="title" class="input" required maxlength="255" value="{{ old('title', $announcement->title ?? '') }}">
                    <span class="text-sm text-red-500">{{ $errors->first('title') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Message <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="7" class="input" required placeholder="Write the announcement exactly as visitors should read it.">{{ old('message', $announcement->message ?? '') }}</textarea>
                    <p class="text-xs text-gray-500">Paragraph breaks are preserved when the announcement is displayed.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('message') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Optional image</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="input">
                    <p class="text-xs text-gray-500">JPG, PNG, or WebP up to 5 MB. Leave empty for the current text-only card style.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('image') }}</span>
                </div>

                @if (isset($announcement) && $announcement->image_path)
                    <div class="space-y-3 md:col-span-2">
                        <p class="label">Current image</p>
                        <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" class="h-48 w-full max-w-md rounded-lg border border-gray-200 object-cover">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-mustGreen focus:ring-mustGreen">
                            Remove this image and use the text-only layout
                        </label>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="service-action-button service-action-button--primary">{{ isset($announcement) ? 'Update Announcement' : 'Save Announcement' }}</button>
            </div>
        </form>
    </div>
@endsection
