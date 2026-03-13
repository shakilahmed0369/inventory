<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="space-y-1.5">
            <x-admin.label for="name" :value="__('Name')" />
            <x-admin.input
                id="name"
                name="name"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-admin.input-error :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1.5">
            <x-admin.label for="email" :value="__('Email')" />
            <x-admin.input
                id="email"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-admin.input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="rounded-md border border-amber-200 bg-amber-50 p-3">
                    <p class="text-sm text-amber-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="font-medium underline hover:text-amber-900">
                            {{ __('Re-send verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm font-medium text-emerald-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-1">
            <x-admin.button type="submit">{{ __('Save Changes') }}</x-admin.button>

            @if (session('status') === 'profile-updated')
                <span id="profile-saved-msg" class="text-sm font-medium text-emerald-600">{{ __('Saved successfully.') }}</span>
                <script>
                    $(function () { setTimeout(function () { $('#profile-saved-msg').fadeOut(400); }, 2500); });
                </script>
            @endif
        </div>
    </form>
</section>
