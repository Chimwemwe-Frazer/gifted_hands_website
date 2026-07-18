@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">User Details : {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            <!-- Email -->
            <div class="flex items-center gap-3 p-3 bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>

                <span class="text-gray-900 font-medium">{{ $user->email }}</span>
            </div>

            <!-- Role -->
            <div class="flex items-center gap-3 p-3 bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

                <span class="text-gray-900 font-medium">{{ $user->roles->first()?->name ?? 'Role assignment required' }}</span>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-3 p-3 bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>

                <span class="text-gray-900 font-medium">
                    <span class="{{ $user->status == 'Active' ? 'text-mustGreen' : 'text-red-600' }}">{{ $user->status }}</span> Status
                </span>
            </div>
        </div>


        <div class="mt-4">
            <h5 class="text-gray-600 font-medium mb-2 md:mb-3 text-lg">Effective Permissions</h5>
            <div class="flex flex-wrap gap-2">
                @forelse ($user_permissions as $permission)
                    <span class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">
                        {{ $permission }}
                    </span>
                @empty
                    <span class="text-gray-500 text-sm">No permissions assigned</span>
                @endforelse
            </div>
        </div>

        <div class="mt-6 flex flex-wrap justify-end items-center gap-2">

            @if (auth()->user()->can('add user permissions'))
                <button x-on:click.prevent="$dispatch('open-modal', 'permissionModal')"
                    class="service-action-button service-action-button--primary">
                    Manage Additional Permissions
                </button>
            @endif

            @if (auth()->user()->can('suspend user'))
                <form class="delete-form"
                    action="{{ route('admin.users.' . ($user->status == 'Active' ? 'deactivate' : 'activate'), $user->id) }}"
                    method="POST">
                    @method('PUT')
                    @csrf
                    <button type="submit"
                        class="delete_item service-action-button
                        {{ $user->status == 'Active' ? 'service-action-button--danger' : 'service-action-button--primary' }}">
                        {{ $user->status == 'Active' ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            @endif

        </div>
    </div>


    <x-modal name="permissionModal" :maxWidth="'3xl'" :canCloseByClick="false" >
        <div x-data="{ search: '' }" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-mustBlue">Manage Additional Permissions</h3>
                <svg xmlns="http://www.w3.org/2000/svg" @click.prevent="$dispatch('close-modal', 'permissionModal')" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 cursor-pointer text-gray-500 hover:text-mustGreen">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />>
                </svg>
            </div>

            <!-- Search Input -->
            <div class="mt-3">
                <p class="mb-3 text-sm text-gray-500">
                    Checked permissions are added specifically for this user on top of the permissions inherited from the {{ $user->roles->first()?->name }} role.
                </p>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Search permissions..."
                    class="w-full input"
                />
            </div>

            <!-- Permissions List -->
            <form method="POST" action="{{ route('admin.user.update-permissions', $user->id) }}" class="mt-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-2 border rounded-md">
                    @foreach ($all_permissions as $permission)
                        <label
                            class="flex items-center space-x-2 p-2 rounded-md cursor-pointer hover:bg-gray-100"
                            x-show="search === '' || '{{ strtolower($permission) }}'.includes(search.toLowerCase())"
                        >
                            <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                class="rounded border-mustGreen appearance-none checked:bg-mustGreen checked:border-mustGreen focus:ring-mustGreen"
                                {{ $direct_permissions->contains($permission) ? 'checked' : '' }}>
                            <span class="text-gray-500">{{ $permission }}</span>
                        </label>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" x-on:click.prevent="$dispatch('close-modal', 'permissionModal')"
                        class="service-action-button service-action-button--secondary">Close</button>
                    <button type="submit"
                        class="service-action-button service-action-button--primary">Save</button>
                </div>
            </form>
        </div>
    </x-modal>


@endsection
