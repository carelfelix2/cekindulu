<x-layouts.guest>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Selamat datang kembali</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Masuk ke akun CekDulu kamu</p>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800/50 text-sm text-primary-700 dark:text-primary-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="input @error('email') error @enderror"
                   placeholder="kamu@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-surface-700 dark:text-surface-300">Password</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="input @error('password') error @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 cursor-pointer">
            <label for="remember_me" class="text-xs text-surface-600 dark:text-surface-400 cursor-pointer">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-2">
            Masuk
        </button>
    </form>

    @if(Route::has('register'))
        <p class="mt-6 text-center text-xs text-surface-500 dark:text-surface-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline">Daftar gratis</a>
        </p>
    @endif
</x-layouts.guest>
