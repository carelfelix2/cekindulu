<x-layouts.app title="Dashboard">

{{-- Header --}}
<div class="bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Dashboard</h1>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Halo, <span class="font-semibold text-surface-700 dark:text-surface-300">{{ Auth::user()->name }}</span>!</p>
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
    @php $activeMembership = Auth::user()->activeMembership; @endphp

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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Produk Dilihat</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">0</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Belum ada aktivitas</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-accent-50 dark:bg-accent-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Perbandingan</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">0</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Produk dibandingkan</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Total Diskon</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Rp 0</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Dari harga normal</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Price Alert</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">0</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Aktif</p>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
        <h3 class="font-bold text-surface-900 dark:text-white font-display text-sm mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Aktivitas Terbaru
        </h3>
        <div class="py-10 text-center">
            <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                <svg class="w-6 h-6 text-surface-300 dark:text-surface-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-sm text-surface-500 dark:text-surface-400">Belum ada aktivitas. Mulai jelajahi produk!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm mt-4">Jelajahi Produk</a>
        </div>
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
        <a href="{{ route('membership.transactions') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-accent-50 dark:bg-accent-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Riwayat Transaksi</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Lihat status pembayaran Premium</p>
            </div>
        </a>
    </div>
</div>

</x-layouts.app>
