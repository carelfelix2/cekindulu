<nav x-data="navbar"
     :class="scrolled ? 'navbar-blur shadow-sm' : 'bg-white dark:bg-surface-950 border-transparent'"
     class="sticky top-0 z-40 transition-all duration-300 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Left: Logo + Nav Links --}}
            <div class="flex items-center gap-8">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 group">
                    <div class="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center shadow-md shadow-primary-500/20 group-hover:shadow-lg group-hover:shadow-primary-500/30 transition-all duration-200">
                        <span class="text-white font-bold text-lg font-display">C</span>
                    </div>
                    <span class="text-lg font-bold text-surface-900 dark:text-white font-display tracking-tight">
                        Cek<span class="text-primary-600">Dulu</span>
                    </span>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Produk
                    </a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Artikel
                    </a>
                    <a href="{{ route('compare.index') }}" class="nav-link {{ request()->routeIs('compare.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        Bandingkan
                    </a>
                    <a href="{{ route('membership.index') }}" class="nav-link {{ request()->routeIs('membership.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Premium
                    </a>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center gap-3">
                {{-- Dark Mode Toggle --}}
                <button @@click="$store.theme.toggle()"
                        class="p-2 rounded-xl text-surface-500 hover:text-surface-700 hover:bg-surface-100 dark:text-surface-400 dark:hover:text-surface-200 dark:hover:bg-surface-800 transition-all duration-200"
                        aria-label="Toggle dark mode">
                    <svg x-show="!$store.theme.dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="$store.theme.dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                @auth
                    {{-- User Dropdown --}}
                    <div class="hidden sm:relative sm:flex sm:items-center" x-data="{ open: false }" @@click.outside="open = false">
                        <button @@click="open = !open"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-all duration-200">
                            <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-surface-800 rounded-2xl shadow-xl border border-surface-200 dark:border-surface-700 py-2 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-surface-100 dark:border-surface-700">
                                <div class="font-medium text-sm text-surface-900 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-surface-500 dark:text-surface-400">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil
                            </a>
                            <div class="border-t border-surface-100 dark:border-surface-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex sm:items-center sm:gap-2">
                        <a href="{{ route('login') }}" class="btn-ghost btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm">Daftar Gratis</a>
                    </div>
                @endauth

                {{-- Mobile Hamburger --}}
                <button @@click="mobileOpen = !mobileOpen; $store.mobileMenu.toggle()"
                        class="lg:hidden p-2 rounded-xl text-surface-500 hover:text-surface-700 hover:bg-surface-100 dark:text-surface-400 dark:hover:bg-surface-800 transition-all duration-200">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div x-data="mobileMenu"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 lg:hidden" style="display: none;"
         x-effect="mobileOpen = open">
        {{-- Backdrop --}}
        <div @@click="close()" class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>
        {{-- Drawer Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="absolute right-0 top-0 h-full w-80 max-w-[calc(100vw-3rem)] bg-white dark:bg-surface-900 shadow-2xl flex flex-col" @@click.outside="close()">
            <div class="flex items-center justify-between p-4 border-b border-surface-200 dark:border-surface-800">
                <span class="font-bold text-lg text-surface-900 dark:text-white font-display">Menu</span>
                <button @@click="close()" class="p-2 rounded-xl text-surface-400 hover:text-surface-600 hover:bg-surface-100 dark:hover:bg-surface-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-1">
                <a href="{{ route('home') }}" @@click="close()" class="mobile-nav-link {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20' : '' }}">🏠 Beranda</a>
                <a href="{{ route('products.index') }}" @@click="close()" class="mobile-nav-link {{ request()->routeIs('products.*') ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20' : '' }}">🛍️ Produk</a>
                <a href="{{ route('articles.index') }}" @@click="close()" class="mobile-nav-link {{ request()->routeIs('articles.*') ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20' : '' }}">📰 Artikel</a>
                <a href="{{ route('compare.index') }}" @@click="close()" class="mobile-nav-link {{ request()->routeIs('compare.*') ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20' : '' }}">⚖️ Bandingkan</a>
                <a href="{{ route('membership.index') }}" @@click="close()" class="mobile-nav-link {{ request()->routeIs('membership.*') ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20' : '' }}">⭐ Premium</a>
            </div>
            <div class="p-4 border-t border-surface-200 dark:border-surface-800 space-y-2">
                @auth
                    <div class="flex items-center gap-3 p-2 mb-2">
                        <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div><div class="font-medium text-sm text-surface-900 dark:text-white">{{ Auth::user()->name }}</div><div class="text-xs text-surface-500">{{ Auth::user()->email }}</div></div>
                    </div>
                    <a href="{{ route('dashboard') }}" @@click="close()" class="btn-outline btn-sm w-full justify-center">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost btn-sm w-full justify-center text-red-600">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-outline btn-sm w-full justify-center">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm w-full justify-center">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--color-surface-600);
        transition: all 0.2s ease;
        position: relative;
    }
    .nav-link:hover {
        color: var(--color-surface-900);
        background-color: var(--color-surface-100);
    }
    .dark .nav-link:hover {
        color: #e5e7eb;
        background-color: var(--color-surface-800);
    }
    .nav-link.active {
        color: var(--color-primary-700);
        background-color: var(--color-primary-50);
        font-weight: 600;
    }
    .dark .nav-link.active {
        color: var(--color-primary-400);
        background-color: rgb(5 150 105 / 0.15);
    }
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background-color: var(--color-primary-600);
        border-radius: 999px;
    }

    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 500;
        color: var(--color-surface-700);
        transition: all 0.15s ease;
    }
    .dark .mobile-nav-link {
        color: var(--color-surface-300);
    }
    .mobile-nav-link:hover {
        background-color: var(--color-surface-100);
        color: var(--color-surface-900);
    }
    .dark .mobile-nav-link:hover {
        background-color: var(--color-surface-800);
        color: white;
    }
</style>
