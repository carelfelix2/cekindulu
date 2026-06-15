<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        {{-- Logo / Branding --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-extrabold text-lg font-display">C</span>
                </div>
                <span class="text-xl font-extrabold text-surface-900 dark:text-white font-display">
                    Cek<span class="text-primary-600 dark:text-primary-400">Dulu</span>
                </span>
            </a>
            <h2 class="mt-6 text-2xl font-extrabold text-surface-900 dark:text-white font-display">Lupa Password</h2>
            <p class="mt-1.5 text-sm text-surface-500 dark:text-surface-400">
                Masukkan email kamu, kami akan kirim link reset password.
            </p>
        </div>

        {{-- Session Status --}}
        @if(session('status'))
            <div class="mb-5 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                              @error('email') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Kirim Link Reset Password
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                ← Kembali ke login
            </a>
        </div>
    </div>
</x-guest-layout>
