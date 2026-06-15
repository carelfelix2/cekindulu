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

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 dark:bg-surface-950 text-surface-800 dark:text-surface-200 transition-colors duration-300">
        <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-400/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-400/10 rounded-full blur-3xl"></div>
            </div>

            <div class="mb-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-xl transition-shadow">
                        <span class="text-white font-bold text-2xl font-display">C</span>
                    </div>
                    <span class="text-2xl font-bold text-surface-900 dark:text-white font-display tracking-tight">
                        Cek<span class="text-primary-600">Dulu</span>
                    </span>
                </a>
            </div>

            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-lg shadow-surface-200/50 dark:shadow-black/20 border border-surface-200 dark:border-surface-700 p-8">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-surface-500 dark:text-surface-400">
                &copy; {{ date('Y') }} CekDulu. All rights reserved.
            </p>
        </div>
    </body>
</html>
