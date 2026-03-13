<x-admin-layout>
    <x-slot name="heading">Profile</x-slot>
    <x-slot name="breadcrumbs">
        <span>Home</span>
        <span>/</span>
        <span class="font-medium text-zinc-900">Profile</span>
    </x-slot>

    <div class="mx-auto max-w-2xl space-y-5">

        <x-admin.card
            title="{{ __('Profile Information') }}"
            description="{{ __('Update your name and email address.') }}"
        >
            @include('profile.partials.update-profile-information-form')
        </x-admin.card>

        <x-admin.card
            title="{{ __('Update Password') }}"
            description="{{ __('Use a long, random password to keep your account secure.') }}"
        >
            @include('profile.partials.update-password-form')
        </x-admin.card>
        
    </div>
</x-admin-layout>
