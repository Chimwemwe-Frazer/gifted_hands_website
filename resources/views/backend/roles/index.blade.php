@extends('layouts.app')

@section('title')
    Roles
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Staff Roles</h1>
        <span class="text-sm text-gray-500">Roles are fixed; additional access is granted per receptionist.</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($roles as $role)
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="p-4">
                    <a href="{{ route('admin.roles.show', $role->id) }}" class="record-title">
                        {{ $role->name }}
                    </a>

                    <div class="text-sm text-gray-600 space-y-1">
                        @php
                            $rolePermissions = $role->permissions->take(8);
                            $remaining = $role->permissions->count() - $rolePermissions->count();
                        @endphp

                        @forelse ($rolePermissions as $permission)
                            <span class="inline-block text-gray-600 px-1 py-1 rounded-md text-xs">
                                {{ $permission->name }}{{ $loop->last && $remaining === 0 ? '' : ',' }}
                            </span>
                        @empty
                            <span class="text-gray-500 italic text-xs">No default permissions</span>
                        @endforelse

                        @if ($remaining > 0)
                            <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-md text-xs">
                                +{{ $remaining }} more
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <p class="text-gray-600 text-sm">
                            @if ($role->users->count() > 0)
                                <span class="font-medium text-gray-900">{{ $role->users->count() }}</span> users assigned
                            @else
                                <span class="text-gray-500 italic">No users assigned</span>
                            @endif
                        </p>

                        <a href="{{ route('admin.roles.show', $role->id) }}"
                            class="service-action-button service-action-button--secondary">
                            View details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="page-heading mt-4">All Available Permissions</h2>
    <div class="page-content-container">
        <div class="flex flex-wrap gap-2">
            @foreach ($permissions as $permission)
                <span class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">
                    {{ $permission }}
                </span>
            @endforeach
        </div>
    </div>
@endsection
