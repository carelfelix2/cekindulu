<x-layouts.app :title="$article->seo_title ?: $article->title" :description="$article->meta_description ?: $article->excerpt">

{{-- Hero with Featured Image --}}
<div class="relative bg-surface-900 dark:bg-black overflow-hidden">
    @if($article->featured_image)
        <div class="absolute inset-0">
            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                 class="w-full h-full object-cover opacity-40"
                 x-on:error="$el.remove()">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-surface-900 via-surface-900/80 to-surface-900/50"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-surface-900"></div>
    @endif

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <nav class="flex items-center gap-2 text-xs text-surface-400 mb-6">
            <a href="{{ route('articles.index') }}" class="hover:text-white transition-colors">Artikel</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-surface-300 font-medium truncate max-w-[250px]">{{ $article->title }}</span>
        </nav>

        <span class="inline-block text-xs font-bold uppercase tracking-wider px-3 py-1 bg-primary-500/20 text-primary-300 rounded-full mb-4">
            Rekomendasi
        </span>

        <h1 class="text-2xl lg:text-4xl font-extrabold text-white font-display leading-tight">
            {{ $article->title }}
        </h1>

        <div class="flex items-center gap-4 mt-6 text-sm text-surface-400">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $article->published_at?->format('d M Y') }}
            </span>
            @if($article->user)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $article->user->name }}
                </span>
            @endif
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-12">

        {{-- Article Content --}}
        <article class="lg:col-span-3">
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 lg:p-10 shadow-sm">
                <div class="prose prose-lg max-w-none dark:prose-invert
                            prose-headings:font-display prose-headings:font-bold prose-headings:text-surface-900 dark:prose-headings:text-white
                            prose-p:text-surface-600 dark:prose-p:text-surface-400 prose-p:leading-relaxed
                            prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-xl prose-img:shadow-md
                            prose-li:text-surface-600 dark:prose-li:text-surface-400
                            prose-strong:text-surface-800 dark:prose-strong:text-surface-200
                            prose-blockquote:border-primary-500 prose-blockquote:bg-primary-50/50 dark:prose-blockquote:bg-primary-900/10 prose-blockquote:rounded-r-xl prose-blockquote:py-1 prose-blockquote:px-4">
                    {!! $article->content !!}
                </div>
            </div>

            {{-- Back Link --}}
            <div class="mt-6">
                <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Kembali ke semua artikel
                </a>
            </div>
        </article>

        {{-- Sidebar: Related Articles --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">
                <h3 class="text-sm font-bold text-surface-800 dark:text-surface-200 uppercase tracking-wider">Artikel Terkait</h3>

                @if($relatedArticles->count() > 0)
                    @foreach($relatedArticles as $related)
                        <a href="{{ route('articles.show', $related) }}"
                           class="group block bg-white dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-800 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                            @if($related->featured_image)
                                <div class="aspect-[16/9] bg-surface-100 dark:bg-surface-800 overflow-hidden">
                                    <img src="{{ $related->featured_image }}" alt="{{ $related->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy"
                                         x-on:error="$el.remove()">
                                </div>
                            @endif
                            <div class="p-3">
                                <h4 class="text-sm font-semibold text-surface-800 dark:text-surface-200 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    {{ $related->title }}
                                </h4>
                                <p class="text-xs text-surface-400 dark:text-surface-500 mt-1.5">
                                    {{ $related->published_at?->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-sm text-surface-400 dark:text-surface-500">Belum ada artikel terkait.</p>
                @endif
            </div>
        </aside>
    </div>
</div>

</x-layouts.app>
