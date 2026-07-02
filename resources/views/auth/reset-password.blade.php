<x-layouts.guest>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Reset Password</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Buat password baru untuk akunmu.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="input @error('email') error @enderror">
            @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Password Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input @error('password') error @enderror"
                   placeholder="Min. 8 karakter">
            @error('password')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input @error('password_confirmation') error @enderror"
                   placeholder="Ulangi password baru">
            @error('password_confirmation')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn btn-primary btn-md w-full justify-center">
            Reset Password
        </button>
    </form>
</x-layouts.guest>
