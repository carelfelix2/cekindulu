<x-layouts.app title="Semua Produk">

    {{-- Page Header --}}
    <div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-surface-700 dark:text-surface-300 font-medium">Produk</span>
            </nav>
            <h1 class="text-2xl md:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Semua Produk</h1>
            <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Temukan produk paling worth it untuk kebutuhanmu.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-7">

            {{-- Sidebar --}}
            <aside class="lg:w-60 shrink-0">
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 space-y-6 sticky top-24">
                    <h3 class="font-bold text-surface-900 dark:text-white text-sm tracking-tight">Filter</h3>

                    {{-- Categories --}}
                    <div>
                        <h4 class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-widest mb-3">Kategori</h4>
                        <div class="space-y-0.5">
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors
                                          {{ request('category') === $category->slug
                                             ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 font-semibold'
                                             : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-white' }}">
                                    {{ $category->name }}
                                    @if(request('category') === $category->slug)
                                        <svg class="w-3.5 h-3.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Brands --}}
                    <div>
                        <h4 class="text-xs font-bold text-surface-500 dark:text-surface-400 uppercase tracking-widest mb-3">Brand</h4>
                        <div class="space-y-0.5 max-h-56 overflow-y-auto">
                            @foreach($brands as $brand)
                                <a href="{{ route('products.index', array_merge(request()->except('page'), ['brand' => $brand->slug])) }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors
                                          {{ request('brand') === $brand->slug
                                             ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 font-semibold'
                                             : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800 hover:text-surface-900 dark:hover:text-white' }}">
                                    {{ $brand->name }}
                                    @if(request('brand') === $brand->slug)
                                        <svg class="w-3.5 h-3.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @if(request('category') || request('brand'))
                        <a href="{{ route('products.index') }}"
                           class="flex items-center gap-1.5 text-xs font-semibold text-red-500 hover:text-red-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Hapus Filter
                        </a>
                    @endif
                </div>
            </aside>

            {{-- Main --}}
            <section class="flex-1 min-w-0">
                {{-- Search & Sort --}}
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <form action="{{ route('products.index') }}" method="GET" class="flex-1">
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                                   class="input pl-10 py-2.5 text-sm">
                        </div>
                    </form>

                    <form method="GET" class="relative shrink-0">
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif
                        <select name="sort" onchange="this.form.submit()"
                                class="input appearance-none pl-4 pr-9 py-2.5 text-sm cursor-pointer">
                            <option value="worth" {{ !request('sort') || request('sort') === 'worth' ? 'selected' : '' }}>Worth It Score</option>
                            <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </form>
                </div>

                {{-- Count --}}
                <p class="text-xs text-surface-500 dark:text-surface-400 mb-5">
                    <span class="font-semibold text-surface-700 dark:text-surface-300">{{ $products->total() }}</span> produk ditemukan
                </p>

                {{-- Grid --}}
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($products as $product)
                            <x-product-card :product="$product"/>
                        @endforeach
                    </div>

                    @if($products->hasPages())
                        <div class="mt-10">{{ $products->links() }}</div>
                    @endif
                @else
                    <div class="py-20 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                            <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-surface-700 dark:text-surface-300 font-display mb-1">Produk tidak ditemukan</h3>
                        <p class="text-sm text-surface-500 dark:text-surface-400 mb-5">Coba ubah kata kunci atau filter pencarianmu.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Hapus semua filter</a>
                    </div>
                @endif
            </section>
        </div>
    </div>

</x-layouts.app>
