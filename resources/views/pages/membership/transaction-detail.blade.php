<x-layouts.app title="Detail Transaksi - {{ $transaction->invoice_number }}">

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('membership.transactions') }}" class="inline-flex items-center gap-2 text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    {{-- Status Badge --}}
    <div class="mb-6">
        @php
            $statusConfig = [
                'paid' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-400', 'label' => 'Berhasil'],
                'pending' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-400', 'label' => 'Menunggu Pembayaran'],
                'failed' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400', 'label' => 'Gagal'],
                'cancelled' => ['bg' => 'bg-surface-100 dark:bg-surface-800', 'text' => 'text-surface-600 dark:text-surface-400', 'label' => 'Dibatalkan'],
            ];
            $status = $statusConfig[$transaction->status] ?? $statusConfig['pending'];
        @endphp
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl {{ $status['bg'] }} {{ $status['text'] }} text-sm font-bold">
            @if($transaction->status === 'paid')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @elseif($transaction->status === 'pending')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @elseif($transaction->status === 'failed')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
            {{ $status['label'] }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Transaction Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Payment Simulation Modal (Only for pending transactions) --}}
            @if($transaction->status === 'pending')
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl" x-data="{ showModal: false }">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold mb-1">Simulasi Pembayaran</h3>
                            <p class="text-sm text-indigo-100 mb-4">Klik tombol di bawah untuk mensimulasikan status pembayaran</p>
                            <button @click="showModal = true" class="btn bg-white text-indigo-600 hover:bg-indigo-50 font-semibold shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Buka Simulasi Pembayaran
                            </button>
                        </div>
                    </div>

                    {{-- Modal --}}
                    <div x-show="showModal"
                         x-cloak
                         @click.away="showModal = false"
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <div @click.stop class="bg-white dark:bg-surface-900 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">

                            {{-- Modal Header --}}
                            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 text-white">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold">Payment Simulation</h3>
                                    <button @click="showModal = false" class="text-white/80 hover:text-white transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Modal Body --}}
                            <div class="p-6 space-y-4">
                                {{-- Transaction Info --}}
                                <div class="bg-surface-50 dark:bg-surface-800 rounded-xl p-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-surface-500 dark:text-surface-400">Membership</span>
                                        <span class="font-semibold text-surface-900 dark:text-white">{{ $transaction->membershipPlan->name }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-surface-500 dark:text-surface-400">Harga</span>
                                        <span class="font-semibold text-surface-900 dark:text-white">{{ $transaction->formatted_amount }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-surface-500 dark:text-surface-400">Order ID</span>
                                        <span class="font-mono text-xs font-semibold text-surface-900 dark:text-white">{{ $transaction->invoice_number }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm pt-2 border-t border-surface-200 dark:border-surface-700">
                                        <span class="text-surface-500 dark:text-surface-400">Status</span>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Waiting Payment
                                        </span>
                                    </div>
                                </div>

                                {{-- Fake Payment Gateway UI --}}
                                <div class="border-2 border-dashed border-surface-300 dark:border-surface-700 rounded-xl p-4">
                                    <div class="text-center mb-3">
                                        <div class="inline-flex items-center gap-2 text-sm font-bold text-surface-700 dark:text-surface-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            BANK TRANSFER
                                        </div>
                                    </div>
                                    <div class="bg-surface-100 dark:bg-surface-800 rounded-lg p-3 mb-3">
                                        <p class="text-xs text-surface-500 dark:text-surface-400 mb-1">Virtual Account</p>
                                        <p class="text-lg font-mono font-bold text-surface-900 dark:text-white">8808 1238 1231 23</p>
                                        <p class="text-xs text-surface-600 dark:text-surface-400 mt-1">Bank Mandiri</p>
                                    </div>
                                </div>

                                {{-- Simulation Buttons --}}
                                <div class="space-y-2 pt-2">
                                    <form action="{{ route('membership.simulate.success', $transaction->invoice_number) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full btn bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Simulasikan Pembayaran Berhasil
                                        </button>
                                    </form>

                                    <form action="{{ route('membership.simulate.failed', $transaction->invoice_number) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full btn bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Simulasikan Pembayaran Gagal
                                        </button>
                                    </form>

                                    <button @click="showModal = false" class="w-full btn btn-outline py-3 rounded-xl">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Transaction Info Card --}}
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Detail Transaksi
                </h2>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Invoice Number</span>
                        <span class="text-sm font-mono font-semibold text-surface-900 dark:text-white">{{ $transaction->invoice_number }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Paket</span>
                        <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ $transaction->membershipPlan->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Nominal</span>
                        <span class="text-sm font-bold text-surface-900 dark:text-white">{{ $transaction->formatted_amount }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Metode Pembayaran</span>
                        <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ $transaction->payment_method }}</span>
                    </div>
                    @if($transaction->payment_reference)
                        <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                            <span class="text-sm text-surface-500 dark:text-surface-400">Referensi</span>
                            <span class="text-sm font-mono font-semibold text-surface-900 dark:text-white">{{ $transaction->payment_reference }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                        <span class="text-sm text-surface-500 dark:text-surface-400">Tanggal Dibuat</span>
                        <span class="text-sm font-semibold text-surface-900 dark:text-white">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($transaction->paid_at)
                        <div class="flex justify-between py-2 border-b border-surface-100 dark:border-surface-800">
                            <span class="text-sm text-surface-500 dark:text-surface-400">Tanggal Dibayar</span>
                            <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ $transaction->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Membership Info --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6 shadow-sm">
                <h3 class="text-sm font-bold text-surface-800 dark:text-surface-200 mb-4">Informasi Paket</h3>

                <div class="mb-4">
                    <p class="text-xs text-surface-500 dark:text-surface-400 mb-1">Nama Paket</p>
                    <p class="text-base font-bold text-surface-900 dark:text-white">{{ $transaction->membershipPlan->name }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-xs text-surface-500 dark:text-surface-400 mb-1">Durasi</p>
                    <p class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->membershipPlan->duration_label }}</p>
                </div>

                @if($transaction->membershipPlan->features && count($transaction->membershipPlan->features))
                    <div>
                        <p class="text-xs text-surface-500 dark:text-surface-400 mb-2">Fitur</p>
                        <ul class="space-y-1.5">
                            @foreach($transaction->membershipPlan->features as $feature)
                                <li class="flex items-start gap-2 text-xs text-surface-600 dark:text-surface-400">
                                    <svg class="w-4 h-4 flex-shrink-0 text-emerald-500 mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
