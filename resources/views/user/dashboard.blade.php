<x-layouts.app title="Dashboard">

{{-- Header --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Dashboard</h1>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Halo, <span class="font-semibold text-surface-700 dark:text-surface-300">{{ $user->name }}</span>!</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Edit Profil
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Membership Status --}}
    @if($activeMembership)
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-6 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:24px_24px]"></div>
            <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-base">Premium Aktif</p>
                        <p class="text-sm text-primary-100">Berlaku hingga {{ optional($activeMembership->ends_at)->format('d F Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('membership.transactions') }}" class="btn btn-sm bg-white/15 hover:bg-white/25 text-white border border-white/20">
                    Riwayat Transaksi
                </a>
            </div>
        </div>
    @else
        <div class="bg-surface-100 dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-accent-100 dark:bg-accent-900/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-sm text-surface-800 dark:text-surface-200">Kamu belum berlangganan Premium</p>
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Dapatkan akses ke fitur eksklusif.</p>
                </div>
            </div>
            <a href="{{ route('membership.index') }}" class="btn btn-accent btn-sm">Lihat Paket</a>
        </div>
    @endif

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Total Klik</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_clicks']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Affiliate clicks</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-accent-50 dark:bg-accent-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Transaksi</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_transactions']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Total transaksi</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Poin</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['points']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Reward points</p>
        </div>
    </div>

    {{-- Recent Transactions --}}
    @if($recentTransactions->count() > 0)
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
        <h3 class="font-bold text-surface-900 dark:text-white font-display text-sm mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            Riwayat Transaksi
        </h3>
        <div class="space-y-3">
            @foreach($recentTransactions as $transaction)
            <div class="flex items-center justify-between p-4 rounded-xl bg-surface-50 dark:bg-surface-800/50 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-surface-800 dark:text-surface-200">{{ $transaction->membershipPlan->name }}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">{{ $transaction->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm text-surface-900 dark:text-white">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                    @if($transaction->status === 'paid')
                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Paid</span>
                    @elseif($transaction->status === 'pending')
                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Pending</span>
                    @else
                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">{{ ucfirst($transaction->status) }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('membership.transactions') }}" class="btn btn-outline btn-sm mt-4 w-full">Lihat Semua Transaksi</a>
    </div>
    @endif

    {{-- Recommended Products --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
        <h3 class="font-bold text-surface-900 dark:text-white font-display text-sm mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Produk Rekomendasi
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($recommendedProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="group block bg-surface-50 dark:bg-surface-800/50 rounded-xl p-4 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                @if($product->images->first())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-lg mb-3">
                @else
                    <div class="w-full h-32 bg-surface-200 dark:bg-surface-700 rounded-lg mb-3 flex items-center justify-center">
                        <svg class="w-12 h-12 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                @endif
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">{{ $product->name }}</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">{{ $product->brand->name ?? 'Unknown' }}</p>
                @if($product->lowest_price)
                    <p class="font-bold text-sm text-primary-600 dark:text-primary-400 mt-2">Rp {{ number_format($product->lowest_price, 0, ',', '.') }}</p>
                @endif
            </a>
            @endforeach
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm mt-4 w-full">Jelajahi Semua Produk</a>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('compare.index') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Bandingkan Produk</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Bandingkan hingga 3 produk sekaligus</p>
            </div>
        </a>
        <a href="{{ route('membership.index') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-accent-50 dark:bg-accent-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Upgrade Premium</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Dapatkan fitur eksklusif</p>
            </div>
        </a>
    </div>
</div>

</x-layouts.app>
