<section>
    <header>
        <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                          @error('current_password', 'updatePassword') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
            @error('current_password', 'updatePassword')
                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                          @error('password', 'updatePassword') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
            @error('password', 'updatePassword')
                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                          @error('password_confirmation', 'updatePassword') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary py-2.5 px-6 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
