<footer class="bg-white dark:bg-surface-900 border-t border-surface-200 dark:border-surface-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-primary-600 rounded-xl flex items-center justify-center shadow-md shadow-primary-500/20">
                        <span class="text-white font-bold text-lg font-display">C</span>
                    </div>
                    <span class="text-lg font-bold text-surface-900 dark:text-white font-display tracking-tight">
                        Cek<span class="text-primary-600">Dulu</span>
                    </span>
                </a>
                <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed mb-6 max-w-xs">
                    Platform rekomendasi produk dan perbandingan harga affiliate Indonesia. Cek dulu sebelum checkout!
                </p>
                {{-- Social Icons --}}
                <div class="flex items-center gap-3">
                    <a href="#" class="social-icon" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="Twitter/X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="#" class="social-icon" aria-label="TikTok">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="text-sm font-semibold text-surface-900 dark:text-white uppercase tracking-wider mb-4">Menu</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('products.index') }}" class="footer-link">Produk</a></li>
                    <li><a href="{{ route('articles.index') }}" class="footer-link">Artikel</a></li>
                    <li><a href="{{ route('compare.index') }}" class="footer-link">Bandingkan</a></li>
                    <li><a href="{{ route('membership.index') }}" class="footer-link">Premium</a></li>
                </ul>
            </div>

            {{-- Kategori --}}
            <div>
                <h4 class="text-sm font-semibold text-surface-900 dark:text-white uppercase tracking-wider mb-4">Kategori</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('products.index', ['category' => 'laptop']) }}" class="footer-link">Laptop</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'smartphone']) }}" class="footer-link">Smartphone</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'audio']) }}" class="footer-link">Audio</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'gaming-gear']) }}" class="footer-link">Gaming Gear</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-sm font-semibold text-surface-900 dark:text-white uppercase tracking-wider mb-4">Newsletter</h4>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-3">Dapatkan update produk terbaik dan promo eksklusif.</p>
                <form class="flex gap-2">
                    <input type="email" placeholder="Email kamu" class="flex-1 rounded-xl border border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-800 px-3 py-2 text-sm text-surface-900 dark:text-white placeholder:text-surface-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-400 transition-all">
                    <button type="submit" class="btn-primary btn-sm px-3">Daftar</button>
                </form>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-12 pt-8 border-t border-surface-200 dark:border-surface-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-surface-500 dark:text-surface-400">
                &copy; {{ date('Y') }} CekDulu. All rights reserved.
            </p>
            <div class="flex items-center gap-6">
                <a href="#" class="text-xs text-surface-400 hover:text-surface-600 dark:hover:text-surface-300 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-xs text-surface-400 hover:text-surface-600 dark:hover:text-surface-300 transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-link {
        font-size: 0.875rem;
        color: var(--color-surface-500);
        transition: color 0.15s ease;
        text-decoration: none;
    }
    .dark .footer-link { color: var(--color-surface-400); }
    .footer-link:hover { color: var(--color-primary-600); }
    .dark .footer-link:hover { color: var(--color-primary-400); }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.75rem;
        color: var(--color-surface-400);
        background-color: var(--color-surface-100);
        transition: all 0.2s ease;
    }
    .dark .social-icon {
        color: var(--color-surface-500);
        background-color: var(--color-surface-800);
    }
    .social-icon:hover {
        color: var(--color-primary-600);
        background-color: var(--color-primary-50);
        transform: translateY(-2px);
    }
    .dark .social-icon:hover {
        color: var(--color-primary-400);
        background-color: rgb(5 150 105 / 0.15);
    }
</style>
