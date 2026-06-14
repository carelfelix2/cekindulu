<x-layouts.app title="Dashboard Member - CekDulu">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Dashboard Member</h1>
            <p>Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon">👤</div>
                <div class="card-content">
                    <h3>Profil Saya</h3>
                    <p>{{ Auth::user()->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm">Kelola Profil</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">🛒</div>
                <div class="card-content">
                    <h3>Produk Favorit</h3>
                    <p>Fitur coming soon</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">📊</div>
                <div class="card-content">
                    <h3>Riwayat Perbandingan</h3>
                    <p>Fitur coming soon</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon">🔗</div>
                <div class="card-content">
                    <h3>Transaksi Afiliasi</h3>
                    <p>Fitur coming soon</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .dashboard-header {
            margin-bottom: 2rem;
        }
        .dashboard-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .dashboard-header p {
            color: #6b7280;
            margin-top: 0.25rem;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .card-icon {
            font-size: 2rem;
            flex-shrink: 0;
        }
        .card-content h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0.25rem;
        }
        .card-content p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
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
