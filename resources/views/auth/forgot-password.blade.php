@extends('layouts.guest')
@section('title')
    Forgot Password
@endsection
@section('content')
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <div class="font-medium text-sm text-green-600 dark:text-green-400 mb-3">
        {{ session('status') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
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

        <div class="flex justify-between items-center mt-3">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                  </svg>
                {{ __('Login') }}
            </a>

            <button type="submit" class="btn-primary w-fit ">{{ __('Email Password Reset Link') }}</button>
        </div>

    </form>
@endsection
