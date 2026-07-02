<x-layouts.app title="Temukan Produk Paling Worth It">

    {{-- ================================================================
         HERO
         ================================================================ --}}
    <section class="relative overflow-hidden bg-white dark:bg-surface-950">
        {{-- Subtle grid background --}}
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#e5e5e5_1px,transparent_1px),linear-gradient(to_bottom,#e5e5e5_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(to_right,#262626_1px,transparent_1px),linear-gradient(to_bottom,#262626_1px,transparent_1px)] opacity-30"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-primary-400/8 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[400px] bg-accent-400/6 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 md:pt-28 md:pb-20 text-center">

            {{-- Eyebrow --}}
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800/50 text-primary-700 dark:text-primary-400 text-xs font-semibold mb-6 animate-fade-in">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                #1 Platform Perbandingan Harga Indonesia
            </div>

            {{-- Heading --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-surface-900 dark:text-white font-display leading-[1.1] tracking-tight max-w-3xl mx-auto animate-slide-up">
                Temukan Produk Paling
                <span class="gradient-text"> Worth It</span>
                <br>untukmu
            </h1>

            {{-- Subtitle --}}
            <p class="mt-5 text-lg text-surface-500 dark:text-surface-400 max-w-xl mx-auto leading-relaxed animate-slide-up" style="animation-delay:0.08s">
                Bandingkan harga, cek review, dan dapatkan rekomendasi produk terbaik dari berbagai marketplace Indonesia.
            </p>

            {{-- Search --}}
            <form action="{{ route('products.index') }}" method="GET"
                  class="mt-8 max-w-2xl mx-auto animate-slide-up" style="animation-delay:0.16s">
                <div class="relative flex items-center bg-white dark:bg-surface-900 rounded-2xl border-2 border-surface-200 dark:border-surface-700 shadow-lg shadow-surface-900/5 dark:shadow-black/20 focus-within:border-primary-400 dark:focus-within:border-primary-600 focus-within:shadow-xl focus-within:shadow-primary-500/8 transition-all duration-200">
                    <div class="pl-5 pr-3 flex-shrink-0">
                        <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input name="search" type="text"
                           placeholder="Cari produk, brand, atau kategori..."
                           class="flex-1 py-4 bg-transparent text-surface-900 dark:text-white placeholder:text-surface-400 text-base focus:outline-none">
                    <div class="p-2 flex-shrink-0">
                        <button type="submit" class="btn btn-primary btn-md rounded-xl px-5">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Quick Chips --}}
            <div class="mt-5 flex flex-wrap justify-center gap-2 animate-slide-up" style="animation-delay:0.24s">
                <a href="{{ route('products.index', ['category' => 'laptop']) }}" class="hero-chip">💻 Laptop</a>
                <a href="{{ route('products.index', ['category' => 'smartphone']) }}" class="hero-chip">📱 Smartphone</a>
                <a href="{{ route('products.index', ['category' => 'mechanical-keyboard']) }}" class="hero-chip">⌨️ Keyboard</a>
                <a href="{{ route('products.index', ['category' => 'audio']) }}" class="hero-chip">🎧 Audio</a>
                <a href="{{ route('products.index', ['category' => 'monitor']) }}" class="hero-chip">🖥️ Monitor</a>
            </div>
        </div>
    </section>

    {{-- ================================================================
         STATS STRIP
         ================================================================ --}}
    <section class="border-y border-surface-200 dark:border-surface-800 bg-surface-50 dark:bg-surface-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">500+</div>
                    <div class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Produk Terkurasi</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">10+</div>
                    <div class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Marketplace</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Real-time</div>
                    <div class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Update Harga</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Gratis</div>
                    <div class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Untuk Semua</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         CATEGORIES
         ================================================================ --}}
    <section class="py-14 md:py-18">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="section-eyebrow mb-1.5">
                        <span class="w-1 h-4 bg-primary-500 rounded-full inline-block"></span>
                        Jelajahi
                    </p>
                    <h2 class="section-title">Kategori Populer</h2>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="flex flex-wrap gap-2.5">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-900 text-surface-700 dark:text-surface-300 font-medium text-sm hover:border-primary-300 dark:hover:border-primary-700 hover:text-primary-700 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/10 hover:-translate-y-0.5 hover:shadow-sm transition-all duration-150 {{ $loop->first ? 'border-primary-300 dark:border-primary-700 text-primary-700 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/10' : '' }}">
                        <span class="text-lg leading-none">{{ $category->icon ?? '📦' }}</span>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================
         WORTH IT PRODUCTS
         ================================================================ --}}
    <section class="py-14 md:py-18 bg-white dark:bg-surface-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="section-eyebrow mb-1.5">
                        <span class="w-1 h-4 bg-primary-500 rounded-full inline-block"></span>
                        Rekomendasi
                    </p>
                    <h2 class="section-title">Produk Paling Worth It</h2>
                    <p class="section-subtitle">Skor tertinggi dari analisis tim CekDulu</p>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="product-grid">
                @forelse($worthProducts as $product)
                    <x-product-card :product="$product"/>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada produk. Tunggu update dari tim kami!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================
         TRENDING PRODUCTS
         ================================================================ --}}
    <section class="py-14 md:py-18">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="section-eyebrow mb-1.5">
                        <span class="w-1 h-4 bg-accent-500 rounded-full inline-block"></span>
                        Trending
                    </p>
                    <h2 class="section-title">Produk Trending</h2>
                    <p class="section-subtitle">Banyak dicari dan dibandingkan minggu ini</p>
                </div>
                <a href="{{ route('products.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="product-grid">
                @forelse($trendingProducts as $product)
                    <x-product-card :product="$product"/>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada produk trending. Stay tuned!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================
         CTA BANNER
         ================================================================ --}}
    <section class="py-14 md:py-18 bg-white dark:bg-surface-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 px-8 py-12 md:px-14 md:py-14 text-center">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:32px_32px]"></div>
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-400/10 rounded-full blur-3xl"></div>
                <div class="relative">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white/90 text-xs font-semibold mb-4">
                        <svg class="w-3.5 h-3.5 text-accent-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        CekDulu Premium
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-white font-display tracking-tight mb-3">
                        Belanja Lebih Cerdas dengan Premium
                    </h2>
                    <p class="text-primary-100 text-sm md:text-base max-w-lg mx-auto mb-7">
                        Price alert, diskon eksklusif, dan analitik mendalam untuk membantu kamu menemukan waktu terbaik membeli.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('membership.index') }}" class="btn btn-xl bg-white text-primary-700 hover:bg-primary-50 shadow-lg shadow-primary-900/20 font-bold">
                            Lihat Paket Premium
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-xl bg-white/10 text-white hover:bg-white/20 border border-white/20">
                            Jelajahi Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         ARTICLES
         ================================================================ --}}
    <section class="py-14 md:py-18">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="section-eyebrow mb-1.5">
                        <span class="w-1 h-4 bg-primary-500 rounded-full inline-block"></span>
                        Konten
                    </p>
                    <h2 class="section-title">Artikel Terbaru</h2>
                    <p class="section-subtitle">Tips, rekomendasi, dan berita seputar produk pilihan</p>
                </div>
                <a href="{{ route('articles.index') }}" class="see-all">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($articles as $article)
                    <x-article-card :article="$article"/>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada artikel. Nantikan konten berkualitas dari kami!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</x-layouts.app>
