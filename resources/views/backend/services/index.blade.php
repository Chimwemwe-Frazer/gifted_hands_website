@extends('layouts.app')

@section('title')
    Services
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Services</h1>
        @can('add service')
            <a href="{{ route('admin.services.create') }}" class="btn-primary">Add Service</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($services as $service)
            <div class="bg-white rounded-lg shadow p-4">
                <a href="{{ route('admin.services.show', $service) }}" class="record-title">{{ $service->name }}</a>
                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($service->description ?? 'No description provided.', 120) }}</p>
                <div class="grid grid-cols-3 gap-2 mt-4 text-sm">
                    <div>
                        <p class="font-semibold text-gray-700">Duration</p>
                        <p>{{ $service->duration_minutes }} min</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Fee</p>
                        <p>{{ number_format($service->fee, 2) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700">Status</p>
                        <p>{{ $service->status }}</p>
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-4">
                    @can('update service')
                        <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                    @endcan
                    @can('delete service')
                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 delete_item">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="page-content-container md:col-span-2 lg:col-span-3 text-center text-gray-500">
                No services configured yet.
            </div>
        @endforelse
    </div>
@endsection
