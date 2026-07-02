<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory();
        return [
            'product_id' => $product,
            'image_url' => 'https://picsum.photos/seed/' . fake()->uuid() . '/800/600',
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
