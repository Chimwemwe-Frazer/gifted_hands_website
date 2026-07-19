@extends('layouts.app')

@section('title')
    Services
@endsection

@section('content')
    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="page-heading">Services</h1>
            <p class="mt-1 text-sm text-gray-600">Manage the services displayed on the public website.</p>
        </div>
        @can('add service')
            <a href="{{ route('admin.services.create') }}" class="service-action-button service-action-button--primary self-start sm:self-auto">Add Service</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($services as $service)
            <article class="overflow-hidden rounded-lg bg-white shadow">
                @if ($service->image_url)
                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-44 w-full object-cover">
                @else
                    <div class="flex h-44 w-full items-center justify-center bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500">
                        No Image Uploaded
                    </div>
                @endif

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <a href="{{ route('admin.services.show', $service) }}" class="record-title">{{ $service->name }}</a>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $service->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $service->status }}
                        </span>
                    </div>

                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ Str::limit($service->description, 150) }}</p>

                    <div class="mt-4 grid grid-cols-2 gap-2 border-t border-gray-100 pt-4 text-sm sm:grid-cols-3">
                        <div>
                            <p class="font-semibold text-gray-700">Duration</p>
                            <p>{{ $service->duration_minutes }} min</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Fee</p>
                            <p>{{ number_format($service->fee, 2) }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Order</p>
                            <p>{{ $service->display_order }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap justify-end gap-3">
                        @can('update service')
                            <a href="{{ route('admin.services.edit', $service) }}" class="service-action-button service-action-button--secondary">Edit</a>
                        @endcan
                        @can('delete service')
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete_item service-action-button service-action-button--danger">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </article>
        @empty
            <div class="page-content-container text-center text-gray-500 md:col-span-2 lg:col-span-3">
                No services have been created yet.
            </div>
        @endforelse
    </div>
@endsection
