@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="page-heading">Role Details : {{ $role->name }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <h5 class="text-gray-600 font-medium mb-2 md:mb-3 text-lg">Permissions</h5>
        <div class="flex flex-wrap gap-2">
            @foreach ($role->permissions as $permission)
                <span class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">
                    {{ $permission->name }}
                </span>
            @endforeach
        </div>
        <h5 class="text-gray-600 font-medium mb-2 md:mb-3 text-lg mt-4">Users</h5>
        <div class="flex flex-wrap gap-2">
            @forelse ($role->users as $user)
                <a href="{{ route('admin.users.show', $user->id) }}" class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">
                    {{ $user->name }}
                </a>
            @empty
                <span class=" text-gray-800 text-xs">
                    No users assigned to this role
                </span>
            @endforelse
        </div>
    </div>

@endsection
