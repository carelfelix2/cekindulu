<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="{'dark': $store.theme.dark}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title') ? $attributes->get('title') . ' - ' . config('app.name', 'CekDulu') : config('app.name', 'CekDulu') }}</title>
        <meta name="description" content="{{ $attributes->get('description', 'CekDulu - Temukan produk paling worth it dengan perbandingan harga dari berbagai marketplace Indonesia.') }}">

        <!-- Fonts (Google Fonts via Bunny CDN) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@500;600;700&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-surface-50 text-surface-800 dark:bg-surface-950 dark:text-surface-100 transition-colors duration-300">

        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Content --}}
        <main class="min-h-[60vh]">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <x-footer />

        {{-- Dark Mode Toggle (Floating) --}}
        <button
            @@click="$store.theme.toggle()"
            class="fixed bottom-6 right-6 z-50 p-3 rounded-full shadow-lg bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 text-surface-600 dark:text-surface-300 hover:scale-110 transition-all duration-200"
            aria-label="Toggle dark mode"
        >
            {{-- Sun icon (shown in dark mode) --}}
            <svg x-show="$store.theme.dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            {{-- Moon icon (shown in light mode) --}}
            <svg x-show="!$store.theme.dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        {{-- Toast Container --}}
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed top-20 right-4 z-50 max-w-sm">
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-primary-50 border border-primary-200 text-primary-800 shadow-lg">
                        <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-lg">
                        <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @stack('scripts')
    </body>
</html>
