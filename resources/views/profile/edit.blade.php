<x-layouts.app>
    <x-slot name="header">
        <x-slot name="title">Profile - CekDulu</x-slot>
    </x-slot>

    {{-- Page Header --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-800 dark:to-surface-900">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-accent-400/10 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-2xl md:text-3xl font-extrabold text-white font-display tracking-tight">{{ __('Profile') }}</h1>
            <p class="mt-1 text-primary-100 text-sm">{{ __('Manage your account settings and preferences.') }}</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        {{-- Profile Information --}}
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-red-200 dark:border-red-900/50 p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-layouts.app>
