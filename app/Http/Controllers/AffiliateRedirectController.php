<?php

namespace App\Http\Controllers;

use App\Models\AffiliateClick;
use App\Models\AffiliateLink;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateRedirectController extends Controller
{
    public function go(Request $request, AffiliateLink $affiliateLink)
    {
        abort_unless($affiliateLink->is_active, 404);

        $userId = Auth::id();
        $ipAddress = $request->ip();

        // Record the click
        $click = AffiliateClick::create([
            'user_id' => $userId,
            'affiliate_link_id' => $affiliateLink->id,
            'product_id' => $affiliateLink->product_id,
            'marketplace_id' => $affiliateLink->marketplace_id,
            'ip_address' => $ipAddress,
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            'referrer' => substr((string) $request->headers->get('referer'), 0, 1000),
        ]);

        // Increment click count
        $affiliateLink->increment('click_count');

        // Award points to logged-in users (with anti-spam protection)
        if ($userId) {
            $this->awardRewardPoints($userId, $click, $ipAddress);
        }

        // Redirect to affiliate URL
        return redirect()->away($affiliateLink->affiliate_url);
    }

    /**
     * Award reward points with anti-spam protection.
     */
    protected function awardRewardPoints(int $userId, AffiliateClick $click, string $ipAddress): void
    {
        $affiliateLinkId = $click->affiliate_link_id;
        $pointsToAward = 10; // Default points per click

        // Anti-spam: Check if user already got reward for this link in last 24 hours
        $recentUserReward = RewardPoint::where('user_id', $userId)
            ->where('source_type', 'affiliate_click')
            ->whereHas('source', function ($query) use ($affiliateLinkId) {
                // This is a simplified check - in production you might want to join with affiliate_clicks
            })
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($recentUserReward) {
            return; // User already got reward for this link recently
        }

        // Anti-spam: Check if IP already got reward for this link in last 24 hours
        $recentIpReward = AffiliateClick::where('ip_address', $ipAddress)
            ->where('affiliate_link_id', $affiliateLinkId)
            ->whereHas('rewardPoint')
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($recentIpReward) {
            return; // IP already got reward for this link recently
        }

        // Create pending reward point
        RewardPoint::create([
            'user_id' => $userId,
            'source_type' => 'affiliate_click',
            'source_id' => $click->id,
            'points' => $pointsToAward,
            'status' => 'pending',
            'notes' => 'Reward from affiliate click',
        ]);
    }
}
