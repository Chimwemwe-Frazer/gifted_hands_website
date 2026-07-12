@extends('layouts.app')

@section('title')
    Roles
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">All Roles</h1>
        <a x-on:click.prevent="$dispatch('open-modal', 'addRoleModal')" class="btn-primary cursor-pointer">Add Role</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
        @foreach ($roles as $role)
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="p-4">
                    <a href="{{ route('admin.roles.show', $role->id) }}" class="record-title">
                        {{ $role->name }}
                    </a>

                    <div class="text-sm text-gray-600 space-y-1">
                        @php
                            $role_permissions = $role->permissions->take(8);
                            $remaining = $role->permissions->count() - $role_permissions->count();
                        @endphp

                        @foreach ($role_permissions as $permission)
                            <span class="inline-block text-gray-600 px-1 py-1 rounded-md text-xs">
                                {{ $permission->name }},
                            </span>
                        @endforeach

                        @if ($remaining > 0)
                            <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-md text-xs">
                                +{{ $remaining }} more
                            </span>
                        @endif
                    </div>

                    <div class="flex gap-3 flex-col md:flex-row md:items-center md:justify-between mt-2 md:mt-4">
                        <p class="text-gray-600 text-sm">
                            @if ($role->users->count() > 0)
                                <span class="font-medium text-gray-900">{{ $role->users->count() }}</span> users assigned
                            @else
                                <span class="text-gray-500 italic">No users assigned</span>
                            @endif
                        </p>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.roles.show', $role->id) }}"
                                class="text-blue-500 hover:text-blue-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                            <a href="#"
                                @click.prevent="$dispatch('open-edit-role', { id: {{ $role->id }}, name: '{{ $role->name }}', permissions: {{ json_encode($role->permissions->pluck('name')) }} })"
                                class="text-blue-500 hover:text-blue-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>


                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 transition duration-300 delete_item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="page-heading mt-4">All Permissions</h2>
    <div class="page-content-container">
        <div class="flex flex-wrap gap-2">
            @foreach ($permissions as $permission)
                <span class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-md">
                    {{ $permission }}
                </span>
            @endforeach
        </div>
    </div>

    <x-modal name="editRoleModal" :maxWidth="'3xl'" :canCloseByClick="false">
        <div x-data="{
            roleId: null,
            roleName: '',
            rolePermissions: [],
            search: '',
            open(role) {
                this.roleId = role.id;
                this.roleName = role.name;
                this.rolePermissions = role.permissions;
                this.$dispatch('open-modal', 'editRoleModal');
            },
            close() {
                this.roleId = null;
                this.roleName = '';
                this.rolePermissions = [];
                this.$dispatch('close-modal', 'editRoleModal');
            }
        }" x-on:open-edit-role.window="open($event.detail)"
            class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-mustBlue">Edit Role</h3>
                <svg xmlns="http://www.w3.org/2000/svg" @click.prevent="close()" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor"
                    class="size-5 cursor-pointer text-gray-500 hover:text-mustGreen">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <form method="POST" x-bind:action="'{{ route('admin.roles.update', '') }}/' + roleId" class="mt-2">
                @csrf
                @method('PATCH')

                <label for="edit-name" class="label">Name</label>
                <input type="text" id="edit-name" name="name" class="input" required x-model="roleName">

                <label for="edit-permissions" class="label mt-3">Permissions</label>
                <div class="mt-1 mb-2">
                    <input type="text" x-model="search" placeholder="Search & Select permissions..."
                        class="w-full input" />
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-2 border rounded-md">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center space-x-2 p-2 rounded-md cursor-pointer hover:bg-gray-100"
                                x-show="search === '' || '{{ strtolower($permission) }}'.includes(search.toLowerCase())">
                                <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                    x-bind:checked="rolePermissions.includes('{{ $permission }}')"
                                    class="rounded border-mustGreen appearance-none checked:bg-mustGreen checked:border-mustGreen focus:ring-mustGreen">
                                <span class="text-gray-500">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" @click.prevent="close()" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary-big">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="addRoleModal" :maxWidth="'3xl'" :canCloseByClick="false">
        <div x-data="{ search: '' }" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-mustBlue">Add New Role</h3>
                <svg xmlns="http://www.w3.org/2000/svg" @click.prevent="$dispatch('close-modal', 'addRoleModal')"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-5 cursor-pointer text-gray-500 hover:text-mustGreen">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <form method="POST" action="{{ route('admin.roles.store') }}" class="mt-2">
                @csrf

                <label for="name" class="label">Name</label>
                <input type="text" id="name" name="name" class="input" required>

                <label for="permissions" class="label mt-3">Permissions</label>
                <!-- Search Input -->
                <div class="mt-1 mb-2">
                    <input type="text" x-model="search" placeholder="Search & Select permissions..."
                        class="w-full input" />
                </div>

                <!-- Permissions List -->
                <div class="mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-2 border rounded-md">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center space-x-2 p-2 rounded-md cursor-pointer hover:bg-gray-100"
                                x-show="search === '' || '{{ strtolower($permission) }}'.includes(search.toLowerCase())">
                                <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                    class="rounded border-mustGreen appearance-none checked:bg-mustGreen checked:border-mustGreen focus:ring-mustGreen">
                                <span class="text-gray-500">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" x-on:click.prevent="$dispatch('close-modal', 'addRoleModal')"
                            class="btn-secondary">Close</button>
                        <button type="submit" class="btn-primary-big">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
