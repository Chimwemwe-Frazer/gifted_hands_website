@extends('layouts.guest')
@section('title')
    Reset Password
@endsection
@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label class="label" for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email', $request->email) }}"
                required autofocus autocomplete="username" />
            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->get('email') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="label" for="password">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" />
            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->get('password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="label" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->get('password_confirmation') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn-primary w-fit ">{{ __('Reset Password') }}</button>
        </div>
    </form>
@endsection
