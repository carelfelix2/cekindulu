<x-layouts.app title="Artikel & Rekomendasi">

    {{-- Header --}}
    <div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500 mb-3">
                <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-surface-700 dark:text-surface-300 font-medium">Artikel</span>
            </nav>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Artikel & Rekomendasi</h1>
            <p class="mt-1.5 text-sm text-surface-500 dark:text-surface-400 max-w-xl">Tips, panduan, dan rekomendasi untuk membantu kamu belanja lebih cerdas.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
            <div class="mt-10">{{ $articles->links() }}</div>
        @else
            <div class="py-24 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-base font-bold text-surface-700 dark:text-surface-300 font-display mb-1">Belum ada artikel</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400">Artikel dan rekomendasi akan muncul di sini.</p>
            </div>
        @endif
    </div>

</x-layouts.app>
