<x-layouts.app title="Temukan Produk Paling Worth It">
    {{-- ================================================================
         HERO SECTION
         ================================================================ --}}
    <section class="relative overflow-hidden">
        {{-- Background blobs --}}
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-32 -right-32 w-[500px] h-[500px] bg-primary-400/15 rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-32 -left-32 w-[400px] h-[400px] bg-accent-400/10 rounded-full blur-3xl" style="animation: float 4s ease-in-out infinite 1s"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-200/5 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 lg:py-32 text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 text-sm font-semibold mb-6 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                #1 Platform Perbandingan Harga Indonesia
            </div>

            {{-- Heading --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-surface-900 dark:text-white font-display leading-tight tracking-tight max-w-3xl mx-auto animate-slide-up">
                Temukan Produk Paling <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-primary-500 to-accent-500">
                    Worth It
                </span> untukmu
            </h1>

            {{-- Subtitle --}}
            <p class="mt-5 text-lg text-surface-500 dark:text-surface-400 max-w-xl mx-auto animate-slide-up" style="animation-delay: 0.1s">
                Bandingkan harga, cek review, dan dapatkan rekomendasi produk terbaik dari berbagai marketplace Indonesia.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('products.index') }}" method="GET" class="mt-8 max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.2s">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-surface-400 group-focus-within:text-primary-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        name="search"
                        type="text"
                        placeholder="Cari produk, brand, atau kategori..."
                        class="w-full pl-12 pr-36 py-4 text-base rounded-2xl border-2 border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder:text-surface-400 shadow-lg shadow-surface-200/50 dark:shadow-black/20 focus:outline-none focus:border-primary-400 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all duration-300"
                    >
                    <div class="absolute inset-y-1.5 right-1.5">
                        <button type="submit" class="btn-accent btn-md h-full rounded-xl shadow-md shadow-accent-500/20 hover:shadow-lg hover:shadow-accent-500/30">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Quick Category Chips --}}
            <div class="mt-6 flex flex-wrap justify-center gap-2 animate-slide-up" style="animation-delay: 0.3s">
                <a href="{{ route('products.index', ['category' => 'laptop']) }}" class="hero-chip group">
                    <span class="text-lg group-hover:scale-110 transition-transform duration-200">💻</span>
                    Laptop Gaming
                </a>
                <a href="{{ route('products.index', ['category' => 'mechanical-keyboard']) }}" class="hero-chip group">
                    <span class="text-lg group-hover:scale-110 transition-transform duration-200">⌨️</span>
                    Mechanical Keyboard
                </a>
                <a href="{{ route('products.index', ['category' => 'smartphone']) }}" class="hero-chip group">
                    <span class="text-lg group-hover:scale-110 transition-transform duration-200">📱</span>
                    Smartphone
                </a>
                <a href="{{ route('products.index', ['category' => 'audio']) }}" class="hero-chip group">
                    <span class="text-lg group-hover:scale-110 transition-transform duration-200">🎧</span>
                    Audio
                </a>
                <a href="{{ route('products.index', ['category' => 'monitor']) }}" class="hero-chip group">
                    <span class="text-lg group-hover:scale-110 transition-transform duration-200">🖥️</span>
                    Monitor
                </a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         CATEGORIES SECTION
         ================================================================ --}}
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="section-title">Kategori Populer</h2>
                    <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Jelajahi produk berdasarkan kategori favoritmu</p>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="flex flex-wrap gap-3">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl border-2 border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-700 dark:text-surface-300 font-medium text-sm hover:border-primary-300 dark:hover:border-primary-600 hover:text-primary-700 dark:hover:text-primary-400 hover:shadow-md hover:shadow-primary-500/5 hover:-translate-y-0.5 transition-all duration-200 {{ $loop->first ? 'border-primary-300 dark:border-primary-600 text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 shadow-sm' : '' }}">
                        <span class="text-xl">{{ $category->icon ?? '📦' }}</span>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================
         WORTH IT PRODUCTS SECTION
         ================================================================ --}}
    <section class="py-12 md:py-16 bg-white dark:bg-surface-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="section-title">⭐ Produk Paling Worth It</h2>
                    <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Rekomendasi produk dengan skor tertinggi dari tim CekDulu</p>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="product-grid">
                @forelse($worthProducts as $product)
                    <x-product-card :product="$product"/>
                @empty
                    <div class="col-span-full text-center py-12 text-surface-400">
                        <span class="text-4xl block mb-3">📦</span>
                        <p>Belum ada produk. Tunggu update dari tim kami!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================
         TRENDING PRODUCTS SECTION
         ================================================================ --}}
    <section class="py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="section-title">🔥 Produk Trending</h2>
                    <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Produk yang sedang banyak dicari dan dibandingkan</p>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="product-grid">
                @forelse($trendingProducts as $product)
                    <x-product-card :product="$product"/>
                @empty
                    <div class="col-span-full text-center py-12 text-surface-400">
                        <span class="text-4xl block mb-3">🔥</span>
                        <p>Belum ada produk trending. Stay tuned!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================
         ARTICLES SECTION
         ================================================================ --}}
    <section class="py-12 md:py-16 bg-white dark:bg-surface-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="section-title">📰 Artikel Terbaru</h2>
                    <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Tips, rekomendasi, dan berita seputar produk pilihan</p>
                </div>
                <a href="{{ route('articles.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($articles as $article)
                    <x-article-card :article="$article"/>
                @empty
                    <div class="col-span-full text-center py-12 text-surface-400">
                        <span class="text-4xl block mb-3">📝</span>
                        <p>Belum ada artikel. Nantikan konten berkualitas dari kami!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>

<style>
    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 9999px;
        background-color: white;
        border: 1px solid var(--color-surface-200);
        color: var(--color-surface-600);
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .dark .hero-chip {
        background-color: var(--color-surface-800);
        border-color: var(--color-surface-700);
        color: var(--color-surface-300);
    }
    .hero-chip:hover {
        border-color: var(--color-primary-300);
        color: var(--color-primary-700);
        background-color: var(--color-primary-50);
        box-shadow: 0 4px 12px rgb(5 150 105 / 0.1);
        transform: translateY(-2px);
    }
    .dark .hero-chip:hover {
        border-color: var(--color-primary-500);
        color: var(--color-primary-400);
        background-color: rgb(5 150 105 / 0.1);
    }
</style>
