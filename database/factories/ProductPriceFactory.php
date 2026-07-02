<?php

namespace Database\Factories;

use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory();
        $marketplace = Marketplace::inRandomOrder()->first() ?? Marketplace::factory();
        $originalPrice = $product->lowest_price * fake()->randomFloat(1, 1.1, 1.5);
        $discountPercent = fake()->numberBetween(5, 40);
        $discountPrice = (int) round($originalPrice * (1 - $discountPercent / 100));
        $sellerNames = [
            'Shopee' => ['Official Store', 'Toko Abadi Jaya', 'GadgetZone', 'Elektronik Digital', 'Tech Haven'],
            'Tokopedia' => ['Official Store', 'Power Merchant', 'Digital Station', 'Gadget Expert', 'Home Elektronik'],
            'Lazada' => ['LazMall Official', 'Mega Elektronik', 'Digital Hub', 'TechWorld', 'Gadget Pro'],
            'Blibli' => ['Official Store', 'Blibli Superstore', 'Digital Prime', 'Gadget House', 'Electro Shop'],
            'Bukalapak' => ['Official Store', 'Buka Elektronik', 'Gadget Square', 'Digital Mart', 'Tech Solution'],
        ];

        return [
            'product_id' => $product->id,
            'marketplace_id' => $marketplace->id,
            'seller_name' => fake()->randomElement($sellerNames[$marketplace->name] ?? ['Official Store', 'Toko Online']),
            'product_url' => 'https://www.' . strtolower($marketplace->name) . '.co.id/product/' . $product->slug . '-' . fake()->randomNumber(8),
            'price' => $discountPrice,
            'original_price' => (int) $originalPrice,
            'discount' => $discountPercent,
            'rating' => fake()->randomFloat(2, 3.5, 5.0),
            'sold_count' => fake()->numberBetween(10, 50000),
            'review_count' => fake()->numberBetween(5, 8000),
            'is_recommended' => fake()->boolean(10),
            'last_updated_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
