@props(['article'])

<a href="{{ route('articles.show', $article) }}"
   class="group block bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden transition-all duration-250 hover:shadow-lg hover:shadow-surface-900/6 dark:hover:shadow-black/20 hover:-translate-y-1 hover:border-surface-300 dark:hover:border-surface-700">

    {{-- Image --}}
    <div class="aspect-[16/9] bg-surface-100 dark:bg-surface-800 overflow-hidden">
        @if($article->featured_image)
            <img src="{{ $article->featured_image }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover group-hover:scale-[1.04] transition-transform duration-500 ease-out"
                 loading="lazy"
                 x-on:error="$el.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg class=\'w-12 h-12 text-surface-300 dark:text-surface-600\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\' stroke-width=\'1\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z\'/></svg></div>'">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        @endif
    </div>

    {{-- Body --}}
    <div class="p-5">
        <span class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-full mb-3">
            Rekomendasi
        </span>

        <h3 class="font-semibold text-surface-900 dark:text-white text-sm leading-snug line-clamp-2 mb-3 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors duration-150">
            {{ $article->title }}
        </h3>

        <div class="flex items-center justify-between">
            <p class="text-xs text-surface-400 dark:text-surface-500 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $article->published_at?->format('d M Y') }}
            </p>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-primary-600 dark:text-primary-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                Baca
                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </span>
        </div>
    </div>
</a>
