<x-layouts.app title="Bandingkan Produk - CekDulu">

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-50 via-white to-amber-50 dark:from-surface-900 dark:via-surface-900 dark:to-surface-800 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-surface-700 dark:text-surface-300 font-medium">Bandingkan</span>
        </nav>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display">Bandingkan Produk</h1>
        <p class="mt-2 text-surface-500 dark:text-surface-400 text-sm lg:text-base max-w-xl">
            Bandingkan harga, rating, dan Worth It Score untuk menemukan produk terbaik buat kamu.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">

    {{-- Product Overview Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($products as $product)
            @php
                $bestPrice = $product->bestPrice();
                $score = $product->worth_it_score ?? 0;
                $scoreColor = $score >= 75 ? 'from-emerald-500 to-emerald-600' : ($score >= 50 ? 'from-amber-500 to-amber-600' : 'from-red-500 to-red-600');
                $isBest = $score == $products->max('worth_it_score');
            @endphp
            <a href="{{ route('products.show', $product) }}"
               class="group relative bg-white dark:bg-surface-900 rounded-2xl border-2 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 overflow-hidden
                      {{ $isBest ? 'border-primary-400 dark:border-primary-600 shadow-md shadow-primary-100 dark:shadow-primary-900/20' : 'border-surface-200 dark:border-surface-800' }}">
                {{-- Best Value Badge --}}
                @if($isBest)
                    <div class="absolute top-3 left-3 z-10 bg-gradient-to-r from-amber-400 to-amber-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        TERBAIK
                    </div>
                @endif

                {{-- Product Image --}}
                <div class="aspect-[4/3] bg-surface-50 dark:bg-surface-800 overflow-hidden">
                    @if($product->thumbnail)
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy"
                             x-on:error="$el.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23f3f4f6%22 width=%22400%22 height=%22300%22/><text x=%22200%22 y=%22150%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2256%22>📦</text></svg>'">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-5xl opacity-20">📦</span>
                        </div>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        {{ $product->name }}
                    </h3>

                    {{-- Score Badge --}}
                    <div class="mt-2 inline-flex items-center gap-1.5 bg-gradient-to-r {{ $scoreColor }} text-white text-xs font-bold px-2.5 py-1 rounded-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        {{ $score }}
                    </div>

                    {{-- Best Price --}}
                    @if($bestPrice)
                        <div class="mt-2 flex items-baseline gap-1.5">
                            <span class="text-xs text-surface-400 dark:text-surface-500">Mulai</span>
                            <span class="text-sm font-extrabold text-surface-900 dark:text-white">Rp {{ number_format($bestPrice->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[10px] text-surface-400 dark:text-surface-500 mt-0.5">di {{ $bestPrice->marketplace->name }}</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    {{-- Empty State --}}
    @if($products->isEmpty())
        <div class="text-center py-20">
            <div class="w-20 h-20 mx-auto mb-4 bg-surface-100 dark:bg-surface-800 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
            </div>
            <h3 class="text-lg font-bold text-surface-800 dark:text-surface-200">Belum ada produk untuk dibandingkan</h3>
            <p class="text-surface-500 dark:text-surface-400 text-sm mt-1 mb-6">Tambahkan produk dari halaman produk untuk memulai perbandingan.</p>
            <a href="{{ route('products.index') }}" class="btn-primary text-sm px-6 py-3 rounded-xl inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Jelajahi Produk
            </a>
        </div>
    @else
        {{-- Comparison Table --}}
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm" x-data="{ scrolled: false }" @scroll.window="scrolled = ($el.getBoundingClientRect().top < 80)">
            {{-- Sticky Header --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px]">
                    {{-- Column Headers --}}
                    <thead>
                        <tr class="border-b border-surface-200 dark:border-surface-800">
                            <th class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-4 text-left text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wider w-[140px] min-w-[140px]">
                                Aspek
                            </th>
                            @foreach($products as $product)
                                @php $isBestOverall = $product->worth_it_score == $products->max('worth_it_score'); @endphp
                                <th class="px-5 py-4 text-center {{ $isBestOverall ? 'bg-primary-50/50 dark:bg-primary-900/10' : '' }}">
                                    <span class="text-sm font-bold text-surface-900 dark:text-white">{{ $product->name }}</span>
                                    @if($isBestOverall)
                                        <span class="ml-2 inline-flex items-center gap-0.5 text-[10px] text-amber-600 dark:text-amber-400 font-bold bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            Terbaik
                                        </span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-800">

                        {{-- Worth It Score --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    Worth It Score
                                </div>
                            </td>
                            @foreach($products as $product)
                                @php
                                    $s = $product->worth_it_score ?? 0;
                                    $sBar = $s >= 75 ? 'bg-emerald-500' : ($s >= 50 ? 'bg-amber-500' : 'bg-red-500');
                                    $isBest = $s == $products->max('worth_it_score');
                                @endphp
                                <td class="px-5 py-3.5 {{ $isBest ? 'bg-primary-50/30 dark:bg-primary-900/5' : '' }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-lg font-extrabold text-surface-900 dark:text-white font-display">{{ $s }}</span>
                                        <span class="text-xs text-surface-400">/100</span>
                                    </div>
                                    <div class="mt-1.5 w-full max-w-[120px] mx-auto h-1.5 bg-surface-200 dark:bg-surface-700 rounded-full overflow-hidden">
                                        <div class="h-full {{ $sBar }} rounded-full transition-all duration-700" style="width: {{ $s }}%"></div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Best Price --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Harga Terbaik
                                </div>
                            </td>
                            @foreach($products as $product)
                                @php
                                    $bp = $product->bestPrice();
                                    $prices = $product->prices->pluck('price');
                                    $isCheapest = $bp && $bp->price == $products->pluck('bestPrice')->filter()->pluck('price')->min();
                                @endphp
                                <td class="px-5 py-3.5 {{ $isCheapest ? 'bg-emerald-50/30 dark:bg-emerald-900/5' : '' }}">
                                    <div class="text-center">
                                        <span class="text-sm font-extrabold {{ $isCheapest ? 'text-emerald-600 dark:text-emerald-400' : 'text-surface-900 dark:text-white' }}">
                                            {{ $bp ? 'Rp ' . number_format($bp->price, 0, ',', '.') : '-' }}
                                        </span>
                                        @if($isCheapest && $bp)
                                            <span class="ml-1.5 inline-flex text-[10px] text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-100 dark:bg-emerald-900/30 px-1.5 py-0.5 rounded-full">TERMURAH</span>
                                        @endif
                                    </div>
                                    @if($bp)
                                        <p class="text-[10px] text-surface-400 dark:text-surface-500 text-center mt-0.5">di {{ $bp->marketplace->name }}</p>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Marketplace --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    Marketplace
                                </div>
                            </td>
                            @foreach($products as $product)
                                <td class="px-5 py-3.5">
                                    <div class="flex flex-wrap justify-center gap-1.5">
                                        @foreach($product->prices->unique('marketplace_id') as $price)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-400 rounded-full text-[10px] font-medium">
                                                {{ strtoupper(substr($price->marketplace->name, 0, 2)) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Rating --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Rating
                                </div>
                            </td>
                            @foreach($products as $product)
                                @php
                                    $avgRating = $product->prices->avg('rating') ?? 0;
                                    $bestRating = $products->pluck('prices')->map->avg('rating')->max();
                                @endphp
                                <td class="px-5 py-3.5 {{ $avgRating == $bestRating && $avgRating > 0 ? 'bg-amber-50/30 dark:bg-amber-900/5' : '' }}">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span class="text-sm font-bold {{ $avgRating == $bestRating && $avgRating > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-surface-900 dark:text-white' }}">
                                            ⭐ {{ number_format($avgRating, 1) }}
                                        </span>
                                    </div>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Total Sold --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    Total Terjual
                                </div>
                            </td>
                            @foreach($products as $product)
                                @php $totalSold = $product->prices->sum('sold_count') ?? 0; @endphp
                                <td class="px-5 py-3.5 text-center">
                                    <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ number_format($totalSold, 0, ',', '.') }}</span>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Brand --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Brand
                                </div>
                            </td>
                            @foreach($products as $product)
                                <td class="px-5 py-3.5 text-center">
                                    <span class="text-sm text-surface-600 dark:text-surface-400">{{ $product->brand?->name ?? '-' }}</span>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Category --}}
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-800/30 transition-colors">
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-3.5 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    Kategori
                                </div>
                            </td>
                            @foreach($products as $product)
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex px-2.5 py-0.5 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 rounded-full text-xs font-medium">
                                        {{ $product->category?->name ?? '-' }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>

                        {{-- Actions --}}
                        <tr>
                            <td class="sticky left-0 z-10 bg-white dark:bg-surface-900 px-5 py-4 text-sm font-semibold text-surface-700 dark:text-surface-300">
                                Aksi
                            </td>
                            @foreach($products as $product)
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn-primary text-xs px-4 py-2 rounded-lg inline-flex items-center gap-1.5">
                                        Lihat Detail
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Want to compare more? --}}
        <div class="mt-8 text-center">
            <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mau bandingkan produk lain?</p>
            <a href="{{ route('products.index') }}" class="btn-secondary text-sm px-6 py-3 rounded-xl inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Produk
            </a>
        </div>
    @endif
</div>

</x-layouts.app>
