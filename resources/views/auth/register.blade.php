<x-layouts.guest>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Buat akun baru</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Gratis selamanya. Tidak perlu kartu kredit.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input @error('name') error @enderror"
                   placeholder="Nama kamu">
            @error('name')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="input @error('email') error @enderror"
                   placeholder="kamu@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input @error('password') error @enderror"
                   placeholder="Min. 8 karakter">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input @error('password_confirmation') error @enderror"
                   placeholder="Ulangi password">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-2">
            Buat Akun
        </button>
    </form>

    <p class="mt-6 text-center text-xs text-surface-500 dark:text-surface-400">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline">Masuk</a>
    </p>
</x-layouts.guest>
