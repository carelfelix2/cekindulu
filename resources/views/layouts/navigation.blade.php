<nav x-data="navbar"
     :class="scrolled ? 'navbar-blur shadow-sm' : 'bg-white/0 border-transparent'"
     class="sticky top-0 z-40 transition-all duration-300 border-b border-surface-200/60 dark:border-surface-800/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo + Nav --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center shadow-sm shadow-primary-500/30 group-hover:shadow-md group-hover:shadow-primary-500/40 group-hover:scale-105 transition-all duration-200">
                        <svg class="w-4.5 h-4.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-[1.0625rem] font-bold text-surface-900 dark:text-white font-display tracking-tight">
                        Cek<span class="text-primary-600">Dulu</span>
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-0.5">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">Artikel</a>
                    <a href="{{ route('compare.index') }}" class="nav-link {{ request()->routeIs('compare.*') ? 'active' : '' }}">Bandingkan</a>
                    <a href="{{ route('membership.index') }}" class="nav-link {{ request()->routeIs('membership.*') ? 'active' : '' }}">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-accent-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Premium
                        </span>
                    </a>
                </div>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2">
                {{-- Dark Mode --}}
                <button @@click="$store.theme.toggle()"
                        class="p-2 rounded-lg text-surface-400 hover:text-surface-700 hover:bg-surface-100 dark:text-surface-500 dark:hover:text-surface-200 dark:hover:bg-surface-800 transition-all duration-150"
                        aria-label="Toggle dark mode">
                    <svg x-show="!$store.theme.dark" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="$store.theme.dark" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                @auth
                    {{-- User Dropdown --}}
                    <div class="hidden sm:block relative" x-data="{ open: false }" @@click.outside="open = false">
                        <button @@click="open = !open"
                                class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-sm font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-all duration-150">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline text-sm">{{ Str::limit(Auth::user()->name, 14) }}</span>
                            <svg class="w-3.5 h-3.5 text-surface-400 transition-transform duration-150" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-surface-900 rounded-xl shadow-xl shadow-surface-900/10 dark:shadow-black/30 border border-surface-200 dark:border-surface-800 py-1.5 z-50"
                             style="display:none">
                            <div class="px-3.5 py-2.5 border-b border-surface-100 dark:border-surface-800 mb-1">
                                <div class="font-semibold text-sm text-surface-900 dark:text-white truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-surface-400 dark:text-surface-500 truncate mt-0.5">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil
                            </a>
                            <div class="border-t border-surface-100 dark:border-surface-800 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 w-full px-3.5 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar Gratis</a>
                    </div>
                @endauth

                {{-- Mobile Hamburger --}}
                <button x-data
                        @@click="$dispatch('toggle-mobile-menu')"
                        class="lg:hidden p-2 rounded-lg text-surface-500 hover:text-surface-700 hover:bg-surface-100 dark:text-surface-400 dark:hover:bg-surface-800 transition-all duration-150"
                        aria-label="Menu">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Mobile Drawer --}}
<div x-data="{ open: false }"
     @@toggle-mobile-menu.window="open = !open; document.body.style.overflow = open ? 'hidden' : ''"
     x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 lg:hidden"
     style="display:none">

    {{-- Backdrop --}}
    <div @@click="open = false; document.body.style.overflow = ''" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute right-0 top-0 h-full w-72 bg-white dark:bg-surface-950 shadow-2xl flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-surface-100 dark:border-surface-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2" @@click="open = false; document.body.style.overflow = ''">
                <div class="w-7 h-7 bg-primary-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="font-bold text-surface-900 dark:text-white font-display">Cek<span class="text-primary-600">Dulu</span></span>
            </a>
            <button @@click="open = false; document.body.style.overflow = ''" class="p-1.5 rounded-lg text-surface-400 hover:text-surface-600 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Nav Links --}}
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
            <a href="{{ route('home') }}" @@click="open = false; document.body.style.overflow = ''"
               class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('products.index') }}" @@click="open = false; document.body.style.overflow = ''"
               class="mobile-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Produk
            </a>
            <a href="{{ route('articles.index') }}" @@click="open = false; document.body.style.overflow = ''"
               class="mobile-nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Artikel
            </a>
            <a href="{{ route('compare.index') }}" @@click="open = false; document.body.style.overflow = ''"
               class="mobile-nav-link {{ request()->routeIs('compare.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                Bandingkan
            </a>
            <a href="{{ route('membership.index') }}" @@click="open = false; document.body.style.overflow = ''"
               class="mobile-nav-link {{ request()->routeIs('membership.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Premium
            </a>
        </div>

        {{-- Footer --}}
        <div class="px-4 py-4 border-t border-surface-100 dark:border-surface-800 space-y-2.5">
            @auth
                <div class="flex items-center gap-3 px-1 mb-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-sm text-surface-900 dark:text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-surface-400 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" @@click="open = false; document.body.style.overflow = ''" class="btn btn-secondary btn-sm w-full justify-center">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm w-full justify-center text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm w-full justify-center">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm w-full justify-center">Daftar Gratis</a>
            @endauth
        </div>
    </div>
</div>
