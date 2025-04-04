@extends('layouts.guest')
@section('title')
    Login
@endsection
@section('content')
    @if (session('error'))
        <div class="text-red-500">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="label" for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}"
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

            <input id="password" class="input" type="password" name="password" required
                autocomplete="current-password" />

            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->get('password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between items-center py-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded  border-gray-300  text-green-600 shadow-sm focus:ring-green-500  " name="remember">
                <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-mustGreen "
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full">Login</button>
    </form>
@endsection
