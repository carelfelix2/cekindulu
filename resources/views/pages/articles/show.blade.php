<x-layouts.app :title="$article->title" :description="Str::limit(strip_tags($article->content), 160)">

{{-- Breadcrumb --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500">
            <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('articles.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Artikel</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-surface-700 dark:text-surface-300 font-medium truncate max-w-[200px]">{{ $article->title }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- Article Content --}}
        <article class="lg:col-span-2">
            {{-- Featured Image --}}
            @if($article->featured_image)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-surface-100 dark:bg-surface-800 mb-8">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Meta --}}
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="inline-block text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-full">
                    Rekomendasi
                </span>
                <span class="text-xs text-surface-400 dark:text-surface-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $article->published_at?->format('d M Y') }}
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight leading-tight mb-6">
                {{ $article->title }}
            </h1>

            {{-- Content --}}
            <div class="prose prose-sm max-w-none text-surface-700 dark:text-surface-300
                        prose-headings:font-display prose-headings:text-surface-900 dark:prose-headings:text-white
                        prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-md
                        prose-code:bg-surface-100 dark:prose-code:bg-surface-800 prose-code:rounded prose-code:px-1.5 prose-code:py-0.5 prose-code:text-xs
                        prose-blockquote:border-primary-400 prose-blockquote:bg-primary-50 dark:prose-blockquote:bg-primary-900/10 prose-blockquote:rounded-r-xl prose-blockquote:py-1">
                {!! $article->content !!}
            </div>

            {{-- Related Products --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-10 pt-8 border-t border-surface-200 dark:border-surface-800">
                    <h2 class="text-base font-bold text-surface-900 dark:text-white font-display mb-5">Produk Terkait</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($relatedProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        {{-- Sidebar --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-24 space-y-5">
                {{-- Related Articles --}}
                @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
                        <h3 class="text-sm font-bold text-surface-900 dark:text-white font-display mb-4">Artikel Terkait</h3>
                        <div class="space-y-4">
                            @foreach($relatedArticles as $related)
                                <a href="{{ route('articles.show', $related) }}" class="flex gap-3 group">
                                    @if($related->featured_image)
                                        <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-surface-100 dark:bg-surface-800">
                                            <img src="{{ $related->featured_image }}" alt="{{ $related->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-surface-800 dark:text-surface-200 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-snug">
                                            {{ $related->title }}
                                        </p>
                                        <p class="text-[11px] text-surface-400 dark:text-surface-500 mt-1">{{ $related->published_at?->format('d M Y') }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-5 text-white">
                    <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center mb-3">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="font-bold text-sm mb-1.5">Upgrade ke Premium</h3>
                    <p class="text-xs text-primary-100 leading-relaxed mb-4">Dapatkan akses ke semua fitur eksklusif dan analitik mendalam.</p>
                    <a href="{{ route('membership.index') }}" class="btn btn-sm bg-white text-primary-700 hover:bg-primary-50 w-full justify-center font-bold">
                        Lihat Paket
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

</x-layouts.app>
