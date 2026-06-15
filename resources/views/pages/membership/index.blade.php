<x-layouts.app title="Membership Premium - CekDulu">

{{-- Page Header with Gradient --}}
<div class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-600 to-primary-800 dark:from-surface-900 dark:via-surface-900 dark:to-surface-800">
    {{-- Decorative Blobs --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 animate-float"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4 animate-float" style="animation-delay: 2s;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/15 backdrop-blur-sm text-white/90 text-xs font-semibold rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            CekDulu Premium
        </div>
        <h1 class="text-3xl lg:text-4xl font-extrabold text-white font-display">
            Upgrade Pengalaman CekDulu Kamu
        </h1>
        <p class="mt-4 text-primary-100 text-sm lg:text-base max-w-2xl mx-auto">
            Dapatkan akses ke fitur eksklusif, price alert, dan insight mendalam untuk membantu kamu belanja lebih cerdas.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

    {{-- Plans Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        @forelse($plans as $plan)
            @php
                $isPopular = $plan->duration_days >= 30 && $plan->duration_days < 365;
                $isBestValue = $plan->duration_days >= 365;
            @endphp
            <div class="group relative bg-white dark:bg-surface-900 rounded-2xl border-2 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 overflow-hidden flex flex-col
                        {{ $isPopular ? 'border-primary-400 dark:border-primary-600 shadow-md shadow-primary-100 dark:shadow-primary-900/20' : ($isBestValue ? 'border-amber-400 dark:border-amber-600 shadow-lg shadow-amber-100 dark:shadow-amber-900/20' : 'border-surface-200 dark:border-surface-800 hover:border-surface-400 dark:hover:border-surface-700') }}">

                {{-- Popular / Best Value Badge --}}
                @if($isPopular)
                    <div class="absolute top-0 left-0 right-0 bg-primary-600 text-white text-center text-xs font-bold py-1.5 tracking-wide">
                        PALING POPULER
                    </div>
                @elseif($isBestValue)
                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-center text-xs font-bold py-1.5 tracking-wide">
                        HEMAT TERBAIK ⭐
                    </div>
                @endif

                {{-- Card Body --}}
                <div class="p-6 lg:p-8 flex flex-col flex-1 {{ ($isPopular || $isBestValue) ? 'pt-10' : '' }}">

                    {{-- Plan Name --}}
                    <h3 class="text-lg font-bold text-surface-900 dark:text-white font-display text-center">{{ $plan->name }}</h3>

                    {{-- Price --}}
                    <div class="mt-4 text-center">
                        <div class="flex items-baseline justify-center gap-1">
                            <span class="text-3xl lg:text-4xl font-extrabold text-surface-900 dark:text-white font-display">{{ $plan->formatted_price }}</span>
                            <span class="text-sm text-surface-500 dark:text-surface-400">/ {{ $plan->duration_label }}</span>
                        </div>
                        @if($plan->price > 0 && $plan->duration_days > 0)
                            @php $dailyPrice = floor($plan->price / $plan->duration_days); @endphp
                            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Rp {{ number_format($dailyPrice, 0, ',', '.') }}/hari</p>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if($plan->description)
                        <p class="mt-4 text-sm text-surface-500 dark:text-surface-400 text-center">{{ $plan->description }}</p>
                    @endif

                    {{-- Features --}}
                    @if($plan->features && count($plan->features))
                        <ul class="mt-6 space-y-3 flex-1">
                            @foreach($plan->features as $feature)
                                <li class="flex items-start gap-2.5 text-sm text-surface-700 dark:text-surface-300">
                                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- CTA Button --}}
                    <div class="mt-6">
                        @auth
                            <a href="{{ route('membership.checkout', $plan->slug) }}"
                               class="block text-center py-3 rounded-xl font-semibold text-sm transition-all duration-200 transform hover:-translate-y-0.5
                                      {{ $isBestValue ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white hover:shadow-lg hover:shadow-amber-200 dark:hover:shadow-amber-900/30' : ($isPopular ? 'bg-primary-600 text-white hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-200 dark:hover:shadow-primary-900/30' : 'bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700') }}">
                                Beli Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="block text-center py-3 rounded-xl font-semibold text-sm transition-all duration-200 transform hover:-translate-y-0.5
                                      {{ $isBestValue ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white hover:shadow-lg hover:shadow-amber-200 dark:hover:shadow-amber-900/30' : ($isPopular ? 'bg-primary-600 text-white hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-200 dark:hover:shadow-primary-900/30' : 'bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700') }}">
                                Masuk untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 bg-surface-100 dark:bg-surface-800 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-surface-800 dark:text-surface-200">Belum ada paket tersedia</h3>
                <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Silakan cek lagi nanti untuk paket membership terbaru.</p>
            </div>
        @endforelse
    </div>

    {{-- Benefits Section --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl lg:text-3xl font-extrabold text-surface-900 dark:text-white font-display">Kenapa Harus Premium?</h2>
        <p class="mt-2 text-surface-500 dark:text-surface-400">Semua yang kamu butuhkan untuk belanja lebih cerdas.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-16">
        {{-- Benefit 1 --}}
        <div class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300">
            <div class="w-11 h-11 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1.5">Price Alert</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed">Dapatkan notifikasi instan saat harga produk favoritmu turun ke harga yang kamu inginkan.</p>
        </div>

        {{-- Benefit 2 --}}
        <div class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300">
            <div class="w-11 h-11 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1.5">Diskon Eksklusif</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed">Akses kode promo dan penawaran spesial yang hanya tersedia untuk member premium CekDulu.</p>
        </div>

        {{-- Benefit 3 --}}
        <div class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300">
            <div class="w-11 h-11 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1.5">Analitik Mendalam</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed">Lihat tren harga historis dan prediksi untuk membantu kamu memutuskan kapan waktu terbaik membeli.</p>
        </div>

        {{-- Benefit 4 --}}
        <div class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300">
            <div class="w-11 h-11 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <h3 class="font-bold text-surface-900 dark:text-white mb-1.5">Badge Premium</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400 leading-relaxed">Tampilkan lencana "Premium Member" eksklusif di profil dan kontribusi kamu di komunitas CekDulu.</p>
        </div>
    </div>

    {{-- FAQ / Trust Strip --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 lg:p-8 text-center">
        <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Punya pertanyaan? Tim kami siap membantu.</p>
        <a href="#" class="btn-secondary text-sm px-6 py-2.5 rounded-xl inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Hubungi Kami
        </a>
    </div>
</div>

</x-layouts.app>
