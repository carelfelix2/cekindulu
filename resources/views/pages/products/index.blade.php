<x-layouts.app>
    <x-slot name="title">Produk - CekDulu</x-slot>

    {{-- Page Header --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-800 dark:to-surface-900">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-accent-400/10 rounded-full blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="flex items-center gap-2 text-sm text-primary-100/70 mb-2">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white">Produk</span>
            </nav>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white font-display tracking-tight">Semua Produk</h1>
            <p class="mt-1 text-primary-100 text-sm">Temukan produk paling worth it untuk kebutuhanmu.</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Filters --}}
            <aside class="lg:w-64 shrink-0">
                <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-surface-200 dark:border-surface-700 p-5 space-y-6 sticky top-24">
                    <h3 class="font-bold text-surface-900 dark:text-white font-display text-lg">Filter</h3>

                    {{-- Categories --}}
                    <div>
                        <h4 class="text-sm font-semibold text-surface-700 dark:text-surface-300 mb-3">Kategori</h4>
                        <div class="space-y-1.5">
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                                   class="block px-3 py-2 rounded-lg text-sm text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-700 hover:text-surface-900 dark:hover:text-white transition-colors
                                          {{ request('category') === $category->slug ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 font-semibold' : '' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brands --}}
                    <div>
                        <h4 class="text-sm font-semibold text-surface-700 dark:text-surface-300 mb-3">Brand</h4>
                        <div class="space-y-1.5 max-h-64 overflow-y-auto">
                            @foreach($brands as $brand)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['brand' => $brand->slug])) }}"
                                   class="block px-3 py-2 rounded-lg text-sm text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-700 hover:text-surface-900 dark:hover:text-white transition-colors
                                          {{ request('brand') === $brand->slug ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 font-semibold' : '' }}">
                                    {{ $brand->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Clear Filters --}}
                    @if(request('category') || request('brand'))
                        <a href="{{ route('products.index') }}" class="block text-center text-sm font-medium text-red-600 dark:text-red-400 hover:underline py-2">
                            Hapus Filter
                        </a>
                    @endif
                </div>
            </aside>

            {{-- Main Content --}}
            <section class="flex-1 min-w-0">
                {{-- Search & Sort Bar --}}
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <form action="{{ route('products.index') }}" method="GET" class="flex-1 relative">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('brand'))
                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                        @endif
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all text-sm">
                        </div>
                    </form>

                    <form method="GET" class="relative">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('brand'))
                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()"
                                class="appearance-none pl-4 pr-10 py-2.5 rounded-xl border border-surface-300 dark:border-surface-700 bg-white dark:bg-surface-800 text-surface-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all cursor-pointer">
                            <option value="worth" {{ !request('sort') || request('sort') === 'worth' ? 'selected' : '' }}>Worth It Score</option>
                            <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                        <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </form>
                </div>

                {{-- Results Count --}}
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-5">
                    Menampilkan <span class="font-semibold text-surface-700 dark:text-surface-300">{{ $products->total() }}</span> produk
                </p>

                {{-- Product Grid --}}
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($products as $product)
                            <x-product-card :product="$product"/>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-surface-100 dark:bg-surface-800 text-surface-400 mb-4">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-surface-700 dark:text-surface-300 font-display">Produk tidak ditemukan</h3>
                        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Coba ubah kata kunci atau filter pencarianmu.</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 text-sm font-semibold text-primary-600 dark:text-primary-400 hover:underline">Hapus semua filter</a>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.app>
