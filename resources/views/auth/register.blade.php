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
            <h2 class="mt-6 text-2xl font-extrabold text-surface-900 dark:text-white font-display">Buat Akun Baru</h2>
            <p class="mt-1.5 text-sm text-surface-500 dark:text-surface-400">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">Masuk</a></p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                              @error('name') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
                @error('name')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                              @error('email') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Nomor Telepon <span class="text-surface-400 font-normal">(opsional)</span></label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm">
                @error('phone')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                              @error('password') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
                @error('password')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-1.5">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:border-primary-500 outline-none transition-all text-sm
                              @error('password_confirmation') border-red-300 dark:border-red-700 focus:ring-red-500 @enderror">
                @error('password_confirmation')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                Daftar Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>
