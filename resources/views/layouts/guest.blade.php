<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{'dark': $store.theme.dark}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CekDulu') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 dark:bg-surface-950 text-surface-800 dark:text-surface-200 transition-colors duration-200">

    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 relative overflow-hidden">

        {{-- Background grid --}}
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#e5e5e5_1px,transparent_1px),linear-gradient(to_bottom,#e5e5e5_1px,transparent_1px)] bg-[size:48px_48px] dark:bg-[linear-gradient(to_right,#262626_1px,transparent_1px),linear-gradient(to_bottom,#262626_1px,transparent_1px)] opacity-40"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-primary-400/8 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[400px] h-[300px] bg-accent-400/6 rounded-full blur-3xl"></div>
        </div>

        {{-- Logo --}}
        <div class="mb-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-xl group-hover:shadow-primary-500/35 group-hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xl font-bold text-surface-900 dark:text-white font-display tracking-tight">
                    Cek<span class="text-primary-600">Dulu</span>
                </span>
            </a>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-[420px]">
            <div class="bg-white dark:bg-surface-900 rounded-2xl shadow-xl shadow-surface-900/6 dark:shadow-black/30 border border-surface-200 dark:border-surface-800 p-8">
                {{ $slot }}
            </div>
        </div>

        <p class="mt-8 text-center text-xs text-surface-400 dark:text-surface-600">
            &copy; {{ date('Y') }} CekDulu. All rights reserved.
        </p>
    </div>
</body>
</html>
