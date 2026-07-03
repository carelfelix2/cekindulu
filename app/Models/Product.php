<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'pros',
        'cons',
        'thumbnail',
        'worth_it_score',
        'lowest_price',
        'status',
        'is_featured',
        'is_trending',
        'admin_score_adjustment',
    ];

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'pros' => 'array',
            'cons' => 'array',
            'worth_it_score' => 'integer',
            'lowest_price' => 'integer',
            'admin_score_adjustment' => 'integer',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include published products.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     *
     * @return BelongsTo<Brand, Product>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the images for the product.
     *
     * @return HasMany<ProductImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the prices for the product.
     *
     * @return HasMany<ProductPrice>
     */
    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Get the affiliate links for the product.
     *
     * @return HasMany<AffiliateLink>
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }

    /**
     * Get the affiliate clicks for the product.
     *
     * @return HasMany<AffiliateClick>
     */
    public function affiliateClicks(): HasMany
    {
        return $this->hasMany(AffiliateClick::class);
    }

    /**
     * The articles that reference this product.
     *
     * @return BelongsToMany<Article>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_product');
    }

    /**
     * Get the best (lowest) price among all product prices.
     */
    public function bestPrice()
    {
        return $this->prices->sortBy('price')->first();
    }
}
