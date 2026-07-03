<x-layouts.app title="Checkout - {{ $plan->name }} - CekDulu">

{{-- Page Header --}}
<div class="bg-white dark:bg-surface-900 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav class="flex items-center gap-2 text-xs text-surface-400 dark:text-surface-500 mb-3">
            <a href="{{ route('membership.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Membership</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-surface-700 dark:text-surface-300 font-medium">Checkout</span>
        </nav>
        <h1 class="text-xl lg:text-2xl font-extrabold text-surface-900 dark:text-white font-display">Checkout</h1>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Selesaikan pembayaran untuk paket <strong>{{ $plan->name }}</strong></p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">

        {{-- Left: Order Summary --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 lg:p-8 shadow-sm">
                <h2 class="text-lg font-bold text-surface-900 dark:text-white font-display flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Ringkasan Pesanan
                </h2>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-surface-500 dark:text-surface-400">Paket</span>
                        <span class="font-semibold text-surface-800 dark:text-surface-200">{{ $plan->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-surface-500 dark:text-surface-400">Durasi</span>
                        <span class="font-semibold text-surface-800 dark:text-surface-200">{{ $plan->duration_label }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-surface-500 dark:text-surface-400">Harga</span>
                        <span class="font-semibold text-surface-800 dark:text-surface-200">{{ $plan->formatted_price }}</span>
                    </div>
                    <div class="border-t border-surface-200 dark:border-surface-800 pt-3 flex justify-between">
                        <span class="font-bold text-surface-900 dark:text-white">Total</span>
                        <span class="font-extrabold text-lg text-primary-600 dark:text-primary-400">{{ $plan->formatted_price }}</span>
                    </div>
                </div>
            </div>

            {{-- Features Included --}}
            @if($plan->features && count($plan->features))
                <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-surface-800 dark:text-surface-200 mb-4">Fitur yang Didapatkan</h3>
                    <ul class="space-y-2.5">
                        @foreach($plan->features as $feature)
                            <li class="flex items-start gap-2.5 text-sm text-surface-600 dark:text-surface-400">
                                <svg class="w-5 h-5 flex-shrink-0 text-emerald-500 mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Right: Demo Notice & Checkout Button --}}
        <div class="lg:col-span-3 space-y-5">
            {{-- Demo Notice --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2">Mode Demo - Payment Simulation</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed mb-3">
                            Ini adalah aplikasi demo untuk tugas kuliah. Tidak ada pembayaran sungguhan yang akan diproses.
                            Anda akan dapat mensimulasikan berbagai status pembayaran untuk melihat alur aplikasi secara lengkap.
                        </p>
                        <div class="bg-white/50 dark:bg-black/20 rounded-lg p-3 space-y-1.5">
                            <p class="text-xs font-semibold text-blue-800 dark:text-blue-200">Setelah checkout, Anda dapat:</p>
                            <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1 ml-4">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Simulasikan pembayaran berhasil
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Simulasikan pembayaran gagal
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Biarkan status pending
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Checkout Form --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                <h2 class="font-bold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Lanjutkan ke Simulasi Pembayaran
                </h2>

                <form action="{{ route('membership.checkout.process', $plan->slug) }}" method="POST">
                    @csrf

                    <button type="submit"
                            class="btn-primary w-full py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Buat Transaksi & Simulasi Pembayaran
                    </button>
                </form>
            </div>

            {{-- Back Link --}}
            <div class="text-center">
                <a href="{{ route('membership.index') }}" class="text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    ← Kembali ke daftar paket
                </a>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
