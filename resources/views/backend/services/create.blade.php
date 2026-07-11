@extends('layouts.app')

@section('title')
    {{ isset($service) ? 'Edit Service' : 'Add Service' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($service) ? 'Edit Service' : 'Add Service' }}</h1>
        <a href="{{ route('admin.services.index') }}" class="text-mustGreen">Back</a>
    </div>

    <div class="page-content-container">
        <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}"
            method="POST">
            @csrf
            @isset($service)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="label">Name <span class="text-red-500">*</span></label>
                    <input name="name" class="input" required value="{{ old('name', $service->name ?? '') }}">
                    <span class="text-red-500">{{ $errors->first('name') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Duration Minutes <span class="text-red-500">*</span></label>
                    <input type="number" min="1" name="duration_minutes" class="input" required
                        value="{{ old('duration_minutes', $service->duration_minutes ?? 30) }}">
                    <span class="text-red-500">{{ $errors->first('duration_minutes') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Fee <span class="text-red-500">*</span></label>
                    <input type="number" min="0" step="0.01" name="fee" class="input" required
                        value="{{ old('fee', $service->fee ?? 0) }}">
                    <span class="text-red-500">{{ $errors->first('fee') }}</span>
                </div>
                <div class="space-y-2">
                    <label class="label">Status</label>
                    <select name="status" class="input">
                        @foreach (['Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $service->status ?? 'Active') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500">{{ $errors->first('status') }}</span>
                </div>
                <div class="space-y-2 md:col-span-3">
                    <label class="label">Description</label>
                    <textarea name="description" rows="4" class="input">{{ old('description', $service->description ?? '') }}</textarea>
                    <span class="text-red-500">{{ $errors->first('description') }}</span>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn-primary">{{ isset($service) ? 'Update' : 'Add' }}</button>
            </div>
        </form>
    </div>
@endsection
