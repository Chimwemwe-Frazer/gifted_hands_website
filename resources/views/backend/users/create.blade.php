@extends('layouts.app')
@section('title')
    {{ isset($user->name) ? 'Edit ' . $user->name : 'Add Receptionist' }}
@endsection

@section('content')
    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="page-heading">{{ isset($user->name) ? 'Edit ' . $user->name : 'Add Receptionist' }}</h1>
        <a href="{{ route('admin.users.index') }}" class="service-action-button service-action-button--secondary">Back</a>
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
                    <label for="role" class="label">Role</label>
                    <input id="role" type="text" value="{{ $roleName }}" class="input bg-gray-100" disabled>
                </div>
            </div>
            <div class="mt-4 flex justify-stretch sm:justify-end">
                <div class=" space-y-2">
                    <button type="submit" class="service-action-button service-action-button--primary w-full sm:w-auto">{{ isset($user) ? 'Update' : 'Add Receptionist' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
