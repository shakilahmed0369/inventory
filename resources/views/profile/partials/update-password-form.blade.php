<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div class="space-y-1.5">
            <x-admin.label for="update_password_current_password" :value="__('Current Password')" />
            <x-admin.input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
            />
            <x-admin.input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="space-y-1.5">
            <x-admin.label for="update_password_password" :value="__('New Password')" />
            <x-admin.input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
            />
            <x-admin.input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="space-y-1.5">
            <x-admin.label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-admin.input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
            />
            <x-admin.input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-3 pt-1">
            <x-admin.button type="submit">{{ __('Update Password') }}</x-admin.button>

            @if (session('status') === 'password-updated')
                <span id="password-saved-msg" class="text-sm font-medium text-emerald-600">{{ __('Password updated.') }}</span>
                <script>
                    $(function () { setTimeout(function () { $('#password-saved-msg').fadeOut(400); }, 2500); });
                </script>
            @endif
        </div>
    </form>
</section>
