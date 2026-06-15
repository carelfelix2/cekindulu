<x-layouts.app title="Riwayat Transaksi - CekDulu">

{{-- Page Header --}}
<div class="bg-white dark:bg-surface-900 border-b border-surface-200 dark:border-surface-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-xl lg:text-2xl font-extrabold text-surface-900 dark:text-white font-display">Riwayat Transaksi</h1>
        <p class="text-sm text-surface-500 dark:text-surface-400 mt-1">Daftar transaksi membership kamu</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">

    @if($transactions->count() > 0)
        <div class="space-y-3">
            @foreach($transactions as $transaction)
                <a href="{{ route('membership.transactions.detail', $transaction->invoice_number) }}"
                   class="group flex items-center gap-4 bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-4 lg:p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">

                    {{-- Status Icon --}}
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
                                {{ $transaction->status === 'paid' ? 'bg-emerald-100 dark:bg-emerald-900/30' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30' : '' }}
                                {{ $transaction->status === 'failed' ? 'bg-red-100 dark:bg-red-900/30' : '' }}
                                {{ in_array($transaction->status, ['expired', 'cancelled']) ? 'bg-surface-100 dark:bg-surface-800' : '' }}">
                        @if($transaction->status === 'paid')
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @elseif($transaction->status === 'pending')
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($transaction->status === 'failed')
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @else
                            <svg class="w-5 h-5 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-mono text-surface-400 dark:text-surface-500 tracking-wide">{{ $transaction->invoice_number }}</p>
                        <h3 class="font-semibold text-surface-900 dark:text-white truncate">{{ $transaction->membershipPlan->name }}</h3>
                        <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    {{-- Amount & Status --}}
                    <div class="flex-shrink-0 text-right">
                        <p class="font-extrabold text-surface-900 dark:text-white">{{ $transaction->formatted_amount }}</p>
                        <span class="inline-block mt-1 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full
                                     {{ $transaction->status === 'paid' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : '' }}
                                     {{ $transaction->status === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' : '' }}
                                     {{ $transaction->status === 'failed' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : '' }}
                                     {{ in_array($transaction->status, ['expired', 'cancelled']) ? 'bg-surface-100 dark:bg-surface-800 text-surface-500 dark:text-surface-400' : '' }}">
                            {{ $transaction->status === 'paid' ? 'Lunas' : ucfirst($transaction->status) }}
                        </span>
                    </div>

                    {{-- Arrow --}}
                    <svg class="w-5 h-5 text-surface-300 dark:text-surface-600 flex-shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 mx-auto mb-4 bg-surface-100 dark:bg-surface-800 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="text-lg font-bold text-surface-800 dark:text-surface-200">Belum Ada Transaksi</h3>
            <p class="text-surface-500 dark:text-surface-400 text-sm mt-1 mb-6">Kamu belum melakukan pembelian membership apapun.</p>
            <a href="{{ route('membership.index') }}" class="btn-primary text-sm px-6 py-3 rounded-xl inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Lihat Paket Membership
            </a>
        </div>
    @endif
</div>

</x-layouts.app>
