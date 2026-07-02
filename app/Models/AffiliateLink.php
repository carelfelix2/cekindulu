<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'marketplace_id',
        'product_price_id',
        'affiliate_url',
        'campaign_name',
        'is_active',
        'click_count',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'click_count' => 'integer',
        ];
    }

    /**
     * Get the product this affiliate link is for.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the marketplace this affiliate link is for.
     */
    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    /**
     * Get the specific product price this link is associated with (optional).
     */
    public function productPrice(): BelongsTo
    {
        return $this->belongsTo(ProductPrice::class);
    }

    /**
     * Get all click records for this affiliate link.
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(AffiliateClick::class);
    }
}
