<x-layouts.app title="Riwayat Transaksi - CekDulu">
    <div class="transactions-container">
        <div class="transactions-header">
            <h1>Riwayat Transaksi</h1>
            <p>Daftar transaksi membership kamu</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($transactions->count() > 0)
            <div class="transactions-list">
                @foreach($transactions as $transaction)
                    <a href="{{ route('membership.transactions.detail', $transaction->invoice_number) }}" class="transaction-card">
                        <div class="transaction-info">
                            <span class="transaction-invoice">{{ $transaction->invoice_number }}</span>
                            <span class="transaction-plan">{{ $transaction->membershipPlan->name }}</span>
                            <span class="transaction-date">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="transaction-meta">
                            <span class="transaction-amount">{{ $transaction->formatted_amount }}</span>
                            <span class="transaction-status status-{{ $transaction->status }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div class="transaction-arrow">→</div>
                    </a>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>Belum Ada Transaksi</h3>
                <p>Kamu belum melakukan pembelian membership apapun.</p>
                <a href="{{ route('membership.index') }}" class="btn btn-primary">Lihat Paket Membership</a>
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        .transactions-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .transactions-header {
            margin-bottom: 2rem;
        }
        .transactions-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .transactions-header p {
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .alert-success {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .transactions-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .transaction-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .transaction-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .transaction-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }
        .transaction-invoice {
            font-size: 0.8rem;
            color: #6b7280;
            font-family: monospace;
        }
        .transaction-plan {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a2e;
        }
        .transaction-date {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .transaction-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.3rem;
        }
        .transaction-amount {
            font-size: 1rem;
            font-weight: 700;
            color: #4f46e5;
        }

        .transaction-status {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            text-transform: uppercase;
        }
        .status-paid {
            background: #f0fdf4;
            color: #16a34a;
        }
        .status-pending {
            background: #fefce8;
            color: #ca8a04;
        }
        .status-failed {
            background: #fef2f2;
            color: #dc2626;
        }
        .status-expired {
            background: #f3f4f6;
            color: #6b7280;
        }
        .status-cancelled {
            background: #f3f4f6;
            color: #6b7280;
        }

        .transaction-arrow {
            color: #d1d5db;
            font-size: 1.25rem;
        }

        .pagination-wrapper {
            margin-top: 2rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        .empty-state p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-primary {
            background: #4f46e5;
            color: #fff;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
    </style>
    @endpush
</x-layouts.app>
