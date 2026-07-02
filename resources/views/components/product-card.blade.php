@props(['product'])

@php
    $best  = $product->bestPrice();
    $score = $product->worth_it_score ?? 0;

    if ($score >= 75) {
        $scoreColor = 'text-score-high';
        $scoreLabel = 'Worth It!';
        $scoreBg    = 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400';
        $barColor   = 'bg-score-high';
    } elseif ($score >= 50) {
        $scoreColor = 'text-score-mid';
        $scoreLabel = 'Cukup';
        $scoreBg    = 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400';
        $barColor   = 'bg-score-mid';
    } else {
        $scoreColor = 'text-score-low';
        $scoreLabel = 'Review';
        $scoreBg    = 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400';
        $barColor   = 'bg-score-low';
    }

    $discount = null;
    if ($best && $best->original_price && $best->original_price > $best->price) {
        $discount = round((($best->original_price - $best->price) / $best->original_price) * 100);
    }
@endphp

<a href="{{ route('products.show', $product) }}"
   class="group block bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden transition-all duration-250 hover:shadow-lg hover:shadow-surface-900/6 dark:hover:shadow-black/20 hover:-translate-y-1 hover:border-surface-300 dark:hover:border-surface-700">

    {{-- Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-surface-100 dark:bg-surface-800">
        @if($product->thumbnail)
            <img src="{{ $product->thumbnail }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-[1.04] transition-transform duration-500 ease-out"
                 loading="lazy">
        @else
            <div class="flex items-center justify-center h-full">
                <svg class="w-16 h-16 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif

        {{-- Discount Badge --}}
        @if($discount)
            <div class="absolute top-3 left-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-red-500 text-white text-[11px] font-bold tracking-wide shadow-sm">
                    -{{ $discount }}%
                </span>
            </div>
        @endif

        {{-- Score Badge --}}
        <div class="absolute top-3 right-3">
            <div class="flex items-center gap-1 px-2 py-1 rounded-lg bg-white/90 dark:bg-surface-900/90 backdrop-blur-sm shadow-sm border border-surface-200/60 dark:border-surface-700/60">
                <span class="text-[11px] font-bold {{ $scoreColor }}">{{ $score }}</span>
                <span class="text-[10px] text-surface-400 dark:text-surface-500">/100</span>
            </div>
        </div>

        {{-- Brand Badge --}}
        @if($product->brand)
            <div class="absolute bottom-3 left-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-white/90 dark:bg-surface-900/90 backdrop-blur-sm text-surface-600 dark:text-surface-300 text-[11px] font-medium border border-surface-200/60 dark:border-surface-700/60">
                    {{ $product->brand->name }}
                </span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4">
        {{-- Name --}}
        <h3 class="font-semibold text-surface-900 dark:text-white text-sm leading-snug line-clamp-2 mb-3 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors duration-150">
            {{ $product->name }}
        </h3>

        {{-- Price Row --}}
        <div class="flex items-end justify-between gap-2 mb-3">
            <div>
                <div class="text-base font-bold text-surface-900 dark:text-white tracking-tight">
                    Rp {{ number_format($best?->price ?? $product->lowest_price ?? 0, 0, ',', '.') }}
                </div>
                @if($best?->original_price && $best->original_price > $best->price)
                    <div class="text-xs text-surface-400 line-through mt-0.5">
                        Rp {{ number_format($best->original_price, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            @if($best?->marketplace)
                <span class="text-[11px] text-surface-400 dark:text-surface-500 shrink-0">
                    {{ $best->marketplace->name }}
                </span>
            @endif
        </div>

        {{-- Score Bar --}}
        <div class="flex items-center gap-2">
            <div class="flex-1 h-1 bg-surface-100 dark:bg-surface-800 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-700 {{ $barColor }}"
                     style="width: {{ $score }}%"></div>
            </div>
            <span class="text-[11px] font-semibold {{ $scoreColor }} shrink-0">{{ $scoreLabel }}</span>
        </div>
    </div>
</a>
