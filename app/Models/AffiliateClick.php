<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateClick extends Model
{
    protected $fillable = [
        'user_id',
        'affiliate_link_id',
        'product_id',
        'marketplace_id',
        'ip_address',
        'user_agent',
        'referrer',
    ];

    /**
     * Get the user who clicked (nullable for guests).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the affiliate link that was clicked.
     */
    public function affiliateLink(): BelongsTo
    {
        return $this->belongsTo(AffiliateLink::class);
    }

    /**
     * Get the product associated with this click.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the marketplace associated with this click.
     */
    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    /**
     * Get the reward point associated with this click.
     */
    public function rewardPoint()
    {
        return $this->hasOne(RewardPoint::class, 'source_id')
            ->where('source_type', 'affiliate_click');
    }
}
