<x-layouts.app title="Detail Transaksi - {{ $transaction->invoice_number }} - CekDulu">
    <div class="detail-container">
        <div class="detail-header">
            <a href="{{ route('membership.transactions') }}" class="btn-back">← Kembali ke Riwayat</a>
            <h1>Detail Transaksi</h1>
        </div>

        <div class="detail-card">
            <div class="detail-status-bar status-{{ $transaction->status }}">
                <span class="status-label">{{ ucfirst($transaction->status) }}</span>
                @if($transaction->status === 'paid')
                    <span class="status-date">Lunas pada {{ $transaction->paid_at->format('d M Y, H:i') }}</span>
                @endif
            </div>

            <div class="detail-body">
                <div class="detail-section">
                    <h3>Informasi Transaksi</h3>
                    <div class="detail-row">
                        <span class="detail-label">Invoice</span>
                        <span class="detail-value mono">{{ $transaction->invoice_number }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Paket</span>
                        <span class="detail-value">{{ $transaction->membershipPlan->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Durasi</span>
                        <span class="detail-value">{{ $transaction->membershipPlan->duration_label }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jumlah</span>
                        <span class="detail-value detail-amount">{{ $transaction->formatted_amount }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value">Transfer Manual (BCA)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal</span>
                        <span class="detail-value">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($transaction->paid_at)
                        <div class="detail-row">
                            <span class="detail-label">Dibayar Pada</span>
                            <span class="detail-value">{{ $transaction->paid_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if($transaction->expires_at)
                        <div class="detail-row">
                            <span class="detail-label">Batas Pembayaran</span>
                            <span class="detail-value">{{ $transaction->expires_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>

                @if($transaction->payment_proof)
                    <div class="detail-section">
                        <h3>Bukti Pembayaran</h3>
                        <div class="payment-proof-wrapper">
                            <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                                 alt="Bukti Pembayaran"
                                 class="payment-proof-img"
                                 onclick="window.open(this.src, '_blank')">
                        </div>
                        <p class="proof-hint">Klik gambar untuk melihat ukuran penuh</p>
                    </div>
                @endif

                @if($transaction->admin_notes)
                    <div class="detail-section">
                        <h3>Catatan Admin</h3>
                        <div class="admin-notes">
                            {{ $transaction->admin_notes }}
                        </div>
                    </div>
                @endif

                @if($transaction->userMembership)
                    <div class="detail-section">
                        <h3>Status Membership</h3>
                        <div class="membership-status-info">
                            <div class="detail-row">
                                <span class="detail-label">Mulai</span>
                                <span class="detail-value">{{ $transaction->userMembership->started_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Berakhir</span>
                                <span class="detail-value">{{ $transaction->userMembership->ends_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    @if($transaction->userMembership->isValid())
                                        <span class="badge-active">Aktif</span>
                                    @else
                                        <span class="badge-expired">Kadaluarsa</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .detail-container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .detail-header {
            margin-bottom: 1.5rem;
        }
        .detail-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 0.5rem;
        }

        .btn-back {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .btn-back:hover {
            text-decoration: underline;
        }

        .detail-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .detail-status-bar {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-paid {
            background: #f0fdf4;
            border-bottom: 2px solid #16a34a;
        }
        .status-pending {
            background: #fefce8;
            border-bottom: 2px solid #ca8a04;
        }
        .status-failed {
            background: #fef2f2;
            border-bottom: 2px solid #dc2626;
        }
        .status-expired,
        .status-cancelled {
            background: #f3f4f6;
            border-bottom: 2px solid #6b7280;
        }

        .status-label {
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-paid .status-label { color: #16a34a; }
        .status-pending .status-label { color: #ca8a04; }
        .status-failed .status-label { color: #dc2626; }
        .status-expired .status-label,
        .status-cancelled .status-label { color: #6b7280; }

        .status-date {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .detail-body {
            padding: 1.5rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }
        .detail-section:last-child {
            margin-bottom: 0;
        }

        .detail-section h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }
        .detail-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        .detail-value {
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .detail-amount {
            color: #4f46e5;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .mono {
            font-family: monospace;
            font-size: 0.85rem;
        }

        .payment-proof-wrapper {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            cursor: pointer;
        }
        .payment-proof-img {
            width: 100%;
            height: auto;
            display: block;
        }
        .proof-hint {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 0.5rem;
            text-align: center;
        }

        .admin-notes {
            background: #f9fafb;
            border-radius: 8px;
            padding: 1rem;
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.5;
        }

        .badge-active {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #f0fdf4;
            color: #16a34a;
        }
        .badge-expired {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #f3f4f6;
            color: #6b7280;
        }
    </style>
    @endpush
</x-layouts.app>
