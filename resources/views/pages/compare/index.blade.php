<x-layouts.app title="Bandingkan Produk">

{{-- Header --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500 mb-3">
            <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Beranda</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-surface-700 dark:text-surface-300 font-medium">Bandingkan</span>
        </nav>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Bandingkan Produk</h1>
        <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Pilih hingga 3 produk untuk dibandingkan secara detail.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="compareApp()">

    {{-- Search & Add --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 mb-8">
        <h2 class="text-sm font-bold text-surface-900 dark:text-white mb-4">Tambah Produk</h2>
        <div class="flex gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="searchProducts()"
                       placeholder="Cari produk untuk dibandingkan..."
                       class="input pl-10 py-2.5 text-sm">
                {{-- Dropdown --}}
                <div x-show="searchResults.length > 0 && searchQuery.length > 1"
                     x-transition
                     class="absolute top-full left-0 right-0 mt-1.5 bg-white dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-700 shadow-xl z-20 max-h-64 overflow-y-auto"
                     style="display:none">
                    <template x-for="product in searchResults" :key="product.id">
                        <button @click="addProduct(product)"
                                class="flex items-center gap-3 w-full px-4 py-3 text-left hover:bg-surface-50 dark:hover:bg-surface-800 transition-colors border-b border-surface-100 dark:border-surface-800 last:border-0">
                            <div class="w-10 h-10 rounded-lg bg-surface-100 dark:bg-surface-800 overflow-hidden flex-shrink-0">
                                <img :src="product.thumbnail" :alt="product.name" class="w-full h-full object-cover" x-show="product.thumbnail">
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-surface-800 dark:text-surface-200 truncate" x-text="product.name"></p>
                                <p class="text-xs text-surface-400 dark:text-surface-500" x-text="'Rp ' + product.lowest_price?.toLocaleString('id-ID')"></p>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
            <button @click="clearAll()" x-show="selectedProducts.length > 0"
                    class="btn btn-outline btn-sm shrink-0">
                Hapus Semua
            </button>
        </div>
    </div>

    {{-- Empty State --}}
    <div x-show="selectedProducts.length === 0" class="py-20 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
            <svg class="w-8 h-8 text-surface-300 dark:text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
        </div>
        <h3 class="text-base font-bold text-surface-700 dark:text-surface-300 font-display mb-1">Belum ada produk dipilih</h3>
        <p class="text-sm text-surface-500 dark:text-surface-400">Cari dan tambahkan produk di atas untuk mulai membandingkan.</p>
    </div>

    {{-- Comparison Table --}}
    <div x-show="selectedProducts.length > 0" class="overflow-x-auto">
        <div class="min-w-[640px]">

            {{-- Product Headers --}}
            <div class="grid gap-4 mb-6" :class="'grid-cols-' + (selectedProducts.length + 1)">
                <div></div>
                <template x-for="(product, index) in selectedProducts" :key="product.id">
                    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-4 text-center relative">
                        <button @click="removeProduct(index)"
                                class="absolute top-2 right-2 w-6 h-6 rounded-full bg-surface-100 dark:bg-surface-800 flex items-center justify-center text-surface-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <div class="w-16 h-16 mx-auto rounded-xl bg-surface-100 dark:bg-surface-800 overflow-hidden mb-3">
                            <img :src="product.thumbnail" :alt="product.name" class="w-full h-full object-cover" x-show="product.thumbnail">
                        </div>
                        <p class="text-xs font-semibold text-surface-800 dark:text-surface-200 line-clamp-2 leading-snug" x-text="product.name"></p>
                        <p class="text-sm font-bold text-primary-600 dark:text-primary-400 mt-1.5" x-text="'Rp ' + (product.lowest_price ?? 0).toLocaleString('id-ID')"></p>
                    </div>
                </template>
            </div>

            {{-- Rows --}}
            <div class="space-y-2">
                <template x-for="field in compareFields" :key="field.key">
                    <div class="grid gap-4 items-center" :class="'grid-cols-' + (selectedProducts.length + 1)">
                        <div class="text-xs font-semibold text-surface-500 dark:text-surface-400 uppercase tracking-wider py-3 px-2" x-text="field.label"></div>
                        <template x-for="product in selectedProducts" :key="product.id">
                            <div class="bg-white dark:bg-surface-900 rounded-xl border border-surface-100 dark:border-surface-800 px-4 py-3 text-center">
                                <span class="text-sm text-surface-700 dark:text-surface-300" x-text="getFieldValue(product, field.key) || '—'"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function compareApp() {
    return {
        searchQuery: '',
        searchResults: [],
        selectedProducts: [],
        compareFields: [
            { key: 'worth_it_score', label: 'Worth It Score' },
            { key: 'brand.name', label: 'Brand' },
            { key: 'category.name', label: 'Kategori' },
            { key: 'lowest_price', label: 'Harga Terendah' },
        ],
        async searchProducts() {
            if (this.searchQuery.length < 2) { this.searchResults = []; return; }
            try {
                const res = await fetch(`/api/products/search?q=${encodeURIComponent(this.searchQuery)}`);
                this.searchResults = await res.json();
            } catch(e) { this.searchResults = []; }
        },
        addProduct(product) {
            if (this.selectedProducts.length >= 3) return;
            if (this.selectedProducts.find(p => p.id === product.id)) return;
            this.selectedProducts.push(product);
            this.searchQuery = '';
            this.searchResults = [];
        },
        removeProduct(index) {
            this.selectedProducts.splice(index, 1);
        },
        clearAll() {
            this.selectedProducts = [];
        },
        getFieldValue(product, key) {
            const keys = key.split('.');
            let val = product;
            for (const k of keys) { val = val?.[k]; }
            if (key === 'lowest_price' && val) return 'Rp ' + Number(val).toLocaleString('id-ID');
            return val;
        }
    }
}
</script>
@endpush

</x-layouts.app>
