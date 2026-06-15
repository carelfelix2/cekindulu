<x-layouts.app title="Detail Transaksi - {{ $transaction->invoice_number }} - CekDulu">

{{-- Page Header --}}
<div class="bg-white dark:bg-surface-900 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <a href="{{ route('membership.transactions') }}" class="inline-flex items-center gap-1.5 text-sm text-surface-500 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Riwayat
        </a>
        <h1 class="text-xl lg:text-2xl font-extrabold text-surface-900 dark:text-white font-display">Detail Transaksi</h1>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 space-y-5">

    {{-- Status Bar --}}
    <div class="rounded-2xl border overflow-hidden shadow-sm
                {{ $transaction->status === 'paid' ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800' : '' }}
                {{ $transaction->status === 'pending' ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800' : '' }}
                {{ $transaction->status === 'failed' ? 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' : '' }}
                {{ in_array($transaction->status, ['expired', 'cancelled']) ? 'bg-surface-50 dark:bg-surface-800/30 border-surface-200 dark:border-surface-700' : '' }}">
        <div class="px-6 py-4 flex items-center justify-between">
            <span class="text-sm font-extrabold uppercase tracking-wide
                         {{ $transaction->status === 'paid' ? 'text-emerald-700 dark:text-emerald-400' : '' }}
                         {{ $transaction->status === 'pending' ? 'text-amber-700 dark:text-amber-400' : '' }}
                         {{ $transaction->status === 'failed' ? 'text-red-700 dark:text-red-400' : '' }}
                         {{ in_array($transaction->status, ['expired', 'cancelled']) ? 'text-surface-500 dark:text-surface-400' : '' }}">
                {{ $transaction->status === 'paid' ? '✅ Lunas' : ucfirst($transaction->status) }}
            </span>
            @if($transaction->paid_at)
                <span class="text-xs text-surface-500 dark:text-surface-400">Lunas pada {{ $transaction->paid_at->format('d M Y, H:i') }}</span>
            @endif
        </div>
    </div>

    {{-- Transaction Info --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
        <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-800">
            <h2 class="font-bold text-surface-900 dark:text-white">Informasi Transaksi</h2>
        </div>
        <div class="p-6 divide-y divide-surface-100 dark:divide-surface-800">
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Invoice</span>
                <span class="text-sm font-mono font-semibold text-surface-800 dark:text-surface-200 select-all">{{ $transaction->invoice_number }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Paket</span>
                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->membershipPlan->name }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Durasi</span>
                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->membershipPlan->duration_label }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Jumlah</span>
                <span class="text-lg font-extrabold text-primary-600 dark:text-primary-400 font-display">{{ $transaction->formatted_amount }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Metode Pembayaran</span>
                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">Transfer Manual (BCA)</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-sm text-surface-500 dark:text-surface-400">Tanggal Transaksi</span>
                <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
            </div>
            @if($transaction->paid_at)
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-surface-500 dark:text-surface-400">Dibayar Pada</span>
                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ $transaction->paid_at->format('d M Y, H:i') }}</span>
                </div>
            @endif
            @if($transaction->expires_at)
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-surface-500 dark:text-surface-400">Batas Pembayaran</span>
                    <span class="text-sm font-semibold {{ $transaction->expires_at->isPast() ? 'text-red-500' : 'text-surface-800 dark:text-surface-200' }}">
                        {{ $transaction->expires_at->format('d M Y, H:i') }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Payment Proof --}}
    @if($transaction->payment_proof)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-800">
                <h2 class="font-bold text-surface-900 dark:text-white">Bukti Pembayaran</h2>
            </div>
            <div class="p-6">
                <div class="rounded-xl overflow-hidden border border-surface-200 dark:border-surface-700 cursor-pointer hover:shadow-lg transition-shadow"
                     x-data @click="window.open($el.querySelector('img').src, '_blank')">
                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                         alt="Bukti Pembayaran"
                         class="w-full h-auto"
                         x-on:error="$el.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 200%22><rect fill=%22%23f3f4f6%22 width=%22400%22 height=%22200%22/><text x=%22200%22 y=%22100%22 text-anchor=%22middle%22 fill=%22%239ca3af%22 font-size=%2218%22>Gambar tidak tersedia</text></svg>'">
                </div>
                <p class="text-xs text-surface-400 dark:text-surface-500 mt-2 text-center">Klik gambar untuk melihat ukuran penuh</p>
            </div>
        </div>
    @endif

    {{-- Admin Notes --}}
    @if($transaction->admin_notes)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-800">
                <h2 class="font-bold text-surface-900 dark:text-white">Catatan Admin</h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-surface-600 dark:text-surface-400 leading-relaxed">{{ $transaction->admin_notes }}</p>
            </div>
        </div>
    @endif

    {{-- Membership Status --}}
    @if($transaction->userMembership)
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-800">
                <h2 class="font-bold text-surface-900 dark:text-white">Status Membership</h2>
            </div>
            <div class="p-6 divide-y divide-surface-100 dark:divide-surface-800">
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-surface-500 dark:text-surface-400">Mulai</span>
                    <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->userMembership->started_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-surface-500 dark:text-surface-400">Berakhir</span>
                    <span class="text-sm font-semibold text-surface-800 dark:text-surface-200">{{ $transaction->userMembership->ends_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-surface-500 dark:text-surface-400">Status</span>
                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold
                                 {{ $transaction->userMembership->isValid() ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-surface-100 dark:bg-surface-800 text-surface-500 dark:text-surface-400' }}">
                        {{ $transaction->userMembership->isValid() ? 'Aktif' : 'Kadaluarsa' }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

</x-layouts.app>
