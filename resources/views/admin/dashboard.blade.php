<x-layouts.app title="Admin Dashboard">

{{-- Header --}}
<div class="bg-gradient-to-r from-red-600 to-red-700 border-b border-red-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-white font-display tracking-tight">Admin Dashboard</h1>
                </div>
                <p class="text-sm text-red-100">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span>! Kelola seluruh sistem CekDulu.</p>
            </div>
            <div class="flex gap-2">
                <a href="/admin" class="btn btn-sm bg-white/15 hover:bg-white/25 text-white border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Filament Panel
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Total Users</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_users']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Registered users</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Total Products</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_products']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">In database</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Total Revenue</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">From {{ $stats['total_transactions'] }} transactions</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Premium Users</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['active_premium_users']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Active subscriptions</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Affiliate Clicks</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_affiliate_clicks']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Total clicks</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-cyan-50 dark:bg-cyan-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Marketplaces</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_marketplaces']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Active marketplaces</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Pending Payments</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['pending_payments']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Awaiting confirmation</p>
        </div>

        <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-xs text-surface-500 dark:text-surface-400 font-medium uppercase tracking-wider">Transactions</p>
            </div>
            <p class="text-2xl font-extrabold text-surface-900 dark:text-white font-display tracking-tight">{{ number_format($stats['total_transactions']) }}</p>
            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">All time</p>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-6">
        <h3 class="font-bold text-surface-900 dark:text-white font-display text-sm mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            Transaksi Terbaru
        </h3>
        @if($recent_transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs text-surface-500 dark:text-surface-400 uppercase border-b border-surface-200 dark:border-surface-800">
                        <tr>
                            <th class="text-left py-3 px-2">Invoice</th>
                            <th class="text-left py-3 px-2">User</th>
                            <th class="text-left py-3 px-2">Plan</th>
                            <th class="text-right py-3 px-2">Amount</th>
                            <th class="text-center py-3 px-2">Status</th>
                            <th class="text-center py-3 px-2">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-800">
                        @foreach($recent_transactions as $transaction)
                        <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50">
                            <td class="py-3 px-2 font-mono text-xs">{{ $transaction->invoice_number }}</td>
                            <td class="py-3 px-2">{{ $transaction->user->name }}</td>
                            <td class="py-3 px-2">{{ $transaction->membershipPlan->name }}</td>
                            <td class="py-3 px-2 text-right font-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-2 text-center">
                                @if($transaction->status === 'paid')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">Paid</span>
                                @elseif($transaction->status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">Pending</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">{{ ucfirst($transaction->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-2 text-center text-xs text-surface-500">{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center py-8 text-surface-500 dark:text-surface-400">Belum ada transaksi</p>
        @endif
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="/admin/users" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Kelola Users</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Manage all users</p>
            </div>
        </a>

        <a href="/admin/products" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Kelola Products</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Manage products</p>
            </div>
        </a>

        <a href="/admin/transactions" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Kelola Transaksi</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Manage transactions</p>
            </div>
        </a>

        <a href="/admin/articles" class="group bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-5 flex items-center gap-4 hover:border-primary-300 dark:hover:border-primary-700 hover:-translate-y-0.5 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-surface-800 dark:text-surface-200 group-hover:text-primary-700 dark:group-hover:text-primary-400 transition-colors">Kelola Artikel</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Manage articles</p>
            </div>
        </a>
    </div>
</div>

</x-layouts.app>
