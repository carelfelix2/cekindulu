<x-layouts.guest>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Lupa Password?</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Masukkan email dan kami akan kirimkan link reset.</p>
    </div>

    @if(session('status'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800/50 text-sm text-primary-700 dark:text-primary-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input @error('email') error @enderror"
                   placeholder="kamu@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-md w-full justify-center">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-6 text-center text-xs text-surface-500 dark:text-surface-400">
        <a href="{{ route('login') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center justify-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke halaman masuk
        </a>
    </p>
</x-layouts.guest>
