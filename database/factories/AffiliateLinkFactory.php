<?php

namespace Database\Factories;

use App\Models\AffiliateLink;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateLinkFactory extends Factory
{
    protected $model = AffiliateLink::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory();
        $marketplace = Marketplace::inRandomOrder()->first() ?? Marketplace::factory();
        $price = ProductPrice::where('product_id', $product->id)
            ->where('marketplace_id', $marketplace->id)
            ->first();

        return [
            'product_id' => $product->id,
            'marketplace_id' => $marketplace->id,
            'product_price_id' => $price?->id,
            'affiliate_url' => 'https://affiliate.example.com/' . fake()->uuid(),
            'campaign_name' => fake()->randomElement(['cekdulu', 'rekomendasi', 'promo-' . fake()->word()]),
            'is_active' => true,
            'click_count' => fake()->numberBetween(10, 5000),
        ];
    }
}
