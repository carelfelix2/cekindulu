<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="{'dark': $store.theme.dark}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CekDulu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@500;600;700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 dark:bg-surface-950 text-surface-800 dark:text-surface-200 transition-colors duration-300">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-400/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-400/10 rounded-full blur-3xl"></div>
            </div>

            {{-- Logo --}}
            <div class="mb-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-14 h-14 bg-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-xl transition-shadow">
                        <span class="text-white font-bold text-2xl font-display">C</span>
                    </div>
                    <span class="text-3xl font-bold text-surface-900 dark:text-white font-display tracking-tight">
                        Cek<span class="text-primary-600 dark:text-primary-400">Dulu</span>
                    </span>
                </a>
            </div>

            {{-- Card --}}
            <div class="w-full max-w-lg bg-white dark:bg-surface-800 rounded-2xl shadow-lg shadow-surface-200/50 dark:shadow-black/20 border border-surface-200 dark:border-surface-700 p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-surface-900 dark:text-white font-display mb-2">CekDulu</h1>
                <p class="text-surface-500 dark:text-surface-400 mb-6 leading-relaxed">
                    Temukan produk paling worth it dengan perbandingan harga dari berbagai marketplace Indonesia.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary px-6 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 font-semibold text-sm hover:bg-surface-50 dark:hover:bg-surface-700 transition-all">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <p class="mt-8 text-xs text-surface-400 dark:text-surface-500">
                    &copy; {{ date('Y') }} CekDulu &middot; v{{ app()->version() }}
                </p>
            </div>
        </div>
    </body>
</html>
