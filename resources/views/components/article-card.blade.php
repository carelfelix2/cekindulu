@props(['article'])

<a href="{{ route('articles.show', $article) }}" class="group block bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    {{-- Featured Image --}}
    <div class="aspect-[16/10] bg-surface-100 dark:bg-surface-800 overflow-hidden">
        @if($article->featured_image)
            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 loading="lazy"
                 x-on:error="$el.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 250%22><rect fill=%22%23f3f4f6%22 width=%22400%22 height=%22250%22/><text x=%22200%22 y=%22125%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2248%22>📝</text></svg>'">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <span class="text-5xl opacity-20">📝</span>
            </div>
        @endif
    </div>

    {{-- Card Body --}}
    <div class="p-4 lg:p-5">
        {{-- Tag --}}
        <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-full mb-3">
            Rekomendasi
        </span>

        {{-- Title --}}
        <h3 class="font-bold text-surface-900 dark:text-white text-sm lg:text-base line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-snug">
            {{ $article->title }}
        </h3>

        {{-- Date --}}
        <p class="mt-2 text-xs text-surface-400 dark:text-surface-500 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ $article->published_at?->format('d M Y') }}
        </p>
    </div>
</a>
