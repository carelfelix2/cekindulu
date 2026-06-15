<x-layouts.app title="Checkout - {{ $plan->name }} - CekDulu">
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <p>Selesaikan pembayaran untuk paket <strong>{{ $plan->name }}</strong></p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="checkout-grid">
            {{-- Order Summary --}}
            <div class="checkout-summary">
                <h2>Ringkasan Pesanan</h2>

                <div class="summary-card">
                    <div class="summary-row">
                        <span class="summary-label">Paket</span>
                        <span class="summary-value">{{ $plan->name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Durasi</span>
                        <span class="summary-value">{{ $plan->duration_label }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Harga</span>
                        <span class="summary-value summary-price">{{ $plan->formatted_price }}</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row summary-total">
                        <span class="summary-label">Total Pembayaran</span>
                        <span class="summary-value summary-price">{{ $plan->formatted_price }}</span>
                    </div>
                </div>

                @if($plan->features)
                    <div class="summary-features">
                        <h3>Fitur yang Didapatkan:</h3>
                        <ul>
                            @foreach($plan->features as $feature)
                                <li>✓ {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Payment Form --}}
            <div class="checkout-form">
                <h2>Instruksi Pembayaran</h2>

                <div class="payment-instructions">
                    <div class="bank-info">
                        <h3>Transfer Manual ke Rekening berikut:</h3>
                        <div class="bank-detail">
                            <span class="bank-label">Bank</span>
                            <span class="bank-value">Bank Central Asia (BCA)</span>
                        </div>
                        <div class="bank-detail">
                            <span class="bank-label">Nomor Rekening</span>
                            <span class="bank-value">1234567890</span>
                        </div>
                        <div class="bank-detail">
                            <span class="bank-label">Atas Nama</span>
                            <span class="bank-value">PT CekDulu Indonesia</span>
                        </div>
                        <div class="bank-detail">
                            <span class="bank-label">Total Transfer</span>
                            <span class="bank-value bank-amount">{{ $plan->formatted_price }}</span>
                        </div>
                    </div>

                    <div class="payment-steps">
                        <h3>Langkah-langkah:</h3>
                        <ol>
                            <li>Lakukan transfer sebesar <strong>{{ $plan->formatted_price }}</strong> ke rekening di atas</li>
                            <li>Simpan bukti transfer (screenshot / foto)</li>
                            <li>Upload bukti transfer pada form di bawah</li>
                            <li>Admin akan memverifikasi pembayaran dalam 1x24 jam</li>
                            <li>Setelah diverifikasi, membership akan aktif secara otomatis</li>
                        </ol>
                    </div>
                </div>

                <form action="{{ route('membership.checkout.process', $plan->slug) }}" method="POST" enctype="multipart/form-data" class="payment-form">
                    @csrf

                    <input type="hidden" name="payment_method" value="manual_transfer">

                    <div class="form-group">
                        <label for="payment_proof" class="form-label">Upload Bukti Transfer</label>
                        <input type="file" name="payment_proof" id="payment_proof"
                               class="form-control @error('payment_proof') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg" required>
                        <small class="form-text">Format: JPG/JPEG/PNG, maksimal 2MB</small>
                        @error('payment_proof')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('membership.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .checkout-header {
            margin-bottom: 2rem;
        }
        .checkout-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .checkout-header p {
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

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Summary */
        .checkout-summary h2,
        .checkout-form h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 1rem;
        }

        .summary-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }
        .summary-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        .summary-value {
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .summary-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #4f46e5;
        }
        .summary-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 0.5rem 0;
        }
        .summary-total {
            padding-top: 0.5rem;
        }

        .summary-features {
            margin-top: 1.5rem;
        }
        .summary-features h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .summary-features ul {
            list-style: none;
            padding: 0;
        }
        .summary-features li {
            padding: 0.3rem 0;
            font-size: 0.85rem;
            color: #374151;
        }

        /* Payment Instructions */
        .payment-instructions {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .bank-info {
            margin-bottom: 1.5rem;
        }
        .bank-info h3,
        .payment-steps h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
        }

        .bank-detail {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 0.9rem;
        }
        .bank-label {
            color: #6b7280;
        }
        .bank-value {
            color: #374151;
            font-weight: 500;
        }
        .bank-amount {
            color: #4f46e5;
            font-weight: 700;
        }

        .payment-steps ol {
            padding-left: 1.25rem;
        }
        .payment-steps li {
            padding: 0.3rem 0;
            font-size: 0.85rem;
            color: #374151;
        }

        /* Form */
        .payment-form {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        .form-control.is-invalid {
            border-color: #dc2626;
        }
        .form-text {
            display: block;
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 0.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
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
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary {
            background: #4f46e5;
            color: #fff;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
        }
    </style>
    @endpush
</x-layouts.app>
