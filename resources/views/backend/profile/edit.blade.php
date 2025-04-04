@extends('layouts.app')
@section('title')
    Profile
@endsection

@section('content')
    <div class="">
        <div class=" mx-auto space-y-6">
            <div class="p-4 md:p-6 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('backend.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection
