<x-layouts.app title="Membership Premium - CekDulu">
    <div class="membership-container">
        <div class="membership-header">
            <h1>Menjadi Member Premium</h1>
            <p>Dapatkan akses ke fitur eksklusif CekDulu dengan berlangganan paket membership</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="plans-grid">
            @forelse($plans as $plan)
                <div class="plan-card">
                    <div class="plan-header">
                        <h3 class="plan-name">{{ $plan->name }}</h3>
                        <div class="plan-price">
                            <span class="price">{{ $plan->formatted_price }}</span>
                            <span class="price-period">/ {{ $plan->duration_label }}</span>
                        </div>
                    </div>

                    <div class="plan-description">
                        <p>{{ $plan->description }}</p>
                    </div>

                    @if($plan->features)
                        <ul class="plan-features">
                            @foreach($plan->features as $feature)
                                <li class="plan-feature-item">
                                    <span class="feature-check">✓</span>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="plan-action">
                        @auth
                            <a href="{{ route('membership.checkout', $plan->slug) }}" class="btn btn-primary btn-block">
                                Beli Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                Masuk untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Belum ada paket membership tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="membership-info">
            <h2>Keuntungan Member Premium</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">🔔</div>
                    <h3>Price Alert</h3>
                    <p>Dapatkan notifikasi saat harga produk turun ke harga yang kamu inginkan.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">🏷️</div>
                    <h3>Exclusive Deals</h3>
                    <p>Akses kode promo dan diskon eksklusif yang hanya tersedia untuk member premium.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">⭐</div>
                    <h3>Badge Premium</h3>
                    <p>Tampilkan badge "Premium Member" di profil dan aktivitas kamu di CekDulu.</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .membership-container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .membership-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .membership-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .membership-header p {
            color: #6b7280;
            margin-top: 0.5rem;
            font-size: 1.1rem;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .plan-card {
            background: #fff;
            border-radius: 16px;
            border: 2px solid #e5e7eb;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            transition: border-color 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .plan-card:hover {
            border-color: #4f46e5;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.1);
        }

        .plan-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .plan-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0.75rem;
        }
        .plan-price {
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 0.25rem;
        }
        .price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #4f46e5;
        }
        .price-period {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .plan-description {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem;
            flex: 1;
        }
        .plan-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #374151;
        }
        .feature-check {
            color: #16a34a;
            font-weight: 700;
            flex-shrink: 0;
        }

        .plan-action {
            margin-top: auto;
        }
        .btn-block {
            display: block;
            width: 100%;
            text-align: center;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        /* Benefits Section */
        .membership-info {
            text-align: center;
        }
        .membership-info h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 2rem;
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .benefit-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .benefit-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .benefit-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        .benefit-card p {
            color: #6b7280;
            font-size: 0.9rem;
        }
    </style>
    @endpush
</x-layouts.app>
