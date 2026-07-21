@extends('layouts.app')

@section('title')
    Doctors
@endsection

@section('content')
    <div class="mb-5 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between md:mb-0">
        <div>
            <h1 class="page-heading">Doctors</h1>
            <p class="mt-1 text-sm text-gray-600">Manage the doctors and clinicians displayed on the public website.</p>
        </div>
        @can('add doctor')
            <a href="{{ route('admin.doctors.create') }}" class="service-action-button service-action-button--primary self-start sm:self-auto">Add Doctor</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($doctors as $doctor)
            <article class="overflow-hidden rounded-lg bg-white shadow">
                @if ($doctor->image_url)
                    <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="h-56 w-full object-cover object-[50%_22%]">
                @else
                    <div class="flex h-56 w-full items-center justify-center bg-gray-100 px-4 text-center text-sm font-semibold text-gray-500">
                        No Image Uploaded
                    </div>
                @endif

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="break-words text-xl font-bold text-mustBlue">{{ $doctor->name }}</h2>
                            <p class="mt-1 text-sm font-semibold text-mustGreen">{{ $doctor->specialization }}</p>
                        </div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $doctor->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $doctor->status }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm leading-6 text-gray-600">{{ Str::limit($doctor->qualification, 100) }}</p>
                    <p class="mt-2 text-xs text-gray-500">Display order: {{ $doctor->display_order }}</p>

                    <div class="mt-4 flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-4">
                        @can('update doctor')
                            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="service-action-button service-action-button--secondary">Edit</a>
                        @endcan
                        @can('delete doctor')
                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST">
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
                No doctors have been created yet.
            </div>
        @endforelse
    </div>
@endsection
