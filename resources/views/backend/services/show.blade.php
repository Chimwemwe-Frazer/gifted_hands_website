@extends('layouts.app')

@section('title')
    {{ $service->name }}
@endsection

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="page-heading">{{ $service->name }}</h1>
        <div class="flex items-center gap-4">
            @can('update service')
                <a href="{{ route('admin.services.edit', $service) }}" class="text-mustBlue">Edit</a>
            @endcan
            <a href="{{ route('admin.services.index') }}" class="text-mustGreen">Back</a>
        </div>
    </div>

    <div class="page-content-container overflow-hidden p-0">
        @if ($service->image_url)
            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="h-64 w-full object-cover">
        @else
            <div class="flex h-64 w-full items-center justify-center bg-gray-100 px-4 text-center font-semibold text-gray-500">
                No Image Uploaded
            </div>
        @endif

        <div class="p-5 md:p-6">
            <p class="leading-7 text-gray-600">{{ $service->description }}</p>

            <div class="mt-6 grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
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
                <div>
                    <p class="font-semibold text-gray-700">Display order</p>
                    <p>{{ $service->display_order }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 border-t border-gray-200 pt-6 md:grid-cols-2">
                <div>
                    <h2 class="font-bold text-mustBlue">What is included</h2>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                        @forelse ($service->included_items ?? [] as $item)
                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                        @empty
                            <li>No items provided.</li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold text-mustBlue">Needs treated</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $service->needs_treated ?: 'No details provided.' }}</p>
                </div>
                <div>
                    <h2 class="font-bold text-mustBlue">What to bring</h2>
                    <ul class="mt-3 space-y-2 text-sm leading-6 text-gray-600">
                        @forelse ($service->items_to_bring ?? [] as $item)
                            <li class="flex gap-2"><span class="mt-2 h-1.5 w-1.5 flex-none rounded-full bg-mustGreen"></span><span>{{ $item }}</span></li>
                        @empty
                            <li>No items provided.</li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h2 class="font-bold text-mustBlue">Appointment information</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $service->appointment_details ?: 'No details provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
