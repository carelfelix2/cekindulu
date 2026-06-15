@props(['product'])

@php
    $best = $product->bestPrice();
    $score = $product->worth_it_score ?? 0;

    // Determine score color
    if ($score >= 75) {
        $scoreColor = 'score-high';
        $scoreLabel = 'Worth It!';
        $scoreBg = 'bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400';
    } elseif ($score >= 50) {
        $scoreColor = 'score-mid';
        $scoreLabel = 'Cukup';
        $scoreBg = 'bg-accent-100 text-accent-700 dark:bg-accent-900/30 dark:text-accent-400';
    } else {
        $scoreColor = 'score-low';
        $scoreLabel = 'Review';
        $scoreBg = 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
    }

    $discount = null;
    if ($best && $best->original_price && $best->original_price > $best->price) {
        $discount = round((($best->original_price - $best->price) / $best->original_price) * 100);
    }
@endphp

<a href="{{ route('products.show', $product) }}" class="group block card-hover relative overflow-hidden">
    {{-- Discount Badge --}}
    @if($discount)
        <div class="absolute top-3 left-3 z-10">
            <span class="badge bg-red-500 text-white font-bold px-2 py-0.5 text-xs">-{{ $discount }}%</span>
        </div>
    @endif

    {{-- Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-surface-100 dark:bg-surface-800">
        @if($product->thumbnail)
            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                 loading="lazy">
        @else
            <div class="flex items-center justify-center h-full text-5xl text-surface-300 dark:text-surface-600">
                🛍️
            </div>
        @endif

        {{-- Worth It Score Badge --}}
        <div class="absolute top-3 right-3">
            <div class="flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-white/90 dark:bg-surface-800/90 backdrop-blur-sm shadow-sm border border-surface-200/50 dark:border-surface-700/50">
                <span class="text-xs font-bold" style="color: var(--color-{{ $scoreColor }})">{{ $score }}/100</span>
            </div>
        </div>

        {{-- Brand Badge --}}
        @if($product->brand)
            <div class="absolute bottom-3 left-3">
                <span class="badge bg-white/90 dark:bg-surface-800/90 backdrop-blur-sm text-surface-600 dark:text-surface-300 text-xs">
                    {{ $product->brand->name }}
                </span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4">
        {{-- Product Name --}}
        <h3 class="font-semibold text-surface-900 dark:text-white text-sm leading-snug line-clamp-2 mb-2 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">
            {{ $product->name }}
        </h3>

        {{-- Price & Marketplace --}}
        <div class="flex items-end justify-between gap-2">
            <div>
                <div class="text-lg font-bold text-surface-900 dark:text-white">
                    Rp {{ number_format($best?->price ?? $product->lowest_price ?? 0, 0, ',', '.') }}
                </div>
                @if($best?->original_price && $best->original_price > $best->price)
                    <div class="text-xs text-surface-400 line-through">
                        Rp {{ number_format($best->original_price, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            @if($best?->marketplace)
                <span class="text-xs text-surface-500 dark:text-surface-400 flex items-center gap-1">
                    <span class="w-4 h-4 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-[10px]">
                        {{ substr($best->marketplace->name, 0, 1) }}
                    </span>
                    {{ $best->marketplace->name }}
                </span>
            @endif
        </div>

        {{-- Worth It Score Progress Bar --}}
        <div class="mt-3 flex items-center gap-2">
            <div class="flex-1 h-1.5 bg-surface-200 dark:bg-surface-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500"
                     style="width: {{ $score }}%; background-color: var(--color-{{ $scoreColor }})"></div>
            </div>
            <span class="text-[11px] font-semibold" style="color: var(--color-{{ $scoreColor }})">{{ $scoreLabel }}</span>
        </div>

        {{-- "Lihat Detail" hover overlay --}}
        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-primary-600 dark:text-primary-400">
                Lihat Detail
                <svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
