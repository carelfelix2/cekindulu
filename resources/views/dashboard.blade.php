<x-layouts.app title="Dashboard Member - CekDulu">

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 dark:from-surface-900 dark:via-surface-900 dark:to-surface-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
        <h1 class="text-2xl lg:text-3xl font-extrabold font-display">Dashboard</h1>
        <p class="mt-1 text-primary-100 dark:text-surface-400">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">

    {{-- Membership Status Banner --}}
    @php
        $activeMembership = Auth::user()->activeMembership()->with('membershipPlan')->first();
    @endphp

    @if($activeMembership)
        <div class="relative overflow-hidden bg-gradient-to-r from-amber-50 via-amber-100 to-amber-50 dark:from-amber-900/20 dark:via-amber-900/30 dark:to-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-2xl p-5 lg:p-6 mb-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 bg-amber-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-surface-900 dark:text-white">Premium Member ⭐</h3>
                <p class="text-sm text-surface-600 dark:text-surface-400">
                    Paket <strong>{{ $activeMembership->membershipPlan->name }}</strong> aktif hingga
                    <strong>{{ $activeMembership->ends_at->format('d M Y') }}</strong>
                    @php $remaining = now()->diffInDays($activeMembership->ends_at, false); @endphp
                    @if($remaining <= 7 && $remaining > 0)
                        <span class="ml-1 inline-flex items-center gap-1 text-xs text-red-600 dark:text-red-400 font-semibold bg-red-100 dark:bg-red-900/30 px-2 py-0.5 rounded-full">
                            {{ $remaining }} hari tersisa
                        </span>
                    @endif
                </p>
            </div>
            <a href="{{ route('membership.transactions') }}" class="flex-shrink-0 inline-flex items-center gap-1.5 text-sm font-semibold text-surface-700 dark:text-surface-300 bg-white/70 dark:bg-surface-800/70 hover:bg-white dark:hover:bg-surface-800 px-4 py-2 rounded-xl border border-surface-200 dark:border-surface-700 transition-all">
                Riwayat
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    @else
        <div class="bg-gradient-to-r from-primary-50 to-blue-50 dark:from-primary-900/20 dark:to-blue-900/20 border border-primary-200 dark:border-primary-800 rounded-2xl p-5 lg:p-6 mb-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-surface-900 dark:text-white">Member Gratis</h3>
                <p class="text-sm text-surface-600 dark:text-surface-400">Upgrade ke premium untuk akses fitur eksklusif seperti Price Alert, Diskon Khusus, dan Analitik Harga!</p>
            </div>
            <a href="{{ route('membership.index') }}" class="flex-shrink-0 btn-primary text-sm px-5 py-2.5 rounded-xl inline-flex items-center gap-1.5 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Lihat Paket Premium
            </a>
        </div>
    @endif

    {{-- Dashboard Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        {{-- Profile Card --}}
        <a href="{{ route('profile.edit') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-11 h-11 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1">Profil Saya</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400">{{ Auth::user()->email }}</p>
            <span class="inline-flex items-center gap-1 text-xs text-primary-600 dark:text-primary-400 font-semibold mt-3 group-hover:gap-2 transition-all">
                Kelola Profil
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </a>

        {{-- Transaction History --}}
        <a href="{{ route('membership.transactions') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-11 h-11 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1">Riwayat Transaksi</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400">Cek status pembelian membership kamu</p>
            <span class="inline-flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400 font-semibold mt-3 group-hover:gap-2 transition-all">
                Lihat Transaksi
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </a>

        {{-- Browse Products --}}
        <a href="{{ route('products.index') }}" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-11 h-11 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1">Jelajahi Produk</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400">Cari dan bandingkan produk terbaik</p>
            <span class="inline-flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-3 group-hover:gap-2 transition-all">
                Cari Produk
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </a>

        {{-- Coming Soon Cards --}}
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 opacity-70 hover:opacity-100 transition-opacity cursor-default">
            <div class="w-11 h-11 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1">Produk Favorit</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400">Simpan produk favoritmu</p>
            <span class="inline-block mt-3 px-2 py-0.5 bg-surface-100 dark:bg-surface-800 text-surface-400 text-[10px] font-semibold rounded-full">SEGERA</span>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 opacity-70 hover:opacity-100 transition-opacity cursor-default">
            <div class="w-11 h-11 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1">Riwayat Banding</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400">Lihat perbandingan sebelumnya</p>
            <span class="inline-block mt-3 px-2 py-0.5 bg-surface-100 dark:bg-surface-800 text-surface-400 text-[10px] font-semibold rounded-full">SEGERA</span>
        </div>
    </div>
</div>

</x-layouts.app>
