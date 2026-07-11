@extends('layouts.app')

@section('title')
    {{ $service->name }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ $service->name }}</h1>
        <a href="{{ route('admin.services.index') }}" class="text-mustGreen">Back</a>
    </div>

    <div class="page-content-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="font-semibold text-gray-700">Duration</p>
                <p>{{ $service->duration_minutes }} minutes</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Fee</p>
                <p>{{ number_format($service->fee, 2) }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Status</p>
                <p>{{ $service->status }}</p>
            </div>
            <div class="md:col-span-3">
                <p class="font-semibold text-gray-700">Description</p>
                <p class="mt-1 text-gray-600">{{ $service->description ?? 'No description provided.' }}</p>
            </div>
        </div>
    </div>
@endsection
