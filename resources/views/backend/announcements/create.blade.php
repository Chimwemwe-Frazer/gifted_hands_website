@extends('layouts.app')

@section('title')
    {{ isset($announcement) ? 'Edit Announcement' : 'Add Announcement' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($announcement) ? 'Edit Announcement' : 'Add Announcement' }}</h1>
        <a href="{{ route('admin.announcements.index') }}" class="text-mustGreen">Back</a>
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

                <div class="space-y-2">
                    <label class="label">Optional image</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="input">
                    <p class="text-xs text-gray-500">JPG, PNG, or WebP up to 5 MB. Leave empty for the current text-only card style.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('image') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Image description</label>
                    <input name="image_alt" class="input" maxlength="255" value="{{ old('image_alt', $announcement->image_alt ?? '') }}" placeholder="Describe the image for visitors using screen readers">
                    <span class="text-sm text-red-500">{{ $errors->first('image_alt') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Image position</label>
                    <select name="image_position" class="input">
                        <option value="left" @selected(old('image_position', $announcement->image_position ?? 'left') === 'left')>Image on the left</option>
                        <option value="right" @selected(old('image_position', $announcement->image_position ?? 'left') === 'right')>Image on the right</option>
                    </select>
                    <p class="text-xs text-gray-500">This controls which side of the message the image uses on wider screens.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('image_position') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Status</label>
                    <select name="status" class="input">
                        @foreach (['Draft', 'Published'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $announcement->status ?? 'Draft') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <span class="text-sm text-red-500">{{ $errors->first('status') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Publish date and time</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        class="input"
                        value="{{ old('published_at', isset($announcement) && $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}"
                    >
                    <p class="text-xs text-gray-500">Leave blank to publish immediately when the status is Published, or choose a future time to schedule it.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('published_at') }}</span>
                </div>

                @if (isset($announcement) && $announcement->image_path)
                    <div class="space-y-3 md:col-span-2">
                        <p class="label">Current image</p>
                        <img src="{{ $announcement->image_url }}" alt="{{ $announcement->image_alt ?: $announcement->title }}" class="h-48 w-full max-w-md rounded-lg border border-gray-200 object-cover">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-mustGreen focus:ring-mustGreen">
                            Remove this image and use the text-only layout
                        </label>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn-primary">{{ isset($announcement) ? 'Update Announcement' : 'Save Announcement' }}</button>
            </div>
        </form>
    </div>
@endsection
