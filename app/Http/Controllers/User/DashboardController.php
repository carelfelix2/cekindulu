<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\Product;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // User statistics
        $stats = [
            'total_clicks' => AffiliateClick::where('user_id', $user->id)->count(),
            'total_transactions' => $user->transactions()->count(),
            'approved_points' => $user->total_approved_points,
            'pending_points' => $user->total_pending_points,
        ];

        // User's active membership
        $activeMembership = $user->activeMembership;

        // Membership status
        $membershipStatus = [
            'is_premium' => $user->isPremium(),
            'plan_name' => $activeMembership?->membershipPlan->name ?? 'Free',
            'expires_at' => $activeMembership?->ends_at,
            'days_remaining' => $activeMembership
                ? now()->diffInDays($activeMembership->ends_at, false)
                : null,
        ];

        // User's recent clicks
        $recentClicks = AffiliateClick::where('user_id', $user->id)
            ->with(['affiliateLink.product', 'affiliateLink.marketplace'])
            ->latest()
            ->take(10)
            ->get();

        // User's transactions
        $recentTransactions = $user->transactions()
            ->with('membershipPlan')
            ->latest()
            ->take(5)
            ->get();

        // User's reward points history
        $recentRewards = $user->rewardPoints()
            ->latest()
            ->take(10)
            ->get();

        // Recommended products
        $recommendedProducts = Product::with(['brand', 'category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'stats',
            'activeMembership',
            'membershipStatus',
            'recentClicks',
            'recentTransactions',
            'recentRewards',
            'recommendedProducts'
        ));
    }
}
