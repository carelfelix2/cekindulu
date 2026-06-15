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

        {{-- Right: Payment Instructions & Form --}}
        <div class="lg:col-span-3 space-y-5">
            {{-- Bank Info --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-800">
                    <h2 class="font-bold text-surface-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Transfer Manual
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-surface-100 dark:border-surface-800 last:border-0">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Bank</span>
                        <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">Bank Central Asia (BCA)</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-surface-100 dark:border-surface-800 last:border-0">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Nomor Rekening</span>
                        <span class="text-sm font-mono font-bold text-surface-900 dark:text-white select-all">1234567890</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-surface-100 dark:border-surface-800 last:border-0">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Atas Nama</span>
                        <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">PT CekDulu Indonesia</span>
                    </div>
                    <div class="flex justify-between items-center py-2 bg-amber-50 dark:bg-amber-900/10 -mx-2 px-2 rounded-lg">
                        <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">Total Transfer</span>
                        <span class="text-lg font-extrabold text-amber-600 dark:text-amber-400 font-display">{{ $plan->formatted_price }}</span>
                    </div>
                </div>
            </div>

            {{-- Steps --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-5">
                <h3 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Langkah-langkah
                </h3>
                <ol class="space-y-2 text-sm text-blue-700 dark:text-blue-300">
                    <li class="flex gap-2"><span class="font-bold">1.</span> Transfer sebesar <strong>{{ $plan->formatted_price }}</strong> ke rekening di atas</li>
                    <li class="flex gap-2"><span class="font-bold">2.</span> Simpan bukti transfer (screenshot/foto)</li>
                    <li class="flex gap-2"><span class="font-bold">3.</span> Upload bukti transfer pada form di bawah</li>
                    <li class="flex gap-2"><span class="font-bold">4.</span> Admin akan verifikasi dalam 1x24 jam</li>
                    <li class="flex gap-2"><span class="font-bold">5.</span> Membership aktif otomatis setelah diverifikasi</li>
                </ol>
            </div>

            {{-- Upload Form --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                <h2 class="font-bold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Upload Bukti Transfer
                </h2>

                <form action="{{ route('membership.checkout.process', $plan->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="payment_method" value="manual_transfer">

                    <div class="mb-5">
                        <label for="payment_proof" class="block text-sm font-semibold text-surface-700 dark:text-surface-300 mb-2">
                            Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="payment_proof" id="payment_proof"
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="block w-full text-sm text-surface-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 dark:file:bg-primary-900/30 file:text-primary-700 dark:file:text-primary-400 hover:file:bg-primary-100 dark:hover:file:bg-primary-900/50 file:transition-colors file:cursor-pointer cursor-pointer
                                          border-2 border-dashed border-surface-300 dark:border-surface-700 rounded-xl p-3 hover:border-primary-400 dark:hover:border-primary-600 transition-colors
                                          @error('payment_proof') border-red-300 dark:border-red-700 @enderror"
                                   required>
                        </div>
                        <p class="text-xs text-surface-400 dark:text-surface-500 mt-1.5">Format: JPG/JPEG/PNG, maksimal 2MB</p>
                        @error('payment_proof')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="btn-primary w-full py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kirim Pembayaran
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
