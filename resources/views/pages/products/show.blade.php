<x-layouts.app :title="$product->name" :description="$product->short_description">

{{-- Breadcrumb --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
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

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Gallery + Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Gallery --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden"
                 x-data="{ activeImage: '{{ $product->thumbnail }}' }">
                {{-- Main Image --}}
                <div class="relative aspect-[16/10] bg-surface-100 dark:bg-surface-800 overflow-hidden">
                    @if($product->thumbnail)
                        <img :src="activeImage" src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                             class="w-full h-full object-contain p-6 transition-opacity duration-200">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    {{-- Score Badge --}}
                    @php
                        $score = $product->worth_it_score ?? 0;
                        $scoreClass = $score >= 75 ? 'bg-emerald-500' : ($score >= 50 ? 'bg-amber-500' : 'bg-red-500');
                        $scoreLabel = $score >= 75 ? 'Worth It!' : ($score >= 50 ? 'Cukup' : 'Review');
                    @endphp
                    <div class="absolute top-4 right-4 {{ $scoreClass }} text-white font-bold rounded-xl px-3.5 py-2 shadow-lg flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span>{{ $score }}</span>
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

                {{-- Thumbnails --}}
                @if($product->images->count() > 0)
                    <div class="flex gap-2 p-4 border-t border-surface-100 dark:border-surface-800 overflow-x-auto">
                        @if($product->thumbnail)
                            <button @click="activeImage = '{{ $product->thumbnail }}'"
                                    class="flex-shrink-0 w-14 h-14 rounded-xl border-2 overflow-hidden transition-all duration-150"
                                    :class="activeImage === '{{ $product->thumbnail }}' ? 'border-primary-500 ring-2 ring-primary-200 dark:ring-primary-800' : 'border-surface-200 dark:border-surface-700 hover:border-surface-400'">
                                <img src="{{ $product->thumbnail }}" alt="Main" class="w-full h-full object-cover">
                            </button>
                        @endif
                        @foreach($product->images as $image)
                            <button @click="activeImage = '{{ $image->image_url }}'"
                                    class="flex-shrink-0 w-14 h-14 rounded-xl border-2 overflow-hidden transition-all duration-150"
                                    :class="activeImage === '{{ $image->image_url }}' ? 'border-primary-500 ring-2 ring-primary-200 dark:ring-primary-800' : 'border-surface-200 dark:border-surface-700 hover:border-surface-400'">
                                <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Title --}}
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-surface-900 dark:text-white font-display tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>
                @if($product->short_description)
                    <p class="mt-2 text-surface-500 dark:text-surface-400 leading-relaxed">{{ $product->short_description }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-2 mt-4">
                    @if($product->brand)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-400 rounded-full text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $product->brand->name }}
                        </span>
                    @endif
                    @if($product->category)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 rounded-full text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            {{ $product->category->name }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Pros & Cons --}}
            @if((!empty($product->pros) && count($product->pros)) || (!empty($product->cons) && count($product->cons)))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(!empty($product->pros) && count($product->pros))
                        <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl p-5">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-emerald-700 dark:text-emerald-400 mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kelebihan
                            </h3>
                            <ul class="space-y-2">
                                @foreach($product->pros as $pro)
                                    <li class="flex items-start gap-2 text-sm text-emerald-800 dark:text-emerald-300">
                                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        {{ $pro }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(!empty($product->cons) && count($product->cons))
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-2xl p-5">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-red-700 dark:text-red-400 mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kekurangan
                            </h3>
                            <ul class="space-y-2">
                                @foreach($product->cons as $con)
                                    <li class="flex items-start gap-2 text-sm text-red-800 dark:text-red-300">
                                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
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
                    <h2 class="text-base font-bold text-surface-900 dark:text-white font-display flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Deskripsi Produk
                    </h2>
                    <div class="text-sm text-surface-600 dark:text-surface-400 leading-relaxed desc-content">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif

            {{-- Specifications --}}
            @if(!empty($product->specifications) && count($product->specifications))
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-surface-100 dark:border-surface-800">
                        <h2 class="text-base font-bold text-surface-900 dark:text-white font-display flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Spesifikasi
                        </h2>
                    </div>
                    <div class="divide-y divide-surface-100 dark:divide-surface-800">
                        @foreach((array)$product->specifications as $spec)
                            <div class="flex px-6 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/40 transition-colors">
                                <span class="w-2/5 text-xs text-surface-500 dark:text-surface-400 font-medium">{{ is_array($spec) ? ($spec['key'] ?? '') : $spec }}</span>
                                <span class="w-3/5 text-xs text-surface-800 dark:text-surface-200">{{ is_array($spec) ? ($spec['value'] ?? '') : '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Price Comparison --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden"
                 x-data="{ showAll: false }">
                <div class="px-6 py-4 border-b border-surface-100 dark:border-surface-800 flex items-center justify-between">
                    <h2 class="text-base font-bold text-surface-900 dark:text-white font-display flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Perbandingan Harga
                    </h2>
                    @if($product->prices->count() > 5)
                        <button @click="showAll = !showAll" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">
                            <span x-show="!showAll">Lihat Semua ({{ $product->prices->count() }})</span>
                            <span x-show="showAll">Sembunyikan</span>
                        </button>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-surface-50 dark:bg-surface-800/50 text-[11px] text-surface-500 dark:text-surface-400 uppercase tracking-wider">
                                <th class="text-left px-5 py-3 font-semibold">Marketplace</th>
                                <th class="text-left px-5 py-3 font-semibold">Harga</th>
                                <th class="text-center px-5 py-3 font-semibold hidden sm:table-cell">Rating</th>
                                <th class="text-center px-5 py-3 font-semibold hidden sm:table-cell">Terjual</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-100 dark:divide-surface-800">
                            @php $cheapestPrice = $product->prices->min('price'); @endphp
                            @foreach($product->prices->sortBy('price') as $index => $price)
                                @php
                                    $affiliate = $price->affiliateLinks->first();
                                    $isCheapest = $price->price == $cheapestPrice;
                                @endphp
                                <tr class="transition-colors hover:bg-surface-50 dark:hover:bg-surface-800/30 {{ $isCheapest ? 'bg-amber-50/40 dark:bg-amber-900/5' : '' }}"
                                    :class="{{ $index >= 5 ? "showAll ? '' : 'hidden'" : "''" }}">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-surface-100 dark:bg-surface-800 flex items-center justify-center text-xs font-bold text-surface-600 dark:text-surface-400 flex-shrink-0">
                                                {{ strtoupper(substr($price->marketplace->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $price->marketplace->name }}</span>
                                                @if($price->seller_name)
                                                    <p class="text-xs text-surface-400 dark:text-surface-500">{{ $price->seller_name }}</p>
                                                @endif
                                            </div>
                                            @if($isCheapest)
                                                <span class="flex-shrink-0 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-full">TERMURAH</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-sm font-bold {{ $isCheapest ? 'text-amber-600 dark:text-amber-400' : 'text-surface-900 dark:text-white' }}">
                                            Rp {{ number_format($price->price, 0, ',', '.') }}
                                        </span>
                                        @if($price->original_price && $price->original_price > $price->price)
                                            <span class="ml-1.5 text-xs text-surface-400 line-through">Rp {{ number_format($price->original_price, 0, ',', '.') }}</span>
                                        @endif
                                        @if($price->discount)
                                            <div class="text-[10px] text-red-500 font-semibold">-{{ round($price->discount) }}%</div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-center hidden sm:table-cell">
                                        <div class="flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-xs text-surface-600 dark:text-surface-400">{{ number_format($price->rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-center hidden sm:table-cell">
                                        <span class="text-xs text-surface-600 dark:text-surface-400">{{ number_format($price->sold_count ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <a href="{{ $affiliate ? route('affiliate.go', $affiliate) : $price->product_url }}"
                                           target="_blank" rel="nofollow noopener"
                                           class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
                                            Beli
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($product->prices->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <svg class="w-10 h-10 mx-auto mb-3 text-surface-300 dark:text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada data harga marketplace</p>
                    </div>
                @endif
            </div>

            {{-- Alternatives --}}
            @if($alternatives->count() > 0)
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
                    <h2 class="text-base font-bold text-surface-900 dark:text-white font-display flex items-center gap-2 mb-5">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
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

        {{-- Right Sidebar --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">

                {{-- Score Card --}}
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
                    <p class="text-[11px] font-bold text-surface-400 dark:text-surface-500 uppercase tracking-widest mb-4">Worth It Score</p>
                    <div class="flex items-center gap-4">
                        <div class="relative w-18 h-18 flex-shrink-0">
                            <svg class="w-18 h-18 -rotate-90" viewBox="0 0 100 100">
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
                            <p class="text-sm font-bold text-surface-900 dark:text-white">
                                {{ $score >= 75 ? 'Worth It!' : ($score >= 50 ? 'Cukup Worth It' : 'Perlu Review') }}
                            </p>
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1 leading-relaxed">
                                {{ $score >= 75 ? 'Sangat direkomendasikan.' : ($score >= 50 ? 'Cukup baik, ada alternatif lebih worth it.' : 'Pertimbangkan alternatif lain.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Best Price Card --}}
                @if($bestPrice)
                    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
                        <p class="text-[11px] font-bold text-surface-400 dark:text-surface-500 uppercase tracking-widest mb-4">Harga Terbaik</p>
                        <div class="mb-4">
                            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">
                                Rp {{ number_format($bestPrice->price, 0, ',', '.') }}
                            </p>
                            @if($bestPrice->original_price && $bestPrice->original_price > $bestPrice->price)
                                <p class="text-xs text-surface-400 line-through mt-0.5">Rp {{ number_format($bestPrice->original_price, 0, ',', '.') }}</p>
                            @endif
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">di <strong class="text-surface-700 dark:text-surface-300">{{ $bestPrice->marketplace->name }}</strong></p>
                        </div>
                        @php $bestAffiliate = $bestPrice->affiliateLinks->first(); @endphp
                        <a href="{{ $bestAffiliate ? route('affiliate.go', $bestAffiliate) : $bestPrice->product_url }}"
                           target="_blank" rel="nofollow noopener"
                           class="btn btn-primary btn-lg w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            Beli di {{ $bestPrice->marketplace->name }}
                        </a>
                    </div>
                @endif

                {{-- Quick Stats --}}
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
                    <p class="text-[11px] font-bold text-surface-400 dark:text-surface-500 uppercase tracking-widest mb-4">Ringkasan</p>
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

                {{-- Share --}}
                @auth
                    <button x-data
                            @click="navigator.clipboard.writeText(window.location.href)"
                            class="btn btn-secondary btn-md w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Bagikan
                    </button>
                @endauth
            </div>
        </aside>
    </div>
</div>

<style>
    .w-18 { width: 4.5rem; }
    .h-18 { height: 4.5rem; }
    [x-cloak] { display: none !important; }
</style>

</x-layouts.app>
