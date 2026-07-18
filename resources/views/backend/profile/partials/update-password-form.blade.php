<section>
    <header>
        <h2 class="text-lg font-medium text-mustBlue">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4 space-y-4">
        @csrf
        @method('put')
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full">
                <label class="label" for="password">Current Password</label>

                <input id="password" class="input w-full" type="password" name="current_password" required
                    autocomplete="current-password" />

                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                    @foreach ($errors->updatePassword->get('current_password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="w-full">
                <label class="label" for="password">New Password</label>

                <input id="password" class="input w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                    @foreach ($errors->updatePassword->get('password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="w-full">
                <label class="label" for="password_confirmation">Confirm Password</label>

                <input id="password_confirmation" class="input w-full" type="password" name="password_confirmation"
                    required autocomplete="new-password" />

                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                    @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="service-action-button service-action-button--primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
