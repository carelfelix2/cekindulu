<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\AffiliateLink;
use App\Models\Article;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\RewardPoint;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // User Statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'active_premium_users' => User::whereHas('activeMembership')->count(),

            // Product & Marketplace Stats
            'total_products' => Product::where('status', 'published')->count(),
            'total_marketplaces' => Marketplace::where('is_active', true)->count(),
            'total_affiliate_links' => AffiliateLink::where('is_active', true)->count(),

            // Affiliate Click Stats
            'total_affiliate_clicks' => AffiliateClick::count(),
            'clicks_today' => AffiliateClick::whereDate('created_at', today())->count(),
            'clicks_this_month' => AffiliateClick::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),

            // Transaction Stats
            'total_transactions' => Transaction::count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'pending_payments' => Transaction::where('status', 'pending')->count(), // Alias for view compatibility
            'paid_transactions' => Transaction::where('status', 'paid')->count(),
            'failed_transactions' => Transaction::where('status', 'failed')->count(),

            // Revenue Stats
            'total_revenue' => Transaction::where('status', 'paid')->sum('amount'),
            'revenue_today' => Transaction::where('status', 'paid')
                ->whereDate('paid_at', today())
                ->sum('amount'),
            'revenue_this_month' => Transaction::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),

            // Reward Points Stats
            'pending_reward_points' => RewardPoint::where('status', 'pending')->sum('points'),
            'approved_reward_points' => RewardPoint::where('status', 'approved')->sum('points'),

            // Membership Stats
            'expired_memberships' => UserMembership::where('is_active', true)
                ->where('ends_at', '<', now())
                ->count(),
        ];

        // Recent data
        $recent_users = User::latest()->take(10)->get();
        $recent_transactions = Transaction::with(['user', 'membershipPlan'])
            ->latest()
            ->take(10)
            ->get();
        $recent_clicks = AffiliateClick::with(['user', 'affiliateLink.product', 'affiliateLink.marketplace'])
            ->latest()
            ->take(10)
            ->get();

        // Top performing data
        $top_products = Product::withCount('affiliateClicks')
            ->orderBy('affiliate_clicks_count', 'desc')
            ->take(10)
            ->get();

        $top_marketplaces = Marketplace::withCount('affiliateClicks')
            ->orderBy('affiliate_clicks_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_transactions',
            'recent_clicks',
            'top_products',
            'top_marketplaces'
        ));
    }
}
