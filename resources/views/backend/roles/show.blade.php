@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Role Details : {{ $role->name }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="text-mustGreen flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
            <span>Back</span>
        </a>
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
