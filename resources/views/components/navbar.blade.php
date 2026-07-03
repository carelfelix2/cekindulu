<nav class="nav">
    <a href="{{ route('home') }}" class="logo">Cek<span>Dulu</span></a>
    <div class="nav-links">
        <a href="{{ route('products.index') }}">Produk</a>
        <a href="{{ route('articles.index') }}">Artikel</a>
        <a href="{{ route('compare.index') }}">Bandingkan</a>
        <a href="{{ route('membership.index') }}">Membership</a>
    </div>
    <form action="{{ route('products.index') }}" method="GET" class="search-bar">
        <span>🔍</span>
        <input name="search" placeholder="Cari produk..." value="{{ request('search') }}">
    </form>

    {{-- Auth Section --}}
    <div class="nav-auth">
        @auth
            <div class="nav-dropdown">
                <button class="nav-dropdown-trigger">
                    <span class="nav-user-name">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->isPremium())
                        <span class="premium-badge" title="Premium Member">⭐</span>
                    @endif
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" class="nav-avatar">
                    @else
                        <span class="nav-avatar-placeholder">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    @endif
                    <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="nav-dropdown-menu">
                    <div class="dropdown-header">
                        <span class="dropdown-user-name">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->isPremium())
                                <span class="premium-badge-text">Premium</span>
                            @endif
                        </span>
                        <span class="dropdown-user-email">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <span style="color: #dc2626; font-weight: 600;">⚡ Admin Dashboard</span>
                        </a>
                        <a href="/admin" class="dropdown-item">
                            <span style="color: #dc2626; font-weight: 600;">🛠️ Filament Panel</span>
                        </a>
                    @else
                        <a href="{{ route('membership.transactions') }}" class="dropdown-item">Riwayat Transaksi</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profil Saya</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-item-danger">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="nav-auth-links">
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            </div>
        @endauth
    </div>
</nav>

@push('styles')
<style>
    /* ===== Nav Auth ===== */
    .nav-auth {
        display: flex;
        align-items: center;
        margin-left: 1rem;
    }

    .nav-auth-links {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .premium-badge {
        font-size: 1rem;
        line-height: 1;
    }

    .premium-badge-text {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 700;
        color: #92400e;
        background: #fef3c7;
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        margin-left: 0.35rem;
        vertical-align: middle;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-login {
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #4f46e5;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-login:hover {
        background: #eef2ff;
    }

    .btn-register {
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #fff;
        background: #4f46e5;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-register:hover {
        background: #4338ca;
    }

    /* ===== Dropdown ===== */
    .nav-dropdown {
        position: relative;
    }

    .nav-dropdown-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        font-size: 0.85rem;
        color: #374151;
        transition: border-color 0.2s;
    }
    .nav-dropdown-trigger:hover {
        border-color: #4f46e5;
    }

    .nav-user-name {
        font-weight: 500;
    }

    .nav-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
    }

    .nav-avatar-placeholder {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #4f46e5;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .dropdown-chevron {
        transition: transform 0.2s;
    }
    .nav-dropdown:hover .dropdown-chevron {
        transform: rotate(180deg);
    }

    .nav-dropdown-menu {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        min-width: 220px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-4px);
        transition: all 0.2s;
        z-index: 50;
    }
    .nav-dropdown:hover .nav-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 0.75rem 1rem;
    }
    .dropdown-user-name {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1a1a2e;
    }
    .dropdown-user-email {
        display: block;
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.15rem;
    }

    .dropdown-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 0;
    }

    .dropdown-item {
        display: block;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        color: #374151;
        text-decoration: none;
        transition: background 0.15s;
        cursor: pointer;
        border: none;
        width: 100%;
        text-align: left;
        background: none;
        font-family: inherit;
    }
    .dropdown-item:hover {
        background: #f9fafb;
    }
    .dropdown-item-danger {
        color: #ef4444;
    }
    .dropdown-item-danger:hover {
        background: #fef2f2;
    }
</style>
@endpush
