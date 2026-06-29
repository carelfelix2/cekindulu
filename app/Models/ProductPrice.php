<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'marketplace_id',
        'seller_name',
        'product_url',
        'price',
        'original_price',
        'discount',
        'rating',
        'sold_count',
        'review_count',
        'is_recommended',
        'last_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'original_price' => 'integer',
            'rating' => 'float',
            'sold_count' => 'integer',
            'review_count' => 'integer',
            'is_recommended' => 'boolean',
            'last_updated_at' => 'datetime',
        ];
    }

    /**
     * Get the product this price belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the marketplace this price is from.
     */
    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    /**
     * Get affiliate links associated with this specific price.
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class, 'product_price_id');
    }
}
