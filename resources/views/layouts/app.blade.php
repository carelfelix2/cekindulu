<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{'dark': $store.theme.dark}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $attributes->get('title') ? $attributes->get('title') . ' — CekDulu' : 'CekDulu — Temukan Produk Paling Worth It' }}</title>
    <meta name="description" content="{{ $attributes->get('description', 'CekDulu — Platform perbandingan harga dan rekomendasi produk terbaik dari berbagai marketplace Indonesia.') }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $attributes->get('title') ? $attributes->get('title') . ' — CekDulu' : 'CekDulu' }}">
    <meta property="og:description" content="{{ $attributes->get('description', 'Platform perbandingan harga dan rekomendasi produk terbaik dari berbagai marketplace Indonesia.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-50 text-surface-800 dark:bg-surface-950 dark:text-surface-100 transition-colors duration-200">

    @include('layouts.navigation')

    <main class="min-h-[60vh]">
        {{ $slot }}
    </main>

    <x-footer />

    {{-- Toast Notifications --}}
    @if(session('success') || session('error'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4"
             style="display:none">
            @if(session('success'))
                <div class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-surface-900 dark:bg-surface-800 text-white shadow-2xl border border-surface-700">
                    <div class="w-7 h-7 rounded-full bg-primary-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-auto text-surface-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-surface-900 dark:bg-surface-800 text-white shadow-2xl border border-surface-700">
                    <div class="w-7 h-7 rounded-full bg-red-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="ml-auto text-surface-400 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>
    @endif

    @stack('scripts')
</body>
</html>
