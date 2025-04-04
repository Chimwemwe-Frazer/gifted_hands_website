@extends('layouts.app')
@section('title')
    {{ isset($user->name) ? 'Edit ' . $user->name : 'Add User' }}
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">{{ isset($user->name) ? 'Edit ' . $user->name : 'Add User' }}</h1>
        <a href="{{ route('admin.users.index') }}" class="text-mustGreen flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
            <span>Back</span>
        </a>
    </div>

    <div class="page-content-container">
        <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
            method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @if (isset($user))
                @method('PUT')
            @endif
            <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="flex flex-col  space-y-2">
                    <label for="" class="label">Full Name <span class="text-red-500">*</span></label>
                    <input required type="text" value="{{ isset($user) ? $user->name : old('name') }}" name="name"
                        id="" class="input">
                    <span class=" text-red-500">{{ $errors->first('name') }}</span>
                </div>
                <div class="flex flex-col  space-y-2">
                    <label for="" class="label">Email <span class="text-red-500">*</span></label>
                    <input {{ isset($user) ? 'disabled' : '' }} required type="email" value="{{ isset($user) ? $user->email : old('email') }}" name="email"
                        id="" class="input">
                    <span class=" text-red-500">{{ $errors->first('email') }}</span>
                </div>

                <div class="flex flex-col  space-y-2">
                    <label for="" class="label">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="" class="input">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}"
                                {{ isset($user) && $user->roles->first()->name == $role ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                    <span class=" text-red-500">{{ $errors->first('role') }}</span>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <div class=" space-y-2">
                    <button type="submit" class=" btn-primary">{{ isset($user) ? 'Update' : 'Add' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
