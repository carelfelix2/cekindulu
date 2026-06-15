<x-layouts.app :title="$product->name . ' - CekDulu'" :description="$product->short_description">

{{-- Breadcrumb --}}
<div class="bg-white dark:bg-surface-900 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500">
            <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @if($product->category)
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{ $product->category->name }}</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            @endif
            <span class="text-surface-700 dark:text-surface-300 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Gallery & Details --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Image Gallery --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
                {{-- Main Image --}}
                <div class="relative aspect-[16/10] bg-surface-100 dark:bg-surface-800 overflow-hidden" x-data="{ activeImage: '{{ $product->thumbnail }}' }">
                    @if($product->thumbnail)
                        <img :src="activeImage" src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                             class="w-full h-full object-contain p-4 transition-opacity duration-300"
                             x-on:error="$el.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23f3f4f6%22 width=%22400%22 height=%22300%22/><text x=%22200%22 y=%22150%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2256%22>🛍️</text></svg>'">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-7xl opacity-30">🛍️</span>
                        </div>
                    @endif

                    {{-- Worth It Score Badge --}}
                    @php
                        $score = $product->worth_it_score ?? 0;
                        $scoreColor = $score >= 75 ? 'bg-score-high' : ($score >= 50 ? 'bg-score-mid' : 'bg-score-low');
                        $scoreLabel = $score >= 75 ? 'Worth It!' : ($score >= 50 ? 'Cukup' : 'Review');
                    @endphp
                    <div class="absolute top-4 right-4 {{ $scoreColor }} text-white font-bold rounded-xl px-4 py-2 shadow-lg flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span class="text-sm">{{ $score }}</span>
                        <span class="text-xs opacity-80">{{ $scoreLabel }}</span>
                    </div>

                    {{-- Discount Badge --}}
                    @php $bestPrice = $product->bestPrice(); @endphp
                    @if($bestPrice && $bestPrice->discount)
                        <div class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold rounded-lg px-3 py-1.5 shadow-lg">
                            -{{ round($bestPrice->discount) }}%
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Strip --}}
                @if($product->images->count() > 0)
                    <div class="flex gap-2 p-4 border-t border-surface-200 dark:border-surface-800 overflow-x-auto" x-data="{ activeImage: '{{ $product->thumbnail }}' }">
                        {{-- Main thumbnail --}}
                        @if($product->thumbnail)
                            <button @click="activeImage = '{{ $product->thumbnail }}'"
                                    class="flex-shrink-0 w-16 h-16 rounded-lg border-2 overflow-hidden transition-all duration-200"
                                    :class="activeImage === '{{ $product->thumbnail }}' ? 'border-primary-500 ring-2 ring-primary-200 dark:ring-primary-800' : 'border-surface-200 dark:border-surface-700 hover:border-surface-400'">
                                <img src="{{ $product->thumbnail }}" alt="Main" class="w-full h-full object-cover" loading="lazy">
                            </button>
                        @endif
                        @foreach($product->images as $image)
                            <button @click="activeImage = '{{ $image->image_url }}'"
                                    class="flex-shrink-0 w-16 h-16 rounded-lg border-2 overflow-hidden transition-all duration-200"
                                    :class="activeImage === '{{ $image->image_url }}' ? 'border-primary-500 ring-2 ring-primary-200 dark:ring-primary-800' : 'border-surface-200 dark:border-surface-700 hover:border-surface-400'">
                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy"
                                     x-on:error="$el.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 80 80%22><rect fill=%22%23f3f4f6%22 width=%2280%22 height=%2280%22/><text x=%2240%22 y=%2240%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2224%22>📷</text></svg>'">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Name & Short Description --}}
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-surface-900 dark:text-white font-display">
                    {{ $product->name }}
                </h1>
                @if($product->short_description)
                    <p class="mt-2 text-surface-500 dark:text-surface-400 leading-relaxed">
                        {{ $product->short_description }}
                    </p>
                @endif
                {{-- Brand & Category Tags --}}
                <div class="flex flex-wrap items-center gap-3 mt-4">
                    @if($product->brand)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-400 rounded-full text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $product->brand->name }}
                        </span>
                    @endif
                    @if($product->category)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 rounded-full text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $product->category->name }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Pros & Cons --}}
            @if((!empty($product->pros) && count($product->pros)) || (!empty($product->cons) && count($product->cons)))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Pros --}}
                    @if(!empty($product->pros) && count($product->pros))
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-5">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-emerald-700 dark:text-emerald-400 mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kelebihan
                            </h3>
                            <ul class="space-y-2">
                                @foreach($product->pros as $pro)
                                    <li class="flex items-start gap-2 text-sm text-emerald-800 dark:text-emerald-300">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        {{ $pro }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Cons --}}
                    @if(!empty($product->cons) && count($product->cons))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-5">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-red-700 dark:text-red-400 mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kekurangan
                            </h3>
                            <ul class="space-y-2">
                                @foreach($product->cons as $con)
                                    <li class="flex items-start gap-2 text-sm text-red-800 dark:text-red-300">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        {{ $con }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Description --}}
            @if($product->description)
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Deskripsi Produk
                    </h2>
                    <div class="prose prose-sm max-w-none text-surface-600 dark:text-surface-400 leading-relaxed space-y-3 desc-content">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif

            {{-- Specifications --}}
            @if(!empty($product->specifications) && count($product->specifications))
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-surface-200 dark:border-surface-800">
                        <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Spesifikasi
                        </h2>
                    </div>
                    <div class="divide-y divide-surface-100 dark:divide-surface-800">
                        @foreach((array)$product->specifications as $key => $value)
                            <div class="flex px-6 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <span class="w-1/3 text-sm text-surface-500 dark:text-surface-400 font-medium">{{ $key }}</span>
                                <span class="w-2/3 text-sm text-surface-800 dark:text-surface-200">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Price Comparison Table --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden" x-data="{ showAll: false }">
                <div class="px-6 py-4 border-b border-surface-200 dark:border-surface-800 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Perbandingan Harga Marketplace
                    </h2>
                    @if($product->prices->count() > 5)
                        <button @click="showAll = !showAll" class="text-xs text-primary-600 dark:text-primary-400 hover:underline font-medium">
                            <span x-show="!showAll">Lihat Semua ({{ $product->prices->count() }})</span>
                            <span x-show="showAll">Sembunyikan</span>
                        </button>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-surface-50 dark:bg-surface-800/50 text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wider">
                                <th class="text-left px-6 py-3 font-semibold">Marketplace</th>
                                <th class="text-left px-6 py-3 font-semibold">Harga</th>
                                <th class="text-center px-6 py-3 font-semibold hidden sm:table-cell">Rating</th>
                                <th class="text-center px-6 py-3 font-semibold hidden sm:table-cell">Terjual</th>
                                <th class="text-right px-6 py-3 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100 dark:divide-surface-800">
                            @php $cheapestPrice = $product->prices->min('price'); @endphp
                            @foreach($product->prices->sortBy('price') as $index => $price)
                                @php
                                    $affiliate = $price->affiliateLinks->first();
                                    $isCheapest = $price->price == $cheapestPrice;
                                    $rowClass = $index >= 5 ? 'x-cloak hidden' : '';
                                @endphp
                                <tr class="transition-colors hover:bg-surface-50 dark:hover:bg-surface-800/30 {{ $isCheapest ? 'bg-amber-50/50 dark:bg-amber-900/10' : '' }}"
                                    :class="{{ $index >= 5 ? "showAll ? '' : 'hidden'" : "''" }}">
                                    {{-- Marketplace --}}
                                    <td class="px-6 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-surface-100 dark:bg-surface-800 flex items-center justify-center text-sm font-bold text-surface-600 dark:text-surface-400 flex-shrink-0">
                                                {{ strtoupper(substr($price->marketplace->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $price->marketplace->name }}</span>
                                                @if($price->seller_name)
                                                    <p class="text-xs text-surface-400 dark:text-surface-500">{{ $price->seller_name }}</p>
                                                @endif
                                            </div>
                                            @if($isCheapest)
                                                <span class="flex-shrink-0 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-full">TERMURAH</span>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Price --}}
                                    <td class="px-6 py-3.5">
                                        <div>
                                            <span class="text-sm font-bold {{ $isCheapest ? 'text-amber-600 dark:text-amber-400' : 'text-surface-900 dark:text-white' }}">
                                                Rp {{ number_format($price->price, 0, ',', '.') }}
                                            </span>
                                            @if($price->original_price && $price->original_price > $price->price)
                                                <span class="ml-2 text-xs text-surface-400 line-through">
                                                    Rp {{ number_format($price->original_price, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($price->discount)
                                            <span class="text-[10px] text-red-500 font-semibold">-{{ round($price->discount) }}%</span>
                                        @endif
                                    </td>
                                    {{-- Rating --}}
                                    <td class="px-6 py-3.5 text-center hidden sm:table-cell">
                                        <div class="flex items-center justify-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-sm text-surface-600 dark:text-surface-400">{{ number_format($price->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    {{-- Sold --}}
                                    <td class="px-6 py-3.5 text-center hidden sm:table-cell">
                                        <span class="text-sm text-surface-600 dark:text-surface-400">{{ number_format($price->sold_count ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    {{-- Buy Button --}}
                                    <td class="px-6 py-3.5 text-right">
                                        @if($affiliate)
                                            <a href="{{ route('affiliate.go', $affiliate) }}" target="_blank" rel="nofollow noopener"
                                               class="btn-primary text-xs px-4 py-2 rounded-lg inline-flex items-center gap-1.5 shadow-sm hover:shadow-md">
                                                Beli
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        @else
                                            <a href="{{ $price->product_url }}" target="_blank" rel="nofollow noopener"
                                               class="btn-primary text-xs px-4 py-2 rounded-lg inline-flex items-center gap-1.5 shadow-sm hover:shadow-md">
                                                Beli
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($product->prices->isEmpty())
                    <div class="px-6 py-12 text-center text-surface-400 dark:text-surface-600">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <p class="text-sm">Belum ada data harga marketplace</p>
                    </div>
                @endif
            </div>

            {{-- Alternative Products --}}
            @if($alternatives->count() > 0)
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display flex items-center gap-2 mb-5">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Produk Alternatif
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($alternatives as $alternative)
                            <x-product-card :product="$alternative" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Sidebar: Product Info Card --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-24 space-y-5">

                {{-- Worth It Score Card --}}
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wider mb-4">Worth It Score</h3>
                    <div class="flex items-center gap-5">
                        {{-- Circular Score --}}
                        <div class="relative w-20 h-20 flex-shrink-0">
                            <svg class="w-20 h-20 -rotate-90" viewBox="0 0 100 100">
                                <circle class="text-surface-200 dark:text-surface-700" stroke="currentColor" stroke-width="8" fill="none" cx="50" cy="50" r="42"/>
                                <circle class="{{ $score >= 75 ? 'text-emerald-500' : ($score >= 50 ? 'text-amber-500' : 'text-red-500') }}"
                                        stroke="currentColor" stroke-width="8" fill="none" cx="50" cy="50" r="42"
                                        stroke-linecap="round"
                                        stroke-dasharray="{{ 2 * 3.14159 * 42 }}"
                                        stroke-dashoffset="{{ 2 * 3.14159 * 42 * (1 - $score / 100) }}"
                                        style="transition: stroke-dashoffset 1s ease-out;"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xl font-extrabold text-surface-900 dark:text-white font-display">{{ $score }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-surface-900 dark:text-white">
                                {{ $score >= 75 ? 'Worth It!' : ($score >= 50 ? 'Cukup Worth It' : 'Perlu Review') }}
                            </p>
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">
                                {{ $score >= 75 ? 'Produk ini sangat direkomendasikan berdasarkan analisis kami.' : ($score >= 50 ? 'Produk ini cukup baik, tapi ada alternatif yang mungkin lebih worth it.' : 'Skor rendah — kami sarankan mempertimbangkan alternatif lain.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Best Price Card --}}
                @if($bestPrice)
                    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                        <h3 class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wider mb-4">Harga Terbaik</h3>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-lg flex-shrink-0">
                                🏷️
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display">Rp {{ number_format($bestPrice->price, 0, ',', '.') }}</p>
                                @if($bestPrice->original_price && $bestPrice->original_price > $bestPrice->price)
                                    <p class="text-xs text-surface-400 line-through">Rp {{ number_format($bestPrice->original_price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-surface-500 dark:text-surface-400">di <strong>{{ $bestPrice->marketplace->name }}</strong></p>
                        @php $bestAffiliate = $bestPrice->affiliateLinks->first(); @endphp
                        <a href="{{ $bestAffiliate ? route('affiliate.go', $bestAffiliate) : $bestPrice->product_url }}"
                           target="_blank" rel="nofollow noopener"
                           class="btn-primary w-full mt-4 text-sm py-3 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            Beli di {{ $bestPrice->marketplace->name }}
                        </a>
                    </div>
                @endif

                {{-- Quick Stats --}}
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-surface-400 dark:text-surface-500 uppercase tracking-wider mb-4">Ringkasan</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-surface-500 dark:text-surface-400">Marketplace</span>
                            <span class="font-semibold text-surface-800 dark:text-surface-200">{{ $product->prices->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-surface-500 dark:text-surface-400">Rating Tertinggi</span>
                            <span class="font-semibold text-surface-800 dark:text-surface-200 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                {{ number_format($product->prices->max('rating') ?? 0, 1) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-surface-500 dark:text-surface-400">Total Terjual</span>
                            <span class="font-semibold text-surface-800 dark:text-surface-200">{{ number_format($product->prices->sum('sold_count') ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($bestPrice && $bestPrice->discount)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-surface-500 dark:text-surface-400">Diskon</span>
                                <span class="font-semibold text-red-500">-{{ round($bestPrice->discount) }}%</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-2">
                    @auth
                        <button x-data @click="navigator.clipboard.writeText(window.location.href); $dispatch('notify', { type: 'success', message: 'Link berhasil disalin!' })"
                                class="w-full btn-secondary text-sm py-2.5 rounded-xl flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            Bagikan
                        </button>
                    @endauth
                </div>
            </div>
        </aside>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .desc-content p { margin-bottom: 0.75rem; }
    .desc-content p:last-child { margin-bottom: 0; }
    [x-cloak] { display: none !important; }
</style>

</x-layouts.app>
